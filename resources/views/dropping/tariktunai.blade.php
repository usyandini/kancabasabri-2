                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/toggle/switchery.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/switch.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/toastr.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/validation/form-validation.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css') }}">
                @endsection

                @section('content')
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Tarik Tunai</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('/dropping') }}">Informasi Dropping</a>
                                    </li>
                                    <li class="breadcrumb-item active">Tarik Tunai
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body">
                <!-- Basic scenario start -->
                  <section id ="basic-form-layouts">
                    <div class="row match-height">
                    <div class="row">
                        @if(session('success'))
                        <div class="col-xs-7">
                            <div class="alert alert-success">
                              <b>Data tarik tunai berhasil dikirim.</b>
                            </div>
                        </div>
                        @elseif(session('offset'))
                        <div class="col-xs-7">
                            <div class="alert alert-warning">
                              <b>Data tarik tunai gagal dikirim. Nominal tarik tunai melebihi dana dropping.</b>
                            </div>
                        </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="col-xs-7">
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <ul>
                                    @foreach ($errors->all() as $error)
                                        <li><b>{{ $error }}</b></li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                      </div>
                      <div class="col-md-6">
                        <div class="card" style="height: 100px;">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-form">Detail Tarik Tunai <b><br>{{ $dropping->CABANG_DROPPING }}</b></h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                              <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                              </ul>
                            </div>
                          </div>
                          <div class="card-body collapse in">
                            <div class="card-block">
                              <div class="card-text">
                                <div class="alert alert-warning mb-2" role="alert" id="alert-dropping" style="display: block;">
                                  <p><b>Perhatian ! </b>Sebelum melakukan <b>Tarik Tunai</b> harap melakukan <b>Penyesuaian Dropping</b> terlebih dahulu. Jika jumlah dropping sudah sesuai dengan pengajuan silahkan melakukan <b>Tarik Tunai</b>.</p>
                                </div>
                              </div>
                              <form class="form" id="tariktunai-form" method="POST" action="{{ url('dropping/tariktunai/'.$dropping->RECID) }}" enctype="multipart/form-data">
                              {{ csrf_field() }}
                                <input type="hidden" name="sisa_dropping" value="{{ $dropping->tarikTunai['sisa_dropping'] }}">

                                <div class="form-body">
                                  <h4 class="form-section"> Informasi Dropping</h4>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="tgl_dropping">Tanggal Dropping</label>
                                        <input type="date" readonly="" id="tgl_dropping" class="form-control" placeholder="Tanggal Transaksi" name="tgl_dropping" value="{{ date("Y-m-d",strtotime($dropping->TRANSDATE)) }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="nominal">Nominal Dropping (Dalam IDR)</label>
                                          <input type="text" readonly="" class="form-control" placeholder="{{ $dropping->DEBIT }}" name="nominal_dropping" value="{{ number_format($dropping->DEBIT, 2) }}">
                                          <input type="hidden" id="nominal" name="nominal" value="{{ $dropping->DEBIT }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                      <div class="form-group">
                                        <label for="rek_bank">Nomor Rekening</label>
                                        <input type="text" readonly="" id="rek_bank" class="form-control" placeholder="Rekening Bank" name="rek_bank" value="{{ $dropping->REKENING_DROPPING }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="akun_bank">Nama Bank</label>
                                        <input type="text" readonly="" id="akun_bank" class="form-control" placeholder="Nama Bank" name="akun_bank" value="{{ $dropping->BANK_DROPPING }}">
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label for="cabang">Kantor Cabang</label>
                                        <input type="text" readonly="" id="cabang" class="form-control" placeholder="Kantor Cabang" name="cabang" value="{{ $dropping->CABANG_DROPPING }}">
                                      </div>
                                    </div>
                                  </div>
                                  <h4 class="form-section">Informasi Tarik Tunai</h4>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="tgl_tarik">Tanggal Tarik Tunai</label>
                                        <input type="date" readonly="" id="tgl_tarik" class="form-control" placeholder="Tanggal Tarik Tunai" name="tgl_tarik" value="{{ date("Y-m-d") }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="nominal_tarik">Nominal Tarik Tunai(Dalam IDR)</label>
                                        <span class="required"> *</span>
                                        <div class="controls">
                                          <input type="text" id="nominal_tarik" name="nominal_tarik" class="form-control" value="{{ old('nominal_tarik') }}" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="Hanya diisi oleh angka">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="berkas">Upload berkas tarik tunai</label>
                                      <span class="required"> *</span>
                                      <div class="controls">
                                        <input type="file" class="form-control-file" id="berkas" name="berkas" value="" required>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="card" id="history" style="height: 1800px;display: block;">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control">History Tarik Tunai</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                              <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                              </ul>
                            </div>
                          </div>
                          <div class="card-body collapse in">
                            <div class="card-block">
                              <div class="form-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <div class="table-responsive">
                                        <table class="table">
                                          <thead>
                                            <tr>
                                              <th>Tanggal</th>
                                              <th>Saldo</th>
                                              <th>Nominal Tarik</th>
                                              <th>Sisa Dropping</th>
                                              <th>Attachment</th>
                                            </tr>
                                          </thead>
                                          @foreach($tariktunai as $history)
                                          <tbody>
                                            <tr>
                                              <th>{{ date('d-m-Y H:i:s', strtotime($history->created_at)) }}</th>
                                              <td>IDR {{ number_format($history->nominal, 2) }}</td>
                                              <td>IDR {{ number_format($history->nominal_tarik, 2) }}</td>
                                              <td>IDR {{ number_format($history->sisa_dropping, 2) }}</td>
                                              <td><a href="{{ asset('file/tariktunai').'/'.$history->berkas_tariktunai }}" target="_blank">{{ $history->berkas_tariktunai }}</a></td>
                                            </tr>
                                          </tbody>
                                          @endforeach
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row match-height">
                      <div class="col-md-12">
                        <div class="card">
                        {{-- <div class="card-header"></div> --}}
                          <div class="card-body collapse in">
                            <div class="card-block">
                              <div class="form-actions">
                                <a href="{{ url('dropping') }}" class="btn btn-warning mr-1">
                                  <i class="ft-x"></i> Keluar
                                </a>
                                <button type="submit" data-toggle="modal" data-target="#xSmall" class="btn btn-primary">
                                  <i class="fa fa-check-square-o"></i> Posting
                                </button>
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
                                      <h4 class="modal-title" id="myModalLabel20">Box Konfirmasi</h4>
                                    </div>
                                    <div class="modal-body" id="confirmation-msg">
                                      <p>Apakah anda yakin dengan <b>data tarik tunai dropping</b> yang anda input sudah sesuai?</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Tidak, kembali</button>
                                      <button type="submit" id="post" onclick="forms_submit()" class="btn btn-outline-primary">Ya, simpan post</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>

                <!-- Basic scenario end -->
                </div>
                @endsection

                @section('customjs')
                <!-- BEGIN PAGE VENDOR JS-->
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js') }}"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/toggle/switchery.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/forms/switch.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/forms/validation/form-validation.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/modal/components-modal.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/extensions/toastr.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE LEVEL JS-->  

                <script type="text/javascript">
                  function forms_submit() {
                      document.getElementById("tariktunai-form").submit();
                  };
                </script>
                @endsection