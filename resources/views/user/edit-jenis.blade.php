                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/custom.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/checkboxes-radios.min.css') }}">
                <style type="text/css">
                  .hide {
                    display: none;
                  }
                </style>
                @endsection

                @section('content')
                <div class="content-header row">
                  <div class="content-header-left col-md-6 col-xs-12 mb-2">
                    <h3 class="content-header-title mb-0">Manajemen User</h3>
                    <div class="row breadcrumbs-top">
                      <div class="breadcrumb-wrapper col-xs-12">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="{{ url('user') }}">Manajemen User</a>
                          </li>
                          <li class="breadcrumb-item active">Input User
                          </li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="content-body">
                  <form class="form" action="{{ url('jenis_user').'/'.$user->id }}" method="POST">
                    <div class="row">
                      <div class="col-md-6">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-card-center">Data Dasar</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                          </div>
                          <div class="card-body collapse in">
                            <div class="card-block">
                              @if(count($errors->all()) > 0)
                              <div class="alert alert-danger alert-dismissable">
                                @foreach ($errors->all() as $error)
                                {!! $error !!}<br>
                                @endforeach
                              </div>
                              @endif
                              <div class="form-body">
                                <div class="form-group">
                                  <label>Nama</label>
                                  <input type="text" required="" class="form-control" placeholder="Nama Jenis User" name="nama" value="{{ $user->nama }}">
                                </div>
                                <div class="form-group">
                                  <label>Deskripsi</label>
                                  <textarea class="form-control" name="desc" rows="7" placeholder="Tulis deskripsi mengenai jenis user ini">{!! $user->desc !!}</textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-card-center">Pengaturan Perizinan Data</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                          </div>
                          <div class="card-body collapse in">
                            <div class="card-block">
                              <div class="row skin skin-square">
                                <div class="col-md-12 col-sm-12">
                                  <div class="form-group">
                                    <fieldset>
                                      <input type="radio" id="input-11" name="perizinan[data_cabang]" checked="" value="on" {{ isset($user->perizinan['data_cabang']) ? 'checked=""' : '' }} >
                                      <label>Data semua kantor cabang</label>
                                    </fieldset>
                                    <fieldset>
                                      <input type="radio" id="input-11" name="perizinan[data_cabang]" value="off" {{ !isset($user->perizinan['data_cabang']) == 'off' ? 'checked=""' : '' }}>
                                      <label>Data kantor cabang yang bersangkutan</label>
                                    </fieldset>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-card-center">Perizinan <code>Notifikasi</code></h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                          </div>
                          <div class="card-body">
                            <div class="card-block">
                              <div class="form-group skin skin-square">
                                <fieldset>
                                  <input type="checkbox" name="perizinan[verifikasi_notif]" {{ isset($user->perizinan['verifikasi_notif']) ? 'checked=""' : '' }}>
                                  <label>Pemintaan verifikasi persetujuan transaksi</label>
                                  <fieldset>
                                    <input type="checkbox" name="perizinan[verifikasi2_notif]" {{ isset($user->perizinan['verifikasi2_notif']) ? 'checked=""' : '' }}>
                                    <label>Permintaan verifikasi final transaksi</label>
                                  </fieldset>
                                  <fieldset>
                                    <input type="checkbox" name="perizinan[update_notif]" {{ isset($user->perizinan['update_notif']) ? 'checked=""' : '' }}>
                                    <label>Update mengenai status batch transaksi</label>
                                  </fieldset>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @include('user.edit-perizinan')
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
                      <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script>
                      <script src="{{ asset('app-assets/js/scripts/forms/checkbox-radio.min.js') }}" type="text/javascript"></script>
                      <!-- END PAGE LEVEL JS-->
                      <script type="text/javascript">
                        $('select[name="cabang"]').on('change', function() {
                          if ($(this).val() !== '00') {
                            $('select[name="divisi"]').prop("disabled", true);
                            toastr.info("Divisi tidak perlu dipilih jika Kantor Cabang yang dipilih adalah <b>Kantor pusat</b>.", "Kantor Cabang dipilih", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                          } else {
                            $('select[name="divisi"]').prop("disabled", false);
                          }
                        });
                      </script>
                      @endsection