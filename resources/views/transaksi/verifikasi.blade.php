                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/toggle/switchery.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/switch.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-callout.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
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
                .contohh {
                  background: rgb(255, 204, 0);
                }
              </style>
              @endsection

              @section('content')
              <div class="content-header row">
                <div class="content-header-left col-md-6 col-xs-12 mb-2">
                  <h3 class="content-header-title mb-0">Verifikasi Transaksi</h3>
                  <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-xs-12">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Verifikasi Transaksi
                        </li>
                      </ol>
                    </div>
                  </div>
                </div>
              </div>
              <div class="content-body"><!-- Basic scenario start -->
                <section id="basic">
                  <div class="row">
                    <div class="col-xs-5">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">Detil Batch Transaksi</h4>
                          <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                        </div>
                        <div class="card-body collapse in">
                          <div class="card-block">
                            <ul>
                              <li>Tanggal dibuat : <code>{{ date("d-m-Y", strtotime($active_batch->created_at)) }}</code>, diajukan oleh : <code>Verifikator Level 1 : {{ $active_batch->latestStat()->submitter->username }}</code></li>
                               <!-- : {{ $active_batch['creator']['name'] }} -->
                              <?php
                              $tanggal=$active_batch->updated_at;                                 
                              $tgl= date('d-m-Y H:i:s', strtotime($tanggal));
                              ?>
                              <li>Terkahir Update : <code>{{ $tgl }}</code></li>
                              <li>Banyak poin : <code id="totalRows"></code>, dengan <code>{{ count($berkas).' berkas lampiran' }}</code></li>
                              <li>Status terakhir : <code>{{ $active_batch->latestStat()->status() }}</code></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="alert alert-warning alert-dismissible fade in mb-2" role="alert">
                        <h4 class="alert-heading mb-2">Perlu Diperhatikan!</h4>
                        <ul>
                          <li>Verifikasi akhir hanya bisa dilakukan oleh <b>Divisi Akuntansi</b>.</li>
                          <li>Jika <b>verifikasi ditolak</b>, maka tahapan akan kembali ke <b>tahap paling awal</b>.</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">Daftar Transaksi</h4><br>
                          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                          <div>
                            @if ($active_batch)
                            <span>No. Batch (lokal) saat ini: <code>{{ $active_batch->batchNo() }}</code></span>
                            <span>KPKC: <code>{{ $active_batch->kantorCabang()->DESCRIPTION }}</code> <span>Divisi:</span> <code>{{ $active_batch->divisi == '00' ? 'Non-Divisi' : $active_batch->divisi()->DESCRIPTION  }}</code></span>
                            @endif
                          </div>
                        </div>
                        <div class="card-body collapse in ">
                          <div class="card-block card-dashboard ">
                            <div class="row">
                              @if(session('success'))
                              <div class="col-xs-7">
                                <div class="alert alert-success">
                                  Batch ini berhasil ditindaklanjuti dan mengirimkan notifikasi ke user yang bersangkutan.
                                </div>
                              </div>
                              @endif
                              @if(session('failed_safe'))
                              <div class="col-xs-6">
                                <div class="alert alert-danger">
                                  Anggaran pada Batch ini tidak memadai.
                                </div>
                              </div>
                              @endif
                            </div>
                            <div id="basicScenario"></div><br>
                            <div class="row">
                              @include('transaksi.berkas')
                              @include('transaksi.history')
                            </div>
                            <br>
                            <div class="row">
                              @if($verifiable)
                              {{-- <div class="col-sm-12 col-lg-3 col-xl-2 pull-right">
                                <div class="form-group">
                                  <button class="btn btn-info pull-right" id="keep_anggaran" value="Simpan"><i class="fa fa-money"></i> Perbarui Status Anggaran</button>
                                </div>
                              </div> --}}
                              <div class="col-sm-12 col-lg-3 col-xl-2 pull-right">
                                <div class="form-group">
                                  <button data-toggle="modal" data-target="#xSmall" class="btn btn-primary pull-right" id="simpan" value="Simpan"><i class="fa fa-refresh"></i> Tindaklanjuti</button>
                                </div>
                              </div>
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
                <!-- Basic scenario end -->
              </div>

              <!-- Modal -->
              <div class="modal fade text-xs-left" id="xSmall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20"
              aria-hidden="true">
              <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel20">Box Konfirmasi Verifikasi lvl 2</h4>
                  </div>
                  <div class="modal-body" id="confirmation-msg">
                    <div class="row">
                      <div class="col-md-12">
                        <form method="POST" action="{{ url('transaksi/submit/verifikasi').'/2/'.$active_batch->id }}" id="verification">
                          {{ csrf_field() }}
                          <p>Anda akan <b>memverifikasi batch ini</b> sebagai Kakancab. Informasi batch ini : 
                            <ul>
                              <li>Batch saat ini : <code>{{ $active_batch->batchNo() }}</code></li>
                              <?php
                              $tanggal2=$active_batch->updated_at;                                 
                              $tgl2= date('d-m-Y H:i:s', strtotime($tanggal2));
                              ?>
                              <li>Terakhir Update : <code>{{ $tgl2 }}</code> oleh <code>Verifikator Level 1 : {{ $active_batch->latestStat()->submitter->username }}</code></li>
                              <!-- <code>{{ $active_batch['creator']['name'] }}</code></li> -->
                              <li>Banyak item : <code id="totalRows"></code>, dengan <code>{{ count($berkas).' berkas lampiran' }}</code></li>
                            </ul>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="companyName">Apakah batch ini dapat dilanjutkan <b>untuk staging</b>?</label><br>
                                  <input type="checkbox" onchange="approveOrNot(this)" class="form-control switch" id="switch1" checked="checked" name="is_approved" value="1" data-on-label="Approve untuk verifikasi akhir" data-off-label="Reject dengan alasan, kembali ke tahap awal"/>
                                </div>
                              </div>
                              <div class="col-md-10" id="reason" style="display: none;">
                                <div class="form-group">
                                  <label>Alasan <b>penolakan</b> (Isi hanya jika verifikasi bersifat <i>rejection</i>)</label>
                                  <select class="form-control" name="reason">
                                    <option value="0">Silahkan pilih alasan anda</option>
                                    @foreach($reject_reasons as $res)
                                    <option value="{{ $res->id }}">{{ $res->content }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                      <button onclick="submitVer()" type="submit" class="btn btn-outline-primary">Submit verifikasi</button>
                    </div>
                  </div>
                </div>
              </div>
              @endsection

              @section('customjs')
              <!-- BEGIN PAGE VENDOR JS-->
              <script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
              <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
              <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script>
              <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/griddata.js') }}" type="text/javascript"></script>
              <script src="{{ asset('app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js') }}"></script>
              <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}" type="text/javascript"></script>
              <script src="{{ asset('app-assets/vendors/js/forms/toggle/switchery.min.js') }}" type="text/javascript"></script>
              <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}" type="text/javascript"></script>
              <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
              <!-- END PAGE VENDOR JS-->
              <!-- BEGIN PAGE LEVEL JS-->
              <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
              {{--<script src="{{ asset('app-assets/js/scripts/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script>--}}
              {{-- <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}" type="text/javascript"></script> --}}
              <script src="{{ asset('app-assets/js/scripts/forms/switch.min.js') }}" type="text/javascript"></script>
              <!-- END PAGE LEVEL JS-->
              <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
              <script src="{{ asset('app-assets/js/scripts/extensions/toastr.min.js') }}" type="text/javascript"></script>
              @include('transaksi.js')
              @endsection