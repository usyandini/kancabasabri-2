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
                          <li class="breadcrumb-item active">Edit User
                          </li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="content-body">
                  <div class="row">
                    <form class="form" action="{{ url('user').'/'.$user->id }}" method="POST">
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
                                  <label for="eventRegInput1">Username</label>
                                  <input type="text" required="" class="form-control" placeholder="Username" name="username" value="{{ $user->username }}">
                                </div>
                                <div class="form-group">
                                  <label for="eventRegInput2">Nama Lengkap</label>
                                  <input type="text" required="" class="form-control" placeholder="Nama" name="name" value="{{ $user->name }}">
                                </div>
                                <div class="form-group">
                                  <label for="eventRegInput4">Email</label>
                                  <input type="email" required="" class="form-control" placeholder="Email" name="email" value="{{ $user->email }}">
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
                                  <label>Divisi</label>
                                  <select class="select2 form-control" name="divisi" >
                                    <option selected disabled="">Divisi</option>
                                    @foreach($divisi as $div)
                                    <option {{ $user->divisi == $div->VALUE ? 'selected=""' : '' }} value="{{ $div->VALUE }}">{{ $div->DESCRIPTION }}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label>Jadikan administrator?</label>
                                  <div class="input-group">
                                    <label class="display-inline-block custom-control custom-radio ml-1">
                                      <input type="radio" name="is_admin" class="custom-control-input" value="1" {{ $user->is_admin == 1 ? 'checked=""' : '' }}>
                                      <span class="custom-control-indicator"></span>
                                      <span class="custom-control-description ml-0">Ya</span>
                                    </label>
                                    <label class="display-inline-block custom-control custom-radio">
                                      <input type="radio" name="is_admin" {{ $user->is_admin == 0 ? 'checked=""' : '' }} class="custom-control-input" value="0">
                                      <span class="custom-control-indicator"></span>
                                      <span class="custom-control-description ml-0">Tidak</span>
                                    </label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-card-center">Perubahan Password lokal (isi jika diperlukan)</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                          </div>
                          <div class="card-body">
                            <div class="card-block">
                              <div class="form-group">
                                <label for="eventRegInput1">Password Baru</label>
                                <input type="password" class="form-control" placeholder="Password baru" name="password">
                              </div>
                              <div class="form-group">
                                <label for="eventRegInput2">Ulangi Password Baru</label>
                                <input type="password" class="form-control" placeholder="Konfirmasi password" name="password_confirmation">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-card-center">Pengaturan Perizinan</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                          </div>
                          <div class="card-body collapse in">
                            <div class="card-block">
                              <div class="form-group">
                                <label>Menu Dropping</label>
                                <select class="select2 form-control menu" name="perizinan_dropping[]" multiple="" data-placeholder="Perizinan untuk Menu Dropping">
                                  <option {{ collect($user->perizinan('dropping'))->contains("1") || collect(old('perizinan_dropping'))->contains("1") ? 'selected="selected"' : '' }} value="1">Staff</option>
                                  <option {{ collect($user->perizinan('dropping'))->contains("2") || collect(old('perizinan_dropping'))->contains("2") ? 'selected="selected"' : '' }} value="2">Approver</option>
                                  <option {{ collect($user->perizinan('dropping'))->contains("4") || collect(old('perizinan_dropping'))->contains("4") ? 'selected="selected"' : '' }} value="4">Superuser</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Menu Transaksi</label>
                                <select class="select2 form-control menu" name="perizinan_transaksi[]" multiple="" data-placeholder="Perizinan untuk Menu Transaksi">
                                  <option {{ collect($user->perizinan('transaksi'))->contains("1") || collect(old('perizinan_transaksi'))->contains("1") ? 'selected="selected"' : '' }} value="1">Staff</option>
                                  <option {{ collect($user->perizinan('transaksi'))->contains("2") || collect(old('perizinan_transaksi'))->contains("2") ? 'selected="selected"' : '' }} value="2">Approver</option>
                                  <option {{ collect($user->perizinan('transaksi'))->contains("4") || collect(old('perizinan_transaksi'))->contains("4") ? 'selected="selected"' : '' }} value="4">Superuser</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Menu Anggaran</label>
                                <select class="select2 form-control menu" name="perizinan_anggaran[]" multiple="" data-placeholder="Perizinan untuk Menu Anggaran">
                                  <option {{ collect($user->perizinan('anggaran'))->contains("1") || collect(old('perizinan_anggaran'))->contains("1") ? 'selected="selected"' : '' }} value="1">Staff</option>
                                  <option {{ collect($user->perizinan('anggaran'))->contains("2") || collect(old('perizinan_anggaran'))->contains("2")? 'selected="selected"' : '' }} value="2">Approver</option>
                                  <option {{ collect($user->perizinan('anggaran'))->contains("4") || collect(old('perizinan_anggaran'))->contains("4")? 'selected="selected"' : '' }} value="4">Superuser</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-block">
                              <div class="form-actions right">
                                <a href="{{ url('user') }}" class="btn btn-warning mr-1">
                                  <i class="ft-x"></i> Kembali
                                </a>    
                                <button type="submit" class="btn btn-primary">
                                  <i class="fa fa-check-square-o"></i> Simpan
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
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
                <script type="text/javascript">
                  $(document).ready(function() {
                    if ($('select[name="cabang"]').val() !== '00') {
                      $('select[name="divisi"]').prop("disabled", true);
                    } else {
                      $('select[name="divisi"]').prop("disabled", false);
                    }
                    $('select[name="cabang"]').on('change', function() {
                      if ($(this).val() !== '00') {
                        $('select[name="divisi"]').prop("disabled", true);
                        toastr.info("Divisi tidak perlu dipilih jika Kantor Cabang yang dipilih adalah <b>Kantor pusat</b>.", "Kantor Cabang dipilih", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                      } else {
                        $('select[name="divisi"]').prop("disabled", false);
                      }
                    });
                  });
                </script>
                @endsection