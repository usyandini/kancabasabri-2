                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <style type="text/css">
                .hide {
                  display: none;
                }
                .jsgrid-row .jsgrid-cell, .jsgrid-alt-row .jsgrid-cell {
                  background: inherit;
                }
                .contoh {
                  background: rgb(247, 137, 136);
                }
              </style>
              @endsection

              @section('content')
              <div class="content-header row">
                <div class="content-header-left col-md-6 col-xs-12 mb-2">
                  <h3 class="content-header-title mb-0">Report Realisasi Mata Anggaran</h3>
                  <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-xs-12">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/transaksi">Transaksi</a>
                        </li>
                        <li class="breadcrumb-item active">Report Realisasi Mata Anggaran
                        </li>
                      </ol>
                    </div>
                  </div>
                </div>
              </div>
              <div class="content-body"><!-- Basic scenario start -->
                <section id="basic">
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">Pencarian Report</h4>
                          <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                        </div>
                        <div class="card-body collapse in">
                          <div class="card-block">
                            <form method="POST" action="{{ url('transaksi/filter/reports') }}">
                              @if(count($errors->all()) > 0)
                              <div class="row">
                                <div class="col-xs-4">
                                  <div class="alert alert-danger alert-dismissable">
                                    @foreach ($errors->all() as $error)
                                    {!! $error !!}<br>
                                    @endforeach
                                  </div>
                                </div>
                              </div>
                              @endif
                              <div class="row">
                                {{ csrf_field() }}
                                <div class="col-xs-3 col-xl-3">
                                  <div class="form-group">
                                    <label>Kantor Cabang</label>
                                    <select class="select2 form-control" name="cabang" required>
                                      <!-- <option selected disabled>Pilih cabang</option> -->
                                      @foreach($cabang as $cab)
                                      {{ $id = $cab->VALUE."00" }}
                                      @if(Gate::check("unit_".$id) )
                                      <option value="{{ $cab->VALUE }}" {{ ($filters['cabang'] == $cab->VALUE ? 'selected=""' : (old('cabang') == $cab->VALUE ? 'selected=""' : '')) }}>{{ $cab->DESCRIPTION }}</option>
                                      @endif
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-xl-3 col-xs-3 col-md-3">
                                  <div class="form-grpup">
                                    <label>Periode Awal</label>
                                    <select class="select2 form-control" name="awal" required>
                                      <option selected disabled>Pilih Periode Awal</option>
                                      @foreach($months as $month)
                                      <option value="{{ array_search($month, $months) }}" {{ ($filters['awal'] == array_search($month, $months) ? 'selected=""' : (old('awal') == array_search($month, $months) ? 'selected=""' : '')) }}>{{ $month }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-xl-3 col-xs-3">
                                  <div class="form-grpup">
                                    <label>Periode Akhir</label>
                                    <select class="select2 form-control" name="akhir" required>
                                      <option selected disabled>Pilih Periode Akhir</option>
                                      @foreach($months as $month)
                                      <option value="{{ array_search($month, $months) }}" {{ ($filters['akhir'] == array_search($month, $months)? 'selected=""' : (old('akhir') == array_search($month, $months) ? 'selected=""' : '')) }}>{{ $month }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-xl-3 col-xs-3">
                                  <div class="form-group">
                                    <label>Tahun</label>
                                    <select class="select2 form-control" name="transyear" required>
                                      <option selected disabled>Pilih Tahun</option>
                                      <?php
                                      $thn_skr = date('Y');
                                      for ($x = $thn_skr;$x >= 2005;$x--){?>
                                        <option {{ ($filters['transyear'] == $x) ? 'selected=""' : '' }} value="{{$x}}" {{ ($x == $filters['transyear'] ? 'selected=""' : (old('transyear') == $x ? 'selected=""' : '')) }}>{{$x}}</option>
                                        <?php }?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-xs-6">
                                    <button type="submit" class="btn btn-outline-primary"><i class="fa fa-search"></i> Cari</button>
                                    @if($filters)
                                    <a href="{{ url('transaksi/report/realisasi') }}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>                   
                    </div>
                    @if ($filters)
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="card">
                          <div class="card-header">
                            @if ($filters)
                            <h4 class="card-title">Hasil Pencarian Realisasi</h4><br>
                            <div class="row">
                              @if ($transaksi)
                              <div class="col-md-12">
                                <a href="{{ URL('transaksi/realisasi/'.$filters['cabang'].'/'.$filters['awal'].'/'.$filters['akhir'].'/'.$filters['transyear'].'/excel') }}" class="btn btn-success btn-sm pull-right mr-1" target="_blank"><i class="fa fa-file-excel-o"></i> Ekspor ke Excel</a>
                                <a href="{{ URL('transaksi/realisasi/'.$filters['cabang'].'/'.$filters['awal'].'/'.$filters['akhir'].'/'.$filters['transyear'].'/export') }}" class="btn btn-success btn-sm pull-right mr-1" target="_blank"><i class="fa fa-file-pdf-o"></i> Ekspor ke PDF</a>
                                <a href="{{ URL('transaksi/realisasi/'.$filters['cabang'].'/'.$filters['awal'].'/'.$filters['akhir'].'/'.$filters['transyear'].'/print') }}" class="btn btn-success btn-sm pull-right mr-1" target="_blank"><i class="fa fa-print"></i> Cetak Realisasi</a>
                              </div>
                              @endif
                            </div>
                            @else
                            <h4 class="card-title">Daftar Realisasi</h4><br>
                            @endif
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            
                          </div>
                          <div class="card-body collapse in ">
                            <div class="card-block card-dashboard ">
                              <name="data" id="data">
                              <div class="table-responsive">
                               <table class="table table-striped table-bordered datatable-select-inputs wrap" cellspacing="0" width="120%">
                                 <thead>
                                   <tr align="middle">
                                    <th id="filterable"><center>Deskripsi Anggaran</center></th>
                                    <th id="filterable"><center>Anggaran</center></th>
                                    <th id="filterable"><center>Realisasi Periode</center></th>
                                    <th id="filterable"><center>Sisa Anggaran</center></th>
                                  </tr>
                                 </thead>
                                <tbody>
                                  @if($filters)
                                  <?php $no=1; ?>
                                  @forelse($transaksi as $trans)
                                  <?php
                                  $mata=$trans->mata_anggaran;
                                  $a = DB::table('item_master_transaksi')
                                   ->where('SEGMEN_6', $mata)->first();
                                   $nama=$a->nama_item;
                                  ?>
                                  <tr>
                                   <td>{{ $nama }}</td>
                                   <td align=right>Rp. {{ number_format($trans->anggaran, 0, '', '.') }}</td>
                                   <td align=right><b>Rp. {{ number_format($trans->realisasi, 0, '', '.') }}</b></td>
                                   <td align=right>Rp. {{ number_format($trans->sisa_anggaran, 0, '', '.') }}</td>
                                 </tr>
                                 @empty
                                 <tr>
                                   <td colspan="4">Data tidak ditemukan.</td>
                                 </tr>
                                 @endforelse
                                 @endif
                               </tbody>
                             </table>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>
                   @endif
                 </div>
               </section>
               <!-- Basic scenario end -->
             </div>
           </div>
           @endsection

           @section('customjs')
           <!-- BEGIN PAGE VENDOR JS-->
           <script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
           <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
           <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script>
           <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/griddata.js') }}" type="text/javascript"></script>
           <!-- END PAGE VENDOR JS-->
           <!-- BEGIN PAGE LEVEL JS-->
           <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
           <!-- END PAGE LEVEL JS-->
           @endsection