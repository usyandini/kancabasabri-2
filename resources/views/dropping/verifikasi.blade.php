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
                        <h3 class="content-header-title mb-0">Verifikasi Tarik Tunai</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Verifiaksi Tarik Tunai
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
                            <h4 class="card-title" id="basic-layout-form">Detail Verifikasi Tarik Tunai <b><br></b></h4>
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
                              </div>
                              <form class="form" id="tariktunai-form" method="POST" action="{{ url('dropping/verifikasi/') }}" enctype="multipart/form-data">
                              {{ csrf_field() }}
                                <input type="hidden" name="sisa_dropping" value="">

                                <div class="form-body">
                                  <h4 class="form-section"> Informasi Tarik Tunai</h4>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="tgl_dropping">Tanggal Tarik Tunai</label>
                                        <input type="date" readonly="" id="tgl_tarik" class="form-control" placeholder="Tanggal Tarik Tunai" name="tgl_tarik" value="{{ date("Y-m-d",strtotime($tariktunai->created_at)) }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="nominal">Saldo (Dalam IDR)</label>
                                          <input type="text" readonly="" class="form-control" placeholder="Saldo" name="nominal" value="{{ number_format($tariktunai->nominal) }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                      <div class="form-group">
                                        <label for="nominal_tarik">Sisa Dropping (Dalam IDR)</label>
                                          <input type="text" id="sisa_dropping" readonly="" name="sisa_dropping" placeholder="Sisa Dropping" class="form-control" value="{{ number_format($tariktunai->sisa_dropping) }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="nominal_tarik">Nominal Tarik Tunai (Dalam IDR)</label>
                                          <input type="text" id="nominal_tarik" readonly="" name="nominal_tarik" class="form-control" placeholder="Nominal Tarik Tunai" value="{{ number_format($tariktunai->nominal_tarik) }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                      <div class="form-group">
                                        <label for="rek_bank">Nomor Rekening</label>
                                        <input type="text" readonly="" id="rek_bank" class="form-control" placeholder="Rekening Bank" name="rek_bank" value="{{ $tariktunai->rek_bank }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="akun_bank">Nama Bank</label>
                                        <input type="text" readonly="" id="akun_bank" class="form-control" placeholder="Nama Bank" name="akun_bank" value="{{ $tariktunai->akun_bank }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label for="cabang">Kantor Cabang</label>
                                        <input type="text" readonly="" id="cabang" class="form-control" placeholder="Kantor Cabang" name="cabang" value="{{ $tariktunai->cabang }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label for="cabang">Attachment :</label><br>
                                        <a href="{{ url('dropping/tariktunai/berkas/download').'/'.$tariktunai->fileTarikTunai['id'] }}" target="_blank">{{ $tariktunai->fileTarikTunai['name'] }}</a>
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
                            <h4 class="card-title" id="basic-layout-colored-form-control">Account Dimension</h4>
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
                                    <form class="form form-horizontal striped-rows" id="acountDim" method="POST">
                                    	<div class="form-group row">
      				                          <label class="col-md-3 label-control" for="segmen1">Account Bank</label>
      				                          <div class="col-md-9">
      				                            <input type="text" id="segmen1" class="form-control" placeholder="Account Bank"
      				                            name="segmen1" value="{{ $tariktunai->SEGMEN_1 }}" disabled>
                                          {{--<input type="text" class="form-control" placeholder="Account Bank"
                                          name="segmen1" value="{{ $bank->BANK_NAME }}" disabled>--}}
      				                          </div>
      				                        </div>
      				                        <div class="form-group row">
      				                          <label class="col-md-3 label-control" for="segmen2">Program</label>
      				                          <div class="col-md-9">
      				                            <input type="text" id="segmen2" class="form-control" placeholder="Program"
      				                            name="segmen2" value="{{ $tariktunai->SEGMEN_2 }}" disabled>
      				                          </div>
      				                        </div>
      				                        <div class="form-group row">
      				                          <label class="col-md-3 label-control" for="segmen3">KPKC</label>
      				                          <div class="col-md-9">
      				                            <input type="text" id="segmen3" class="form-control" placeholder="KPKC"
      				                            name="segmen3" value="{{ $tariktunai->SEGMEN_3 }}" disabled>
      				                          </div>
      				                        </div>
      				                        <div class="form-group row">
      				                          <label class="col-md-3 label-control" for="segmen4">Divisi</label>
      				                          <div class="col-md-9">
      				                            <input type="text" id="segmen4" class="form-control" placeholder="Divisi"
      				                            name="segmen4" value="{{ $tariktunai->SEGMEN_4 }}" disabled>
      				                          </div>
      				                        </div>
      				                        <div class="form-group row">
      				                          <label class="col-md-3 label-control" for="segmen5">Sub Pos</label>
      				                          <div class="col-md-9">
      				                            <input type="text" id="segmen5" class="form-control" placeholder="Subpos"
      				                            name="segmen5" value="{{ $tariktunai->SEGMEN_5 }}" disabled>
      				                          </div>
      				                        </div>
                                      <div class="form-group row">
      				                          <label class="col-md-3 label-control" for="segmen6">Kegiatan</label>
      				                          <div class="col-md-9">
      				                            <input type="text" id="segmen6" class="form-control" placeholder="Mata Anggaran"
      				                            name="segmen6" value="{{ $tariktunai->SEGMEN_6 }}" disabled>
      				                          </div>
      				                        </div>
                                      {{--<div class="form-group row">
                                        <label class="col-md-3 label-control" for="account">Account</label>
                                        <div class="col-md-9">
                                          <input type="text" id="account" class="form-control" placeholder="Mata Anggaran"
                                          name="ccount" value="{{ $tariktunai->ACCOUNT }}" disabled>
                                        </div>
                                      </div>--}}
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card">
                        {{-- <div class="card-header"></div> --}}
                          <div class="card-body collapse in">
                            <div class="card-block">
                              <div class="form-actions">
                                <a href="{{ url('dropping') }}" class="btn btn-warning mr-1">
                                  <i class="ft-x"></i> Tolak
                                </a>
                                <button type="submit" data-toggle="modal" data-target="#xSmall" class="btn btn-success">
                                  <i class="fa fa-check-square-o"></i> Verifikasi
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
                                      <button type="submit" id="post" onclick="forms_submit()" class="btn btn-outline-primary">Ya, kirim</button>
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