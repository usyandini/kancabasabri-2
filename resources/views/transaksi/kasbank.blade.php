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
                thead
                {
                	vertical-align:middle;
                }
              </style>
              @endsection

              @section('content')
              <div class="content-header row">
                <div class="content-header-left col-md-6 col-xs-12 mb-2">
                  <h3 class="content-header-title mb-0">Report Kas / Bank</h3>
                  <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-xs-12">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/transaksi">Transaksi</a>
                        </li>
                        <li class="breadcrumb-item active">Report Kas/Bank
                        </li>
                      </ol>
                    </div>
                  </div>
                </div>
              </div>
              <div class="content-body"><!-- Basic scenario start -->
                <section id="basic">
                  <div class="row">
                    @if(count($errors->all()) > 0)
                    <duv class="col-xs-6">
                      <div class="alert alert-danger alert-dismissable">
                        @foreach ($errors->all() as $error)
                        {!! $error !!}<br>
                        @endforeach
                      </div>
                    </div>
                    @endif
                    <div class="col-xs-12">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">Pencarian Report</h4>
                          <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                        </div>
                        <div class="card-body collapse in">
                          <div class="card-block">
                            <form method="POST" action="{{ url('transaksi/filter/kasbank') }}">
                              <div class="row">
                                {{ csrf_field() }}
                                <div class="col-xs-3">
                                  <div class="form-group">
                                    <label>Kantor Cabang</label>
                                    <select class="select2 form-control" name="cabang" required>
                                      <option selected disabled>Pilih cabang</option>
                                      @foreach($cabang as $cab)
                                      {{ $id = $cab->VALUE."00" }}
                                      @if(Gate::check("unit_".$id) )
                                      <option value="{{ $cab->VALUE }}" {{ $filters['cabang'] == $cab->VALUE ? 'selected=""' : '' }}>{{ $cab->DESCRIPTION }}</option>
                                      @endif
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-xs-2">
                                  <div class="form-grpup">
                                    <label>Periode Awal</label>
                                    <select class="select2 form-control" name="awal" required>
                                      <option selected disabled>Pilih Periode Awal</option>
                                      @foreach($months as $month)
                                      <option value="{{ array_search($month, $months) }}" {{ $filters['awal'] == array_search($month, $months)? 'selected=""' : '' }}>{{ $month }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-xs-2">
                                  <div class="form-grpup">
                                    <label>Periode Akhir</label>
                                    <select class="select2 form-control" name="akhir" required>
                                      <option selected disabled>Pilih Periode Akhir</option>
                                      @foreach($months as $month)
                                      <option value="{{ array_search($month, $months) }}" {{ $filters['akhir'] == array_search($month, $months)? 'selected=""' : '' }}>{{ $month }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-xs-2">
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
                                  <div class="col-xs-6">
                                    <button type="submit" class="btn btn-outline-primary"><i class="fa fa-search"></i> Cari</button>
                                      @if($filters)
                                      <a href="{{ url('transaksi/report/kasbank') }}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>                   
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                          <div class="card">
                            <div class="card-header">
                              @if ($filters)
                              <h4 class="card-title">Hasil Pencarian Report Kas/Bank</h4><br>

                              <table align="right"><tr>
                                <td><span><a href="{{ URL('transaksi/kasbank/'.$filters['cabang'].'/'.$filters['awal'].'/'.$filters['akhir'].'/'.$filters['transyear'].'/excel') }}" class="btn btn-success" target="_blank"><i class="fa fa-file-excel-o"></i> <b> Ekspor ke Excel </b></a></span></td>

                                <td><span><a href="{{ URL('transaksi/kasbank/'.$filters['cabang'].'/'.$filters['awal'].'/'.$filters['akhir'].'/'.$filters['transyear'].'/export') }}" class="btn btn-success" target="_blank"><i class="fa fa-file-pdf-o"></i> <b> Ekspor ke PDF </b></a></span></td>

                                <td><span><a href="{{ URL('transaksi/kasbank/'.$filters['cabang'].'/'.$filters['awal'].'/'.$filters['akhir'].'/'.$filters['transyear'].'/print') }}" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> <b> Cetak Report</b></a></span></td> 
                              </tr></table>
                              @else
                              <h4 class="card-title">Daftar Report</h4><br>
                              @endif
                              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>                         
                            </div>
                            <div class="card-body collapse in ">
                              <div class="card-block card-dashboard ">
                                <name="data" id="data">
                                <div class="table-responsive">
                                 <table class="table table-striped table-bordered datatable-select-inputs mb-0">
                                   <thead>
                                     <tr>
                                      <th rowspan="2" style="vertical-align:middle;"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TANGGAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                      <th rowspan="2" style="vertical-align:middle;"><center>NO.BK</center></th>
                                      <th rowspan="2" colspan="2" style="vertical-align:middle;"><center>URAIAN TRANSAKSI</center></th>
                                      <th colspan="2"><center>KAS</center></th>
                                      <th colspan="2"><center>BANK</center></th>
                                      <th rowspan="2" style="vertical-align:middle;"><center>SALDO</center></th>
                                    </tr>
                                    <tr>
                                      <th><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEBET&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                      <th><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;KREDIT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                      <th><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEBET&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                      <th><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;KREDIT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  @if($filters)
                                  <?php $account_id =  []?>
                                  @forelse($transaksi as $trans)
                                  <tr>
                                                <?php
                                                  if(count($account_id) == 0){
                                                    $account_id[$trans->PIL_ACCOUNTID] = $trans->SALDO;
                                                  }else{
                                                    if(!isset($account_id[$trans->PIL_ACCOUNTID])){
                                                      $account_id[$trans->PIL_ACCOUNTID] = $trans->SALDO;
                                                    }
                                                  }
                                                  $account_id[$trans->PIL_ACCOUNTID] +=  $trans->PIL_AmountCurDebit;
                                                  $account_id[$trans->PIL_ACCOUNTID] -=  $trans->PIL_AmountCurCredit;
                                                  $tanggal=$trans->PIL_TransDate;                                 
                                                  $tgl= date('d', strtotime($tanggal)); 
                                                  $bs= date('m', strtotime($tanggal));
                                                  if ($bs=="01"){
                                                    $bulans="Januari";
                                                  }
                                                  else if ($bs=="02"){
                                                    $bulans="Februari";
                                                  }
                                                  else if ($bs=="03"){
                                                    $bulans="Maret";
                                                  }
                                                  else if ($bs=="04"){
                                                    $bulans="April";
                                                  }
                                                  else if ($bs=="05"){
                                                    $bulans="Mei";
                                                  }
                                                  else if ($bs=="06"){
                                                    $bulans="Juni";
                                                  }
                                                  else if ($bs=="07"){
                                                    $bulans="Juli";
                                                  }
                                                  else if ($bs=="08"){
                                                    $bulans="Agustus";
                                                  }
                                                  else if ($bs=="09"){
                                                    $bulans="September";
                                                  }
                                                  else if ($bs=="10"){
                                                    $bulans="Oktober";
                                                  }
                                                  else if ($bs=="11"){
                                                    $bulans="November";
                                                  }
                                                  else if ($bs=="12"){
                                                    $bulans="Desember";
                                                  }
                                                  $tahun= date('Y', strtotime($tanggal));
                                              ?>
                                    <td><center>{{$tgl}} {{$bulans}} {{$tahun}}</center></td>
                                    <td>{{$trans->PIL_ACCOUNTID}}</td>
                                    <td width="150px" colspan="2">{{$trans->PIL_Description}}</td>
                                    <?php
                                      $AccoudId = $trans->PIL_ACCOUNTID;
                                      $kas = explode('KAS',$AccoudId);
                                      $kkc = explode('KKC',$AccoudId);
                                      $isKas = false;
                                      if(count($kas) > 1 || count($kkc) > 1 ){
                                        $isKas = true;
                                      }
                                    ?>
                                    <td align="right">@if($isKas)Rp {{ number_format($trans->PIL_AmountCurCredit, 2, ',','.') }} @endif</td>
                                    <td align="right">@if($isKas)Rp {{ number_format($trans->PIL_AmountCurDebit, 2, ',','.') }} @endif</td>
                                    <td align="right">@if(!$isKas)Rp {{ number_format($trans->PIL_AmountCurCredit, 2, ',','.') }} @endif</td>
                                    <td align="right">@if(!$isKas)Rp {{ number_format($trans->PIL_AmountCurDebit, 2, ',','.') }} @endif</td>
                                    <td align="right">Rp {{ number_format($account_id[$trans->PIL_ACCOUNTID], 2, ',','.') }}</td>
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