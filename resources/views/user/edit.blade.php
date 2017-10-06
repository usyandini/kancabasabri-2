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
                                      <input type="hidden" name="profile_edit" value="false">
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
                                              <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                  <div class="form-group  skin skin-square">
                                                    <fieldset>
                                                      <label class="display-inline-block custom-control custom-radio">
                                                        <input type="radio" id='activ_dir_off' name="as_ldap" value="0" disabled {{ $user->as_ldap  != "1" ? 'checked=""' : '' }}>
                                                        Daftar dengan aplikasi
                                                      </label>
                                                      <label class="display-inline-block custom-control custom-radio">
                                                        <input type="radio" id='activ_dir_on' name="as_ldap" value="1"  disabled {{ $user->as_ldap == "1" ? 'checked=""' : '' }}>
                                                        Daftar dengan Active Dirctory
                                                      </label>
                                                    </fieldset>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" required="" class="form-control" placeholder="Username" name="username" value="{{ old('username') == '' ? $user->username : old('username') }}" readOnly>
                                              </div>
                                              <div class="form-group">
                                                <label>Nama Lengkap</label>
                                                <input type="text" required="" class="form-control" placeholder="Nama" name="name" value="{{ old('name') == '' ? $user->name : old('name') }}" readOnly>
                                              </div>
                                              <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" required="" class="form-control" placeholder="Email" name="email" id="email" value="{{ old('email') == '' ? $user->email : old('email') }}">
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
                                                <select class="select2 form-control" name="divisi" id="divisi">
                                                  <option selected disabled="">Divisi</option>
                                                  @foreach($divisi as $div)
                                                  <option {{ $user->divisi == $div->VALUE ? 'selected=""' : '' }} value="{{ $div->VALUE }}">{{ $div->DESCRIPTION }}</option>
                                                  @endforeach
                                                </select>
                                              </div>
                                              @if (isset($jenis_user))
                                              <div class="form-group">
                                                <label>Jenis User (preset)</label><br>
                                                <select class="select2 form-control" name="jenis_user" style="width: 100%;">
                                                  <option selected disabled="" value="">Jenis User</option>
                                                  @foreach($jenis_user as $jenis)
                                                  <option value="{{ $jenis->id }}" {{ $jenis->id == $user->jenis_user ? 'selected=""' : '' }}>{{ $jenis->nama }}</option>
                                                  @endforeach
                                                </select>
                                              </div>
                                              @endif
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="card" style='display:{{ $user->as_ldap  != "1" ? "block":"none"}}'>
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
                                          <h4 class="card-title" id="basic-layout-card-center">Perizinan <code>User</code></h4>
                                        </div>
                                        <div class="card-body">
                                          <div class="card-block">
                                            <div class="form-group skin skin-square">
                                              <div class="col-md-8">
                                                <label >Pengaturan Perizinan <code>Unit Kerja</code></label>
                                              </div>
                                              <div class="col-md-4">
                                                <div class="btn btn-sm btn-primary" id="toogle_unit"><i class="fa fa-edit"></i></div>
                                              </div>
                                            </div>
                                            <br />
                                            <div class="form-group skin skin-square">
                                              <div class="col-md-8">
                                                <label>Pengaturan Menu <code>Dropping</code></label>
                                              </div>
                                              <div class="col-md-4">
                                                <div class="btn btn-sm btn-primary"  onclick="open_menu('dropping')"><i class="fa fa-edit"></i></div>
                                              </div>
                                            </div>
                                            <br />
                                            <div class="form-group skin skin-square">
                                              <div class="col-md-8">
                                                <label>Pengaturan Menu <code>Transaksi</code></label>
                                              </div>
                                              <div class="col-md-4">
                                                <div class="btn btn-sm btn-primary" onclick="open_menu('transaksi')"><i class="fa fa-edit"></i></div>
                                              </div>
                                            </div>
                                            <br />
                                            <div class="form-group skin skin-square">
                                              <div class="col-md-8">
                                                <label>Pengaturan Menu <code>Anggaran</code></label>
                                              </div>
                                              <div class="col-md-4">
                                                <div class="btn btn-sm btn-primary"  onclick="open_menu('anggaran')"><i class="fa fa-edit"></i></div>
                                              </div>
                                            </div>
                                            <br />
                                            <div class="form-group skin skin-square">
                                              <div class="col-md-8">
                                                <label>Pengaturan Menu <code>Pelaporan</code></label>
                                              </div>
                                              <div class="col-md-4">
                                                <div class="btn btn-sm btn-primary"  onclick="open_menu('pelaporan')"><i class="fa fa-edit"></i></div>
                                              </div>
                                            </div>
                                            <br />
                                            <div class="form-group skin skin-square">
                                              <div class="col-md-8">
                                                <label>Pengaturan Menu <code>Manajemen User</code></label>
                                              </div>
                                              <div class="col-md-4">
                                                <div class="btn btn-sm btn-primary"  onclick="open_menu('user')"><i class="fa fa-edit"></i></div>
                                              </div>
                                            </div>
                                            <br />
                                            <div class="form-group skin skin-square">
                                              <div class="col-md-8">
                                                <label>Pengaturan Menu <code>Manajemen Item</code></label>
                                              </div>
                                              <div class="col-md-4">
                                                <div class="btn btn-sm btn-primary"  onclick="open_menu('item')"><i class="fa fa-edit"></i></div>
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
                                  </div>
                                  <div class="modal fade text-xs-left" id="modal_unit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20">
                                    <div class="modal-dialog" style="width: 80%; min-width:80%;max-width:80%;">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                          <h4 class="modal-title col-md-12 col-sm-12" id="title_modal_pernyataan" >Pengaturan Perizinan <code>Unit Kerja</code></h4>
                                        </div>
                                        <div class="modal-body" id="confirmation-msg">
                                         <div class="col-md-12 col-sm-12">
                                          <div class="card">
                                            <div class="card-header">
                                              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                              <div class="heading-elements">
                                                <label class="text-primary" onclick="CheckUnitKerja('unit_kerja')">Unit Kerja</label>
                                                &nbsp&nbsp&nbsp
                                                <label class="text-primary" onclick="checkAll(this)" id="unit_kerja"></label>
                                              </div>
                                            </div>
                                            <div class="card-body collapse in">
                                              <div class="card-block">
                                                <div class="row">
                                                  <div class="col-md-12 col-sm-12" id="unit_kerja">
                                                    <div class="col-md-4 col-sm-4">
                                                      <div class="form-group skin skin-square">
                                                        <?php
                                                        $countCAB = count($cabang);
                                                        $count = 0;
                                                        ?>
                                                        @foreach($cabang as $cab)
                                                        @if($cab->VALUE != "00")
                                                        <?php
                                                        $value =$cab->VALUE. "00";
                                                        ?>
                                                        <fieldset>
                                                          <input type="checkbox" name="perizinan[unit_{{$value}}]" {{ isset($user->perizinan['unit_'.$value]) ? 'checked=""' : '' }}>
                                                          <label>{{$cab->DESCRIPTION}}</label>
                                                        </fieldset>
                                                        @endif
                                                        <?php
                                                        $count++;
                                                        if($count > $countCAB/2){
                                                          break;
                                                        }
                                                        ?>
                                                        @endforeach
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4">
                                                      <div class="form-group skin skin-square">
                                                        <?php
                                                        $count = 0;
                                                        ?>
                                                        @foreach($cabang as $cab)
                                                        @if($count > $countCAB/2)
                                                        <?php
                                                        $value =$cab->VALUE. "00";
                                                        ?>
                                                        <fieldset>
                                                          <input type="checkbox" name="perizinan[unit_{{$value}}]" {{ isset($user->perizinan['unit_'.$value]) ? 'checked=""' : '' }}>
                                                          <label>{{$cab->DESCRIPTION}}</label>
                                                        </fieldset>
                                                        @endif
                                                        <?php
                                                        $count++;
                                                        ?>
                                                        @endforeach
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4">
                                                      <div class="form-group skin skin-square">
                                                        @foreach($divisi as $div)
                                                        {{-- @if($div->VALUE!="00") --}}
                                                        <?php
                                                        $value = "00".$div->VALUE;
                                                        ?>
                                                        <fieldset>
                                                          <input type="checkbox" name="perizinan[unit_{{$value}}]"{{ isset($user->perizinan['unit_'.$value]) ? 'checked=""' : '' }} >
                                                          <label>{{$div->VALUE != "00" ? $div->DESCRIPTION : "Non Divisi"}}</label>
                                                        </fieldset>
                                                        {{-- @endif --}}
                                                        @endforeach
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">kembali</button>
                                        <!-- <button type="button" id="button_peryataan" onclick="sumbit_post()" class="btn btn-outline-primary">Ya, kirim</button> -->
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal fade text-xs-left" id="modal_menu_dropping" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title col-md-12 col-sm-12" id="title_modal_pernyataan" >Pengaturan Perizinan <code>Dropping</code></h4>
                                      </div>
                                      <div class="modal-body" id="body-menu">
                                       @include('user.edit-menu-dropping')
                                     </div>
                                     <div class="modal-footer">
                                      <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">kembali</button>
                                      <!-- <button type="button" id="button_peryataan" onclick="sumbit_post()" class="btn btn-outline-primary">Ya, kirim</button> -->
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal fade text-xs-left" id="modal_menu_transaksi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                      <h4 class="modal-title col-md-12 col-sm-12" id="title_modal_pernyataan" >Pengaturan Perizinan <code>Transaksi</code></h4>
                                    </div>
                                    <div class="modal-body" id="body-menu">
                                     @include('user.edit-menu-transaksi')
                                   </div>
                                   <div class="modal-footer">
                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">kembali</button>
                                    <!-- <button type="button" id="button_peryataan" onclick="sumbit_post()" class="btn btn-outline-primary">Ya, kirim</button> -->
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal fade text-xs-left" id="modal_menu_anggaran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title col-md-12 col-sm-12" id="title_modal_pernyataan" >Pengaturan Perizinan <code>Anggaran</code></h4>
                                  </div>
                                  <div class="modal-body" id="body-menu">
                                   @include('user.edit-menu-anggaran')
                                 </div>
                                 <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">kembali</button>
                                  <!-- <button type="button" id="button_peryataan" onclick="sumbit_post()" class="btn btn-outline-primary">Ya, kirim</button> -->
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal fade text-xs-left" id="modal_menu_pelaporan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                  <h4 class="modal-title col-md-12 col-sm-12" id="title_modal_pernyataan" >Pengaturan Perizinan <code>Pelaporan</code></h4>
                                </div>
                                <div class="modal-body" id="body-menu">
                                 @include('user.edit-menu-pelaporan')
                               </div>
                               <div class="modal-footer">
                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">kembali</button>
                                <!-- <button type="button" id="button_peryataan" onclick="sumbit_post()" class="btn btn-outline-primary">Ya, kirim</button> -->
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal fade text-xs-left" id="modal_menu_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title col-md-12 col-sm-12" id="title_modal_pernyataan" >Pengaturan Perizinan <code>Manajemen User</code></h4>
                              </div>
                              <div class="modal-body" id="body-menu">
                               @include('user.edit-menu-user')
                             </div>
                             <div class="modal-footer">
                              <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">kembali</button>
                              <!-- <button type="button" id="button_peryataan" onclick="sumbit_post()" class="btn btn-outline-primary">Ya, kirim</button> -->
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal fade text-xs-left" id="modal_menu_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                              <h4 class="modal-title col-md-12 col-sm-12" id="title_modal_pernyataan" >Pengaturan Perizinan <code>Manajemen Item</code></h4>
                            </div>
                            <div class="modal-body" id="body-menu">
                             @include('user.edit-menu-item')
                           </div>
                           <div class="modal-footer">
                            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">kembali</button>
                            <!-- <button type="button" id="button_peryataan" onclick="sumbit_post()" class="btn btn-outline-primary">Ya, kirim</button> -->
                          </div>
                        </div>
                      </div>
                    </div>

                  </form>
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
                <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/forms/checkbox-radio.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE LEVEL JS-->
                @include('user.js-perizinan')
                @endsection