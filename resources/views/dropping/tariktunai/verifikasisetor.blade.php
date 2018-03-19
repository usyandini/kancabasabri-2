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
                    <div class="content-header-left col-md-12 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Verifikasi Setor Tunai</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dropping</a>
                                    </li>
                                    <li class="breadcrumb-item active">Verifikasi Setor Tunai
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
                          @if($setortunai->stat==9)
                          <div class="alert alert-info alert-dismissible fade in mb-2" role="alert">
                            <b>Verifikasi hanya dilakukan oleh verifikator <i>level 1</i></b>
                          </div>
                          @endif
                        </div>
                        @if(session('success'))
                        <div class="col-xs-7">
                            <div class="alert alert-success">
                              <b>Data setor tunai {{ $setortunai->cabang }} sudah diverifikasi.</b>
                            </div>
                        </div>
                        @elseif(session('reject'))
                        <div class="col-xs-7">
                            <div class="alert alert-warning">
                              <b>Data setor tunai {{ $setortunai->cabang }} ditolak.</b>
                            </div>
                        </div>
                        @elseif(session('done'))
                        <div class="col-xs-7">
                            <div class="alert alert-warning">
                              <b>Data setor tunai {{ $setortunai->cabang }} sudah dilakukan verifikasi.</b>
                            </div>
                          </div>
                        @endif

                        @if(session('integrated'))
                          <div class="col-xs-7">
                              <div class="alert alert-success">
                                <b>Data setor tunai {{ $setortunai->cabang }} sudah tercatat journal di Axapta.</b>
                              </div>
                          </div>
                          @elseif(!session('integrated'))
                          <div class="col-xs-7">
                              <div class="alert alert-warning">
                                <b>Data setor tunai {{ $setortunai->cabang }} belum tercatat journal di Axapta.</b>
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
                            <h4 class="card-title" id="basic-layout-form">Detail Verifikasi Setor Tunai <b><br></b></h4>
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
                              <form class="form" id="setortunai-form" method="GET" action="{{ url('dropping/verifikasi/setortunai/verified/'.$setortunai->id) }}">
                              {{ csrf_field() }}
                                <div class="form-body">
                                  <h4 class="form-section"> Informasi Setor Tunai</h4>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="tgl_dropping">Tanggal Setor Tunai</label>
                                        <input type="text" readonly="" id="tgl_setor" class="form-control" placeholder="Tanggal Setor Tunai" name="tgl_setor" value="{{ date("d-m-Y",strtotime($setortunai->created_at)) }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="nominal">Saldo</label>
                                          <input type="text" readonly="" class="form-control" placeholder="Saldo" name="nominal" value="Rp. {{ number_format($setortunai->nominal, 0, '', '.') }}" disabled>
                                          <input type="hidden" name="v_nominal" value="{{ $setortunai->nominal }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                      <div class="form-group">
                                        <label for="nominal_setor">Sisa Dropping</label>
                                          <input type="text" id="sisa_dropping" readonly="" name="sisa_dropping" placeholder="Sisa Dropping" class="form-control" value="Rp. {{ number_format($setortunai->sisa_dropping, 0, '', '.') }}" disabled>
                                          <input type="hidden" name="v_sisa_dropping" value="{{ $setortunai->sisa_dropping }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="nominal_setor">Nominal Setor Tunai</label>
                                          <input type="text" id="nominal_setor" readonly="" name="nominal_setor" class="form-control" placeholder="Nominal Setor Tunai" value="Rp. {{ number_format($setortunai->nominal_tarik, 0, '', '.') }}" disabled>
                                          <input type="hidden" name="v_nominal_setor" value="{{ $setortunai->nominal_tarik }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                      <div class="form-group">
                                        <label for="rek_bank">Nomor Rekening</label>
                                        <input type="text" readonly="" id="rek_bank" class="form-control" placeholder="Rekening Bank" name="rek_bank" value="{{ $setortunai->rek_bank }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="akun_bank">Nama Bank</label>
                                        <input type="text" readonly="" id="akun_bank" class="form-control" placeholder="Nama Bank" name="akun_bank" value="{{ $setortunai->akun_bank }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label for="cabang">Kantor Cabang</label>
                                        <input type="text" readonly="" id="cabang" class="form-control" placeholder="Kantor Cabang" name="cabang" value="{{ $setortunai->cabang }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <h4 class="form-section">Daftar Berkas</h4>
                                        <table>
                                          @forelse($berkas as $value)
                                            <tr>
                                              <li><a href="{{ url('dropping/tariktunai/berkas/download').'/'.$value->id }}" target="_blank">{{ $value->name }}</a></li>
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
                                          <input type="text" id="segmen1" class="form-control" name="segmen1" value="{{ $setortunai->SEGMEN_1 }}" disabled>
      				                          </div>
                                        <div class="col-md-7">
                                          <input type="text" id="account" class="form-control" name="account" value="{{ $bank->DESC_ACCOUNT }}" disabled>
                                        </div>
      				                        </div>
      				                        <div class="form-group row">
      				                          <label class="col-md-2 label-control" for="segmen2">Program</label>
      				                          <div class="col-md-3">
                                          <input type="text" id="segmen2" class="form-control" name="segmen2" value="{{ $setortunai->SEGMEN_2 }}" disabled>
      				                          </div>
                                        <div class="col-md-7">
                                          <input type="text" id="program" class="form-control" name="program" value="{{ $program->DESCRIPTION }}" disabled>
                                        </div>
      				                        </div>
      				                        <div class="form-group row">
      				                          <label class="col-md-2 label-control" for="segmen3">KPKC</label>
      				                          <div class="col-md-3">
                                          <input type="text" id="segmen3" class="form-control" name="segmen3" value="{{ $setortunai->SEGMEN_3 }}" disabled>
      				                          </div>
                                        <div class="col-md-7">
                                          <input type="text" id="kpkc" class="form-control" name="kpkc" value="{{ $kpkc->DESCRIPTION }}" disabled>
                                        </div>
      				                        </div>
      				                        <div class="form-group row">
      				                          <label class="col-md-2 label-control" for="segmen4">Divisi</label>
      				                          <div class="col-md-3">
                                          <input type="text" id="segmen4" class="form-control" name="segmen4" value="{{ $setortunai->SEGMEN_4 }}" disabled>
      				                          </div>
                                        <div class="col-md-7">
                                          <input type="text" id="divisi" class="form-control" name="divisi" value="{{ $divisi->DESCRIPTION }}" disabled>
                                        </div>
      				                        </div>
      				                        <div class="form-group row">
      				                          <label class="col-md-2 label-control" for="segmen5">Sub Pos</label>
      				                          <div class="col-md-3">
                                          <input type="text" id="segmen5" class="form-control" name="segmen5" value="{{ $setortunai->SEGMEN_5 }}" disabled>
      				                          </div>
                                        <div class="col-md-7">
                                          <input type="text" id="subpos" class="form-control" name="subpos" value="{{ $subpos->DESCRIPTION }}" disabled>
                                        </div>
      				                        </div>
                                      <div class="form-group row">
      				                          <label class="col-md-2 label-control" for="segmen6">Mata Anggaran</label>
      				                          <div class="col-md-3">
                                          <input type="text" id="segmen6" class="form-control" name="segmen6" value="{{ $setortunai->SEGMEN_6 }}" disabled>
      				                          </div>
                                        <div class="col-md-7">
                                          <input type="text" id="kegiatan" class="form-control" name="kegiatan" value="{{ $kegiatan->DESCRIPTION }}" disabled>
                                        </div>
      				                        </div>
                                      {{--<div class="form-group row">
                                        <label class="col-md-3 label-control" for="account">Account</label>
                                        <div class="col-md-9">
                                          <input type="text" id="account" class="form-control" placeholder="Mata Anggaran"
                                          name="ccount" value="{{ $setortunai->ACCOUNT }}" disabled>
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
                                {{--<a href="{{ url('dropping/verifikasi/setortunai/rejected/'.$setortunai->id) }}" class="btn btn-warning mr-1">
                                  <i class="ft-x"></i> Tolak
                                </a>--}}
                                @if($setortunai->stat==9)
                                <button type="submit" data-toggle="modal" data-target="#tolak" class="btn btn-warning mr-1">
                                  <i class="ft-x"></i> Tolak
                                </button>
                                <button type="submit" data-toggle="modal" data-target="#xSmall" class="btn btn-success">
                                  <i class="fa fa-check-square-o"></i> Verifikasi
                                </button>
                                @endif
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
                                      <p>Apakah anda yakin mengirim <b>verifikasi</b> untuk setor tunai {{ $setortunai->cabang }} ?</p>
                                      <input type="hidden" name="v_nominal" value="{{ $setortunai->nominal }}">
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
                                          <form method="GET" action="{{ url('dropping/verifikasi/setortunai/rejected/'.$setortunai->id) }}" id="verification">
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
                                      <!-- <a href="{{ url('dropping/verifikasi/setortunai/rejected/'.$setortunai->id) }}" class="btn btn-outline-danger" onclick="attent()" id="tolak1">Ya, tolak</a> -->
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
                <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                <script src="{{ asset('app-assets/js/scripts/modal/components-modal.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/extensions/toastr.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE LEVEL JS-->  

                <script type="text/javascript">
                  function forms_submit() {
                      document.getElementById("setortunai-form").submit();
                  };

                  function attent() {
                    if ($('select[name="reason"]').val() == '0') {
                      toastr.error("Silahkan input alasan penolakan anda untuk verifikasi lvl 1 ini. Terima kasih.", "Alasan penolakan dibutuhkan.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                    }else {
                      $('form[id="verification"]').submit();
                    }
                  };
                </script>
                @endsection