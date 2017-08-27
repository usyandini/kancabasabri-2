                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
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
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                          <div class="card">
                            <div class="card-header">
                              <h4 class="card-title" id="basic-layout-card-center">Input User Baru</h4>
                              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                              <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                  <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                  <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                  <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                              </div>
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
                                <form class="form" action="{{ url('user') }}" method="POST">
                                 {{ csrf_field() }}
                                  <div class="form-body">
                                    <div class="form-group">
                                      <label for="eventRegInput1">Username</label>
                                      <input type="text" required="" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}">
                                    </div>
                                    <div class="form-group">
                                      <label for="eventRegInput2">Nama Lengkap</label>
                                      <input type="text" required="" class="form-control" placeholder="Nama" name="name" value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group">
                                      <label for="eventRegInput4">Email</label>
                                      <input type="email" required="" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                      <label for="eventRegInput5">Password</label>
                                      <input type="password" required="" class="form-control" name="password" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                      <label for="eventRegInput5">Ulangi password</label>
                                      <input type="password" required="" class="form-control" name="password_confirmation" placeholder="Konfirmasi password">
                                    </div>
                                    <div class="form-group">
                                      <label>Jadikan administrator?</label>
                                      <div class="input-group">
                                        <label class="display-inline-block custom-control custom-radio ml-1">
                                          <input type="radio" name="is_admin" class="custom-control-input" value="1">
                                          <span class="custom-control-indicator"></span>
                                          <span class="custom-control-description ml-0">Ya</span>
                                        </label>
                                        <label class="display-inline-block custom-control custom-radio">
                                          <input type="radio" name="is_admin" checked="" class="custom-control-input" value="0">
                                          <span class="custom-control-indicator"></span>
                                          <span class="custom-control-description ml-0">Tidak</span>
                                        </label>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-actions center">
                                    <a href="{{ url('user') }}" class="btn btn-warning mr-1">
                                      <i class="ft-x"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                      <i class="fa fa-check-square-o"></i> Simpan
                                    </button>
                                  </div>
                                </form>
                              </div>
                            </div>
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
                <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                <!-- END PAGE LEVEL JS-->
                @endsection