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
                                          <li class="breadcrumb-item active">Edit User
                                          </li>
                                        </ol>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="content-body">
                                  <form class="form" action="{{ url('user').'/'.$user->id }}" method="POST">
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
                                                  <label>Username</label>
                                                  <input type="text" required="" class="form-control" placeholder="Username" name="username" value="{{ old('username') == '' ? $user->username : old('username') }}">
                                                </div>
                                                <div class="form-group">
                                                  <label>Nama Lengkap</label>
                                                  <input type="text" required="" class="form-control" placeholder="Nama" name="name" value="{{ old('name') == '' ? $user->name : old('name') }}">
                                                </div>
                                                <div class="form-group">
                                                  <label>Email</label>
                                                  <input type="email" required="" class="form-control" placeholder="Email" name="email" value="{{ old('email') == '' ? $user->email : old('email') }}">
                                                </div>
                                                <div class="form-group">
                                                  <label>Cabang</label>
                                                  <select class="select2 form-control" name="cabang">
                                                    <option selected disabled="">Cabang</option>
                                                    @foreach($cabang as $cab)
                                                    <option {{ $user->cabang == $cab->VALUE ? 'selected=""' : '' }} value="{{ $cab->VALUE }}">{{ $cab->DESCRIPTION }}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                                <div class="form-group">
                                                  <label>Divisi</label><br>
                                                  <select class="select2 form-control" name="divisi" >
                                                    <option selected disabled="">Divisi</option>
                                                    @foreach($divisi as $div)
                                                    <option {{ $user->divisi == $div->VALUE ? 'selected=""' : '' }} value="{{ $div->VALUE }}">{{ $div->DESCRIPTION }}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="card">
                                          <div class="card-header">
                                            <h4 class="card-title" id="basic-layout-card-center">Password</h4>
                                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                          </div>
                                          <div class="card-body collapse in">
                                            <div class="card-block">
                                              <div class="row skin skin-square">
                                                <div class="col-md-12 col-sm-12">
                                                  <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" id="input-11" name="password">
                                                  </div>
                                                  <div class="form-group">
                                                    <label>Konfirmasi Password</label>
                                                    <input type="password" class="form-control" name="password_confirmation">
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
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
                                                      <input type="radio" id="input-11" name="perizinan[data-cabang]" value="on" {{ isset($user->perizinan['data-cabang']) ? 'checked=""' : '' }}>
                                                      <label>Data semua kantor cabang</label>
                                                    </fieldset>
                                                    <fieldset>
                                                      <input type="radio" id="input-11" name="perizinan[data-cabang]" value="off" {{ !isset($user->perizinan['data-cabang']) ? 'checked=""' : '' }}>
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
                                            <div class="heading-elements">
                                              <label class="text-primary" onclick="checkAll(this)" id="notifikasi">Centang semua</label>
                                            </div>
                                          </div>
                                          <div class="card-body">
                                            <div class="card-block">
                                              <div class="form-group skin skin-square" id="notifikasi">
                                                <fieldset>
                                                  <input type="checkbox" name="perizinan[verifikasi-notif]" {{ isset($user->perizinan['verifikasi-notif']) ? 'checked=""' : '' }}>
                                                  <label>Pemintaan verifikasi persetujuan transaksi</label>
                                                  <fieldset>
                                                    <input type="checkbox" name="perizinan[verifikasi2-notif]" {{ isset($user->perizinan['verifikasi2-notif']) ? 'checked=""' : '' }}>
                                                    <label>Permintaan verifikasi final transaksi</label>
                                                  </fieldset>
                                                  <fieldset>
                                                    <input type="checkbox" name="perizinan[update-notif]" {{ isset($user->perizinan['update-notif']) ? 'checked=""' : '' }}>
                                                    <label>Update mengenai status batch transaksi</label>
                                                  </fieldset>
                                                  <fieldset>
                                                    <input type="checkbox" name="perizinan[verifikasiTT_notif]" {{ isset($user->perizinan['verifikasiTT_notif']) ? 'checked=""' : '' }}>
                                                    <label>Permintaan verifikasi tarik tunai</label>
                                                  </fieldset>
                                                  <fieldset>
                                                    <input type="checkbox" name="perizinan[verifikasiPD_notif]" {{ isset($user->perizinan['verifikasiPD_notif']) ? 'checked=""' : '' }}>
                                                    <label>Permintaan verifikasi penyesuaian dropping</label>
                                                  </fieldset>
                                                  <fieldset>
                                                    <input type="checkbox" name="perizinan[verifikasiPD2_notif]" {{ isset($user->perizinan['verifikasiPD2_notif']) ? 'checked=""' : '' }}>
                                                    <label>Permintaan verifikasi final penyesuaian dropping</label>
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
                                      @include('user.js-perizinan')
                                      @endsection