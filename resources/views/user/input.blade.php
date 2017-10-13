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
                  <h3 class="content-header-title mb-0">Tambah Pengguna</h3>
                  <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-xs-12">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('user') }}">Manajemen Pengguna</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Pengguna
                        </li>
                      </ol>
                    </div>
                  </div>
                </div>
              </div>
              <div class="content-body">
                <form class="form" action="{{ url('user') }}" method="POST">
                  <div class="row">
                    <div class="col-md-6">
                      {{ csrf_field() }}
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
                                  <div class="form-group skin skin-square">
                                    <fieldset">
                                      <label class="display-inline-block custom-radio mr-2">
                                        <input type="radio" id='activ_dir_off' name="as_ldap" value="0" {{ old('as_ldap') != "1" ? 'checked=""' : '' }}>
                                        Daftar dengan aplikasi
                                      </label>
                                      <label class="display-inline-block custom-radio" style="margin: 0;">
                                        <input type="radio" id='activ_dir_on' name="as_ldap" value="1" {{ old('as_ldap') == "1" ? 'checked=""' : '' }}>
                                        Daftar dengan Active Dirctory
                                      </label>
                                    </fieldset>
                                  </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xl-5">
                                  <div class="form-group">
                                    <label>Username</label>
                                    <div id="input_user">
                                      <input type="text" required="" id="username" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}">
                                      <!-- <select class="select2 form-control" id="username" name="username" placeholder="Username" style="width: 100%;"></select> -->
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xl-7">
                                  <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" required="" class="form-control" placeholder="Nama Lengkap" id="nama_lengkap" name="name" value="{{ old('name') }}">
                                  </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xl-12">
                                  <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" required="" class="form-control" placeholder="Email" name="email" id="email" value="{{ old('email') }}">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 col-lg-12 col-xl-6">
                                  <div class="form-group">
                                    <label>Cabang</label>
                                    <select class="select2 form-control" name="cabang" style="width: 100%;">
                                      <option selected disabled="" value="">Pilih Kantor Cabang</option>
                                      @foreach($cabang as $cab)
                                      <option {{ old('cabang') == $cab->VALUE ? 'selected=""' : '' }} value="{{ $cab->VALUE }}">{{ $cab->DESCRIPTION }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xl-6">
                                  <div class="form-group">
                                    <label>Divisi</label><br>
                                    <select class="select2 form-control" name="divisi" id="divisi">
                                      <option selected disabled="" value="">Pilih Divisi</option>
                                      @foreach($divisi as $div)
                                      <option {{ old('divisi') == $div->VALUE ? 'selected=""' : '' }} value="{{ $div->VALUE }}">{{ $div->DESCRIPTION }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card" id="form_password">
                        <div class="card-header">
                          <h4 class="card-title" id="basic-layout-card-center">Password</h4>
                          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        </div>
                        <div class="card-body collapse in">
                          <div class="card-block">
                            <div class="row skin skin-square">
                              <div class="col-md-12 col-lg-12 col-xl-6">
                                <div class="form-group">
                                  <label>Password</label>
                                  <input type="password" class="form-control" id="input-11" name="password" placeholder="Password">
                                </div>
                              </div>
                              <div class="col-md-12 col-lg-12 col-xl-6">
                                <div class="form-group">
                                  <label>Konfirmasi Password</label>
                                  <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      @if (isset($jenis_user))
                      <div class="card" id="form_jenisuser">
                        <div class="card-header">
                          <h4 class="card-title" id="basic-layout-card-center">Jenis User</h4>
                          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        </div>
                        <div class="card-body collapse in">
                          <div class="card-block">
                            <div class="row skin skin-square">
                              <div class="col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                  <select class="select2 form-control" name="jenis_user" style="width: 100%;">
                                    <option selected disabled="" value="">Pilih Jenis User</option>
                                    @foreach($jenis_user as $jenis)
                                    <option {{ old('jenis') == $jenis->id ? 'selected=""' : '' }} value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endif
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
                                <div class="btn btn-sm btn-outline-primary" id="toogle_unit"><i class="fa fa-edit"></i> Konfigurasi</div>
                              </div>
                            </div>
                            <br />
                            <div class="form-group skin skin-square">
                              <div class="col-md-8">
                                <label>Pengaturan Menu <code>Dropping</code></label>
                              </div>
                              <div class="col-md-4">
                                <div class="btn btn-sm btn-outline-primary"  onclick="open_menu('dropping')"><i class="fa fa-edit"></i> Konfigurasi</div>
                              </div>
                            </div>
                            <br />
                            <div class="form-group skin skin-square">
                              <div class="col-md-8">
                                <label>Pengaturan Menu <code>Pengajuan Dropping</code></label>
                              </div>
                              <div class="col-md-4">
                                <div class="btn btn-sm btn-outline-primary"  onclick="open_menu('aju_dropping')"><i class="fa fa-edit"></i> Konfigurasi</div>
                              </div>
                            </div>
                            <br />
                            <div class="form-group skin skin-square">
                              <div class="col-md-8">
                                <label>Pengaturan Menu <code>Transaksi</code></label>
                              </div>
                              <div class="col-md-4">
                                <div class="btn btn-sm btn-outline-primary" onclick="open_menu('transaksi')"><i class="fa fa-edit"></i> Konfigurasi</div>
                              </div>
                            </div>
                            <br />
                            <div class="form-group skin skin-square">
                              <div class="col-md-8">
                                <label>Pengaturan Menu <code>Anggaran</code></label>
                              </div>
                              <div class="col-md-4">
                                <div class="btn btn-sm btn-outline-primary"  onclick="open_menu('anggaran')"><i class="fa fa-edit"></i> Konfigurasi</div>
                              </div>
                            </div>
                            <br />
                            <div class="form-group skin skin-square">
                              <div class="col-md-8">
                                <label>Pengaturan Menu <code>Pelaporan</code></label>
                              </div>
                              <div class="col-md-4">
                                <div class="btn btn-sm btn-outline-primary"  onclick="open_menu('pelaporan')"><i class="fa fa-edit"></i> Konfigurasi</div>
                              </div>
                            </div>
                            <br />
                            <div class="form-group skin skin-square">
                              <div class="col-md-8">
                                <label>Pengaturan Menu <code>Manajemen User</code></label>
                              </div>
                              <div class="col-md-4">
                                <div class="btn btn-sm btn-outline-primary"  onclick="open_menu('user')"><i class="fa fa-edit"></i> Konfigurasi</div>
                              </div>
                            </div>
                            <br />
                            <div class="form-group skin skin-square">
                              <div class="col-md-8">
                                <label>Pengaturan Menu <code>Manajemen Item</code></label>
                              </div>
                              <div class="col-md-4">
                                <div class="btn btn-sm btn-outline-primary"  onclick="open_menu('item')"><i class="fa fa-edit"></i> Konfigurasi</div>
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
                            <div class="pull-right">
                              <a href="{{ url('user') }}" class="btn btn-warning">
                                <i class="ft-x"></i> Kembali
                              </a>    
                              <button type="submit" class="btn btn-outline-secondary">
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
                                <div class="row skin skin-square">
                                  <div class="col-md-12 col-sm-12" id="unit_kerja">
                                    <div class="col-md-4 col-sm-4">
                                      <div class="form-group">
                                        <?php
                                        $countCAB = count($cabang);
                                        $count = 0;
                                        ?>
                                        @foreach($cabang as $cab)
                                        @if($cab->VALUE != "00")
                                        <fieldset>
                                          <input type="checkbox" name="perizinan[{{'unit_'.$cab->VALUE.'00'}}]" {{ isset(old('perizinan')['unit_'.$cab->VALUE.'00']) ? 'checked=""' : '' }}>
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
                                      <div class="form-group">
                                        <?php
                                        $count = 0;
                                        ?>
                                        @foreach($cabang as $cab)
                                        @if($count > $countCAB/2)
                                        <fieldset>
                                          <input type="checkbox" name="perizinan[unit_{{$cab->VALUE.'00'}}]" {{ isset(old('perizinan')['unit_'.$cab->VALUE.'00']) ? 'checked=""' : '' }} >
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
                                      <div class="form-group">
                                        @foreach($divisi as $div)
                                        {{-- @if($div->VALUE!="00") --}}
                                        <fieldset>
                                          <input type="checkbox" name="perizinan[unit_{{'00'.$div->VALUE}}]" {{ isset(old('perizinan')['unit_00'.$div->VALUE]) ? 'checked=""' : '' }}>
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
                       @include('user.input-menu-dropping')
                     </div>
                     <div class="modal-footer">
                      <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">kembali</button>
                      <!-- <button type="button" id="button_peryataan" onclick="sumbit_post()" class="btn btn-outline-primary">Ya, kirim</button> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade text-xs-left" id="modal_menu_aju_dropping" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <h4 class="modal-title col-md-12 col-sm-12" id="title_modal_pernyataan" >Pengaturan Perizinan <code>Pengajuan Dropping</code></h4>
                    </div>
                    <div class="modal-body" id="body-menu">
                     @include('user.input-menu-pengajuan-dropping')
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
                   @include('user.input-menu-transaksi')
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
                 @include('user.input-menu-anggaran')
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
               @include('user.input-menu-pelaporan')
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
             @include('user.input-menu-user')
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
           @include('user.input-menu-item')
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