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
                        <h3 class="content-header-title mb-0">Verifikasi Penyesuaian Dropping</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Verifikasi Penyesuaian Dropping
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
                      <div class="col-xs-12">
                        <div class="col-md-6">
                          <div class="alert alert-info alert-dismissible fade in mb-2" role="alert">
                            <b>Verifikasi hanya dilakukan oleh user <i>Bia</i></b>
                          </div>
                        </div>
                        @if(session('success'))
                        <div class="col-xs-7">
                            <div class="alert alert-success">
                              <b>Data penyesuaian dropping {{ $penyesuaian->cabang }} sudah diverifikasi dan dikirim ke <i>Akuntansi</i>.</b>
                            </div>
                        </div>
                        @elseif(session('reject'))
                        <div class="col-xs-7">
                            <div class="alert alert-warning">
                              <b>Data penyesuaian dropping {{ $penyesuaian->cabang }} ditolak.</b>
                            </div>
                        </div>
                        @elseif(session('done'))
                        <div class="col-xs-7">
                            <div class="alert alert-warning">
                              <b>Data penyesuaian dropping {{ $penyesuaian->cabang }} sudah dilakukan verifikasi.</b>
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
                            <h4 class="card-title" id="basic-layout-form">Detail Verifikasi Penyesuaian Dropping <b><br></b></h4>
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
                              <form class="form" id="penyesuaian-form" method="GET" action="{{ url('dropping/verifikasi/penyesuaian/1/verified/'.$penyesuaian->id) }}">
                              {{ csrf_field() }}
                                <div class="form-body">
                                  <h4 class="form-section"> Informasi Penyesuaian Dropping</h4>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="tgl_penyesuaian">Tanggal Penyesuaian Dropping</label>
                                        <input type="date" readonly="" id="tgl_penyesuaian" class="form-control" placeholder="Tanggal Penyesuaian Dropping" name="tgl_penyesuaian" value="{{ date("Y-m-d",strtotime($penyesuaian->created_at)) }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="status">Status Penyesuaian Dropping</label>
                                          <input type="text" id="status" readonly="" class="form-control" placeholder="Status" name="status" value="" disabled>
                                          <input type="hidden" name="p_status" id="p_status" value="{{ $penyesuaian->is_pengembalian }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                      <div class="form-group">
                                        <label for="nominal_tarik">Nominal Penyesuaian (Dalam IDR)</label>
                                          <input type="text" id="nominal" readonly="" name="nominal" placeholder="Nominal Penyesuaian" class="form-control" value="{{ number_format($penyesuaian->nominal) }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="nominal_tarik">Nominal Awal Dropping (Dalam IDR)</label>
                                          <input type="text" id="nominal_dropping" readonly="" name="nominal_dropping" class="form-control" placeholder="Nominal Dropping" value="{{ number_format($penyesuaian->nominal_dropping) }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                      <div class="form-group">
                                        <label for="rek_bank">Nomor Rekening</label>
                                        <input type="text" readonly="" id="rek_bank" class="form-control" placeholder="Rekening Bank" name="rek_bank" value="{{ $penyesuaian->rek_bank }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="akun_bank">Nama Bank</label>
                                        <input type="text" readonly="" id="akun_bank" class="form-control" placeholder="Nama Bank" name="akun_bank" value="{{ $penyesuaian->akun_bank }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label for="cabang">Kantor Cabang</label>
                                        <input type="text" readonly="" id="cabang" class="form-control" placeholder="Kantor Cabang" name="cabang" value="{{ $penyesuaian->cabang }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <h4 class="form-section">Daftar Berkas</h4>
                                        <table>
                                            @forelse($berkas as $value)
                                            <tr>
                                              <li><a href="{{ url('dropping/penyesuaian/berkas/download').'/'.$value->id }}" target="_blank">{{ $value->name }}</a></li>
                                            </tr>
                                          @empty
                                            <code>Tidak ada berkas terlampir</code>
                                          @endforelse
                                        </table>
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
                            <h4 class="card-title" id="basic-layout-colored-form-control">Financial Dimension</h4>
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
      				                          <label class="col-md-2 label-control" for="segmen1">Account</label>
      				                          <div class="col-md-3">
      				                          	<input type="text" id="segmen1" class="form-control" name="segmen1" value="{{ $penyesuaian->SEGMEN_1 }}" disabled>
      				                          </div>
                                        <div class="col-md-7">
                                          <input type="text" id="account" class="form-control" name="account" value="{{ $bank->DESC_ACCOUNT }}" disabled>
                                        </div>
      				                        </div>
      				                        <div class="form-group row">
      				                          <label class="col-md-2 label-control" for="segmen2">Program</label>
      				                          <div class="col-md-3">
      				                            <input type="text" id="segmen2" class="form-control" name="segmen2" value="{{ $penyesuaian->SEGMEN_2 }}" disabled>
      				                          </div>
                                        <div class="col-md-7">
                                          <input type="text" id="program" class="form-control" name="program" value="{{ $program->DESCRIPTION }}" disabled>
                                        </div>
      				                        </div>
      				                        <div class="form-group row">
      				                          <label class="col-md-2 label-control" for="segmen3">KPKC</label>
      				                          <div class="col-md-3">
      				                            <input type="text" id="segmen3" class="form-control" name="segmen3" value="{{ $penyesuaian->SEGMEN_3 }}" disabled>
      				                          </div>
                                        <div class="col-md-7">
                                          <input type="text" id="kpkc" class="form-control" name="kpkc" value="{{ $kpkc->DESCRIPTION }}" disabled>
                                        </div>
      				                        </div>
      				                        <div class="form-group row">
      				                          <label class="col-md-2 label-control" for="segmen4">Divisi</label>
      				                          <div class="col-md-3">
      				                            <input type="text" id="segmen4" class="form-control" name="segmen4" value="{{ $penyesuaian->SEGMEN_4 }}" disabled>
      				                          </div>
                                        <div class="col-md-7">
                                          <input type="text" id="divisi" class="form-control" name="divisi" value="{{ $divisi->DESCRIPTION }}" disabled>
                                        </div>
      				                        </div>
      				                        <div class="form-group row">
      				                          <label class="col-md-2 label-control" for="segmen5">Sub Pos</label>
      				                          <div class="col-md-3">
      				                            <input type="text" id="segmen5" class="form-control" name="segmen5" value="{{ $penyesuaian->SEGMEN_5 }}" disabled>
      				                          </div>
                                        <div class="col-md-7">
                                          <input type="text" id="subpos" class="form-control" name="subpos" value="{{ $subpos->DESCRIPTION }}" disabled>
                                        </div>
      				                        </div>
                                      <div class="form-group row">
      				                          <label class="col-md-2 label-control" for="segmen6">Mata Anggaran</label>
      				                          <div class="col-md-3">
      				                            <input type="text" id="segmen6" class="form-control" name="segmen6" value="{{ $penyesuaian->SEGMEN_6 }}" disabled>
      				                          </div>
                                        <div class="col-md-7">
                                          <input type="text" id="kegiatan" class="form-control" name="kegiatan" value="{{ $kegiatan->DESCRIPTION }}" disabled>
                                        </div>
      				                        </div>
                                      {{--<div class="form-group row">
                                        <label class="col-md-3 label-control" for="account">Account</label>
                                        <div class="col-md-9">
                                          <input type="text" id="account" class="form-control" placeholder="Mata Anggaran"
                                          name="ccount" value="{{ $penyesuaian->ACCOUNT }}" disabled>
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
                                <button type="submit" data-toggle="modal" data-target="#tolak" class="btn btn-warning mr-1">
                                  <i class="ft-x"></i> Tolak
                                </button>
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
                                      <p>Apakah anda yakin mengirim <b>verifikasi</b> penyesuaian dropping untuk {{ $penyesuaian->cabang }} ?</p>
                                      <input type="hidden" name="v_nominal" value="{{ $penyesuaian->nominal }}">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Tidak, kembali</button>
                                      <button type="submit" id="post" onclick="forms_submit()" class="btn btn-outline-primary">Ya, kirim</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal fade text-xs-left" id="tolak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20"
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
                                      <div class="row">
                                        <div class="col-md-10" id="reason">
                                          <form method="GET" action="{{ url('dropping/verifikasi/penyesuaian/1/rejected/'.$penyesuaian->id) }}" id="verification">
                                            <div class="form-group">
                                              <label>Alasan <b>penolakan</b></label>
                                              <select class="form-control" name="reason">
                                                <option value="0">Silahkan pilih alasan anda</option>
                                                @foreach($reject_reasons as $res)
                                                  <option value="{{ $res->id }}">{{ $res->content }}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                                      <button onclick="attent()" type="submit" class="btn btn-outline-primary">Submit penolakan</button>
                                      <!-- <a href="{{ url('dropping/verifikasi/penyesuaian/1/rejected/'.$penyesuaian->id) }}" class="btn btn-outline-danger">Ya, tolak</a> -->
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- Modal End-->
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
                {{--<script src="{{ asset('app-assets/js/scripts/forms/validation/form-validation.js') }}" type="text/javascript"></script>--}}
                <script src="{{ asset('app-assets/js/scripts/modal/components-modal.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/extensions/toastr.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE LEVEL JS-->  

                <script type="text/javascript">
                  function forms_submit() {
                      document.getElementById("penyesuaian-form").submit();
                  };

                  //function change_status(t){
                  	//t = document.getElementById("p_status");
                    var t = document.getElementById("p_status").value;
                    if(t != 0){
                      document.getElementById("status").value = 'Pengembalian kelebihan';
                    } else {
                      document.getElementById("status").value = 'Penambahan kekurangan';
                    }
                  //};

                  function attent() {
                    if ($('select[name="reason"]').val() == '0') {
                      toastr.error("Silahkan input alasan penolakan anda untuk verifikasi level 1 ini. Terima kasih.", "Alasan penolakan dibutuhkan.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                    }else {
                      $('form[id="verification"]').submit();
                    }
                  };
                </script>
                @endsection