                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/toggle/switchery.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/switch.min.css') }}">
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
                                <p>Penjelasan singkat mengenai form bisa diletakkan <b>disini</b>.</p>
                              </div>
                              <form class="form" id="tariktunai-form" method="POST" action="{{ url('dropping/tariktunai/'.$dropping->RECID) }}">
                              {{ csrf_field() }}
                                <div class="form-body">
                                  <h4 class="form-section"> Informasi Tarik Tunai</h4>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="projectinput1">Tanggal Dropping</label>
                                        <input type="date" readonly="" id="tgl_dropping" class="form-control" placeholder="Tanggal Transaksi" name="tgl_dropping" value="{{ date("Y-m-d",strtotime($dropping->TRANSDATE)) }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="projectinput2">Nominal Dropping (Dalam IDR)</label>
                                        <input type="text" readonly="" id="nominal_tunai" class="form-control" placeholder="Jumlah Transaksi" name="nominal_tunai" value="{{ number_format($dropping->DEBIT, 2) }}">
                                      </div>
                                    </div>
                                  </div>
                                  <h4 class="form-section">Informasi Bank</h4>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="companyName">Nama Bank</label>
                                        <input type="text" readonly="" id="akun_bank" class="form-control" placeholder="Nama Bank" name="akun_bank" value="{{ $dropping->BANK_DROPPING }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="companyName">Nomor Rekening</label>
                                        <input type="text" readonly="" id="rek_bank" class="form-control" placeholder="Nama Bank" name="rek_bank" value="{{ $dropping->REKENING_DROPPING }}">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="projectinput8">Cabang Kantor</label>
                                    <input type="text" readonly="" id="cabang" class="form-control" placeholder="Cabang Kantor" name="cabang" value="{{ $dropping->CABANG_DROPPING }}">
                                  </div>
                                  <h4 class="form-section">Kesesuaian Dropping</h4>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label for="companyName">Apakah nominal dropping sudah sesuai dengan pengajuan?</label>
                                        <input type="checkbox" onchange="change_checkbox(this)" class="form-control switch" id="switch1" checked="checked" name="status" value="sesuai" data-on-label="Sesuai" data-off-label="Tidak sesuai"/>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                {{-- <div class="form-actions">
                                  <a href="{{ url('dropping') }}" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Kembali
                                  </a>
                                  <button type="submit" class="btn btn-primary" id="post" name="post">
                                    <i class="fa fa-check-square-o"></i> Post
                                  </button>
                                </div> --}}
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="card" id="kesesuaian" style="height: 1800px;display: none;">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control">Form Pengembalian/Penambahan dropping</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                              <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                              </ul>
                            </div>
                          </div>
                          <div class="card-body collapse in">
                            <div class="card-block">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="alert alert-warning mb-2" role="alert" id="alert-dropping" style="display: block;">
                                    <strong>Perhatian!</strong> Jika dropping tidak sesuai, silahkan melengkapi form <b>pengembalian kelebihan dropping</b> atau <b>penambahan kekurangan dropping</b>.
                                  </div>
                                </div>
                              </div>
                              <form class="form" method="POST" id="kesesuaian-form" action="{{ url('dropping/tariktunai/'.$dropping->RECID) }}">
                              {{ csrf_field() }}
                                <div class="form-body">
                                  <h4 class="form-section"> Pengembalian/Penambahan Dropping</h4>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group mt-1 pb-1">
                                        <label for="switcherySize11" class="font-medium-2 text-bold-600 mr-1">Pengembalian kelebihan</label>
                                        <input type="checkbox" id="switcherySize11" class="switchery" checked/>
                                        <label for="switcherySize11" class="font-medium-2 text-bold-600 ml-1">Penambahan kekurangan</label>
                                      </div>
                                    </div>
                                  </div>
                                  <h4 class="form-section"> Informasi Pengembalian/Penambahan</h4>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="projectinput1">Tanggal Transaksi</label>
                                        <input type="date" id="transdate" class="form-control" placeholder="{{date('d/m/Y')}}" name="transdate" value="{{ date('Y-m-d') }}" disabled>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="projectinput2">Nominal Transaksi (Dalam IDR)</label>
                                        <input type="number" id="ket_nominal" class="form-control" placeholder="Nominal Transaksi" name="ket_nominal" value="">
                                      </div>
                                    </div>
                                  </div>
                                  <h4 class="form-section"> Informasi Bank</h4>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label for="projectinput8">Cabang Kantor</label>
                                        <select class="form-control" id="cabang" name="cabang">
                                            <option>--Pilih Kantor Cabang</option>
                                          @foreach($kcabangs as $cabang)
                                            <option value="{{ $cabang->DESCRIPTION }}">{{ $cabang->DESCRIPTION }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="companyName">Nama Bank</label>
                                        <select class="form-control" id="akun_bank" name="akun_bank">
                                            <option>--Pilih Bank</option>
                                          {{--@foreach($akunbanks as $akunbank)
                                            <option value="{{ $akunbank->BANK }}">{{ $akunbank->BANK }}</option>
                                          @endforeach--}}
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="companyName">Nomor Rekening</label>
                                        <select class="form-control" name="rek_bank">
                                          <option>--Pilih Rekening</option>
                                          {{--@foreach($akunbanks as $akunbank)
                                          <option value="{{ $akunbank->REKENING }}">{{ $akunbank->REKENING }}</option>
                                          @endforeach--}}
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </form>
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
                                  <i class="ft-x"></i> Kembali
                                </a>
                                <button type="button" data-toggle="modal" data-target="#xSmall" class="btn btn-primary">
                                  <i class="fa fa-check-square-o"></i> Simpan Post
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
                                      <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                      <button type="submit" id="post" onclick="forms_submit()" class="btn btn-outline-primary">Simpan post</button>
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
                <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js') }}"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/toggle/switchery.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/forms/switch.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/modal/components-modal.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE LEVEL JS-->  

                <script type="text/javascript">
                  function change_checkbox(el) {
                    if(el.checked) {
                      document.getElementById("kesesuaian").style.display = 'none';
                      document.getElementById("confirmation-msg").innerHTML = '<p>Apakah anda yakin untuk menyimpan <b>data tarik tunai dropping</b> yang anda input sudah sesuai?</p>';
                    } else {
                      document.getElementById("kesesuaian").style.display = 'block';
                      document.getElementById("confirmation-msg").innerHTML = '<p>Apakah anda yakin untuk menyimpan <b>data ketidaksesuaian dropping</b> yang telah anda input?</p>';
                    }
                  };

                  function forms_submit() {
                    if(document.getElementById("switch1").checked){
                      document.getElementById("tariktunai-form").submit();

                    } else{
                      document.getElementById("kesesuaian-form").submit();
                    }
                  };
                </script>
                @endsection