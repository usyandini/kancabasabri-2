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
                  <h3 class="content-header-title mb-0">Report Realisasi</h3>
                  <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-xs-12">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/transaksi">Transaksi</a>
                        </li>
                        <li class="breadcrumb-item active">Report Realisasi
                        </li>
                      </ol>
                    </div>
                  </div>
                </div>
              </div>
              <div class="content-body"><!-- Basic scenario start -->
                <section id="basic">
                  <div class="row">
                    @can('cari_t')
                    <div class="col-xs-7">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">Pencarian Report</h4>
                          <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                        </div>
                        <div class="card-body collapse in">
                          <div class="card-block">
                            <form method="POST" action="{{ url('transaksi/filter/reports') }}">
                              <div class="row">
                                {{ csrf_field() }}
                                <div class="col-xs-5">
                                  <div class="form-group">
                                    <label>Kantor Cabang</label>
                                    <select class="select2 form-control" name="cabang" required>
                                      <option selected disabled>Pilih cabang</option>
                                      @foreach($cabang as $cab)
                                      <option value="{{ $cab->VALUE }}" {{ $filters['cabang'] == $cab->VALUE ? 'selected=""' : '' }}>{{ $cab->DESCRIPTION }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-xs-3">
                                  <div class="form-grpup">
                                    <label>Periode</label>
                                    <select class="select2 form-control" name="periode" required>
                                      <option selected disabled>Pilih Periode</option>
                                      <option {{ $filters['periode'] == '1' ? 'selected=""' : '' }} value="1">I</option>
                                      <option {{ $filters['periode'] == '2' ? 'selected=""' : '' }} value="2">II</option>
                                      <option {{ $filters['periode'] == '3' ? 'selected=""' : '' }} value="3">III</option>
                                      <option {{ $filters['periode'] == '4' ? 'selected=""' : '' }} value="4">IV</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-xs-4">
                                  <div class="form-group">
                                    <label>Tahun</label>
                                    <select class="select2 form-control" name="transyear" required>
                                      <option selected disabled
                                      >Pilih Tahun</option>
                                      <?php
                                        $thn_skr = date('Y');
                                        for($x=$thn_skr; $x >= 2005; $x--){
                                      ?>
                                        <option {{ ($filters['transyear'] == $x) ? 'selected=""' : '' }} value="{{$x}}" {{ ($x == $filters['transyear'] ? 'selected=""' : '') }}>{{$x}}</option>
                                        <?php }?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-xs-2">
                                  <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</a>
                                    </div>
                                  </div>
                                  @if($filters)
                                  <div class="col-xs-2">
                                    <div class="form-group">
                                      <a href="{{ url('transaksi/report/realisasi') }}" class="btn btn-danger"><i class="fa fa-times"></i> Reset pencarian</a>
                                    </div>
                                  </div>
                                  @endif
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endcan                    
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="card">
                          <div class="card-header">
                            @if ($filters)
                            <h4 class="card-title">Hasil Pencarian Transaksi</h4><br>
                            @else
                            <h4 class="card-title">Daftar Realisasi</h4><br>
                            @endif
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <table align="right"><tr>
                              <td><span><a href="{{ URL('transaksi/print/realisasi/'.$filters['cabang'].'/'.$filters['periode'].'/'.$filters['transyear'].'/export') }}" class="btn btn-success" target="_blank"><i class="fa fa-file-pdf-o"></i> <b> Ekspor ke PDF </b></a></span></td>

                              <td><span><a href="{{ URL('transaksi/print/realisasi/'.$filters['cabang'].'/'.$filters['periode'].'/'.$filters['transyear'].'/print') }}" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> <b> Cetak Realisasi </b></a></span></td> 
                            </tr></table>
                          </div>
                          <div class="card-body collapse in ">
                            <div class="card-block card-dashboard ">
                              <name="data" id="data">
			                  	<div class="table-responsive">
			                      <table class="table table-striped table-bordered datatable-select-inputs wrap" cellspacing="0" width="120%">
			                        <thead>
			                          <tr align="middle">
			                          	<th width="5%"><center>No</center></th>
			                          	<th id="filterable"><center>Deskripsi Anggaran</center></th>
			                            <th id="filterable">Anggaran</th>
			                            <th id="filterable">Realisasi Periode</th>
			                            <th id="filterable">Sisa Anggaran</th>
			                          </tr>
			                        </thead>
			                        <tbody>
                                @if($filters)
                                  <?php $no=1; ?>
                                  @foreach($transaksi as $trans)
  		                        		<tr>
  		                        			<td><center>{{ $no++ }}</center></td>
  		                        			<td>{{$items->where('SEGMEN_1',$trans->item)->first()['nama_item']}}</td>
  		                        			<td>Rp. {{ number_format($trans->anggaran, 2, ',','.') }}</td>
  		                        			<td>Rp. {{ number_format($trans->total, 2, ',','.') }}</td>
  		                        			<td>Rp. {{ number_format($trans->actual_anggaran, 2, ',','.') }}</td>
  		                        		</tr>
                                  @endforeach
                                @endif
			                        </tbody>
			                      </table>
			                    </div>
                            </div>
                          </div>
                        </div>
                      </div>
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
              <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}" type="text/javascript"></script>
              <!-- END PAGE VENDOR JS-->
              <!-- BEGIN PAGE LEVEL JS-->
              <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
              <!-- END PAGE LEVEL JS-->
              @endsection