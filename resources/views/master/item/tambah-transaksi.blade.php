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
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/custom.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
                @endsection

                @section('content')
               	<div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Tambah Item Transaksi</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/item/transaksi') }}">Manajemen Item Transaksi</a>
                                    </li>
                                    <li class="breadcrumb-item active">Tambah Item Transaksi
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body">
                  <div class="row">
                    @if(session('success'))
                    <div class="col-xs-7">
                      <div class="alert alert-success">
                        <b>Data item berhasil ditambah.</b>
                      </div>
                    </div>
                    @elseif(session('unique'))
                    <div class="col-xs-7">
                        <div class="alert alert-warning">
                          <b>Kode item harus unik.</b>
                        </div>
                    </div>
                    @endif
                    <form class="form" action="{{ url('item/add/transaksi') }}" method="POST">
                      <div class="col-md-6">
                        {{ csrf_field() }}
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-card-center">Data Item </h4>
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
                                  <div class="form-group col-md-4">
                                    <label for="eventRegInput1">Kode Item</label>
                                    <input type="text" required="Kode item harap diisi" class="form-control" placeholder="Kode Item" name="kode_item" value="{{ old('kode_item') }}">
                                  </div>
                                  <div class="form-group col-md-8">
                                    <label for="eventRegInput1">Nama Item</label>
                                    <input type="text" required="" class="form-control" placeholder="Nama Item" id="nama_item" name="nama_item" value="{{ old('nama_item') }}">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="form-group col-md-12 col-sm-12">
                                    <label for="jenis">Jenis Anggaran</label>
                                    <div = "row">
                                      <div class = "col-md-10 col-sm-10">
                                        <select class="select2 form-control" name="jenis" id="jenis" required>
                                          <option value="" disabled selected>Jenis Anggaran</option>
                                          @foreach($jenis as $ja)
                                          <option {{ old('jenis') == $ja->kode ? 'selected=""' : '' }} value="{{ $ja->kode }}">{{ $ja->kode }} - {{ $ja->name }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class = "col-md-2 col-sm-2">
                                        <button type="button" class="btn btn-success" data-target="#tambahJenis" data-toggle="modal">
                                          <i class="fa fa-plus"></i>
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group col-md-12 col-sm-12">
                                    <label for="eventRegInput3">Kelompok Anggaran</label>
                                    <div = "row">
                                      <div class = "col-md-10 col-sm-10">
                                        <select class="select2 form-control" id="kelompok" name="kelompok" required>
                                          <option value="" disabled selected>Kelompok Anggaran</option>
                                          @foreach($kelompok as $ka)
                                          <option {{ old('kelompok') == $ka->kode ? 'selected=""' : '' }} value="{{ $ka->kode }}">{{ $ka->kode }} - {{ $ka->name }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class = "col-md-2 col-sm-2">
                                        <button type="button" class="btn btn-success" data-target="#tambahKelompok" data-toggle="modal">
                                          <i class="fa fa-plus"></i>
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group col-md-12 col-sm-12">
                                    <label for="eventRegInput4">Pos Anggaran</label>
                                    <div = "row">
                                      <div class = "col-md-10 col-sm-10">
                                        <select class="select2 form-control" id="pos" name="pos" required>
                                          <option value="" disabled selected>Pos Anggaran</option>
                                          @foreach($pos as $pa)
                                          <option {{ old('pos') == $pa->kode ? 'selected=""' : '' }} value="{{ $pa->kode }}">{{ $pa->kode }} - {{ $pa->name }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class = "col-md-2 col-sm-2">
                                        <button type="button" class="btn btn-success" data-target="#tambahPos" data-toggle="modal">
                                          <i class="fa fa-plus"></i>
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-sm-12">
                                    <div class="form-group skin skin-square">
                                      <label>Display item untuk seluruh cabang</label>
                                      <fieldset>
                                        <input type="radio" id='item_display_on' name="item_display" value="1">
                                        <label class="mr-1">Iya</label>
                                        <input type="radio" id='item_display_off' name="item_display" value="0" checked>
                                        <label>Tidak</label>
                                      </fieldset>
                                    </div>
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
                            <h4 class="card-title" id="basic-layout-card-center">Financial Dimension</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                          </div>
                          <div class="card-body">
                            <div class="card-block">
                              <div class="form form-horizontal striped-rows">
                              	<div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen1">Account</label>
    		                          <div class="col-md-7">
                                    <select class = "select2 form-control account" name="account" id="account" onchange="getVal('account', 'segmen1');" required>
                                      <option value="" disabled selected>Main Account</option>
                                      @foreach($item as $coa)
                                      <option {{ old('account') == $coa->MAINACCOUNTID ? 'selected=""' : '' }} value="{{ $coa->MAINACCOUNTID }}">{{ $coa->NAME }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="col-md-3">
                                    <input id="segmen1" class="form-control" name="segmen1" value="" readonly="">
    		                          </div>
    				                    </div>
    		                        <div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen2">Program</label>
    		                          <div class="col-md-7">
                                    <select class = "select2 form-control" id="program" name="program" onchange="getVal('program', 'segmen2');" required>
                                      <option value="" disabled selected>Program</option>
                                      @foreach($program as $prog)
                                      <option {{ old('program') == $prog->VALUE ? 'selected=""' : '' }} value="{{ $prog->VALUE }}">{{ $prog->DESCRIPTION }}</option>
                                      @endforeach
                                    </select>
    		                          </div>
    		                          <div class="col-md-3">
    		                          	<input id="segmen2" class="form-control" name="segmen2" value="" readonly="">
      				                    </div>
    		                        </div>
    		                        <div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen3">KPKC</label>
    	                        	  <div class="col-md-7">
                                    <select class = "select2 form-control" id="kpkc" name="kpkc" onchange="getVal('kpkc', 'segmen3');" required>
                                      <option value="" disabled selected>KPKC</option>
                                      @foreach($kpkc as $unit)
                                      <option {{ old('kpkc') == $unit->VALUE ? 'selected=""' : '' }} value="{{ $unit->VALUE }}">{{ $unit->DESCRIPTION }}</option>
                                      @endforeach                              
                                    </select>
    	                        	  </div>
    		                          <div class="col-md-3">
    	                          		<input id="segmen3" class="form-control" name="segmen3" value="" readonly="">
    			                        </div>
    		                        </div>
    		                        <div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen4">Divisi</label>
    		                          <div class="col-md-7">
                                    <select class = "select2 form-control" id="divisi" name="divisi" onchange="getVal('divisi', 'segmen4');" required>
                                      <option value="" disabled selected>Divisi</option>
                                      @foreach($divisi as $div)
                                      @if($div->VALUE == '00')
                                        <option {{ old('divisi') == 'None' ? 'selected=""' : '' }} value="00">None</option>
                                      @else                                    
                                        <option {{ old('divisi') == $div->VALUE ? 'selected=""' : '' }} value="{{ $div->VALUE }}">{{ $div->DESCRIPTION }}</option>
                                      @endif    
                                      @endforeach
                                      </select>
    		                          </div>
    		                          <div class="col-md-3">
    		                          	<input id="segmen4" class="form-control" name="segmen4" value="" readonly="">
    				                      </div>
    		                        </div>
    		                        <div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen5">Sub Pos</label>
    		                          <div class="col-md-7">
    		                          	<select class = "select2 form-control" id="subpos" name="subpos" onchange="getVal('subpos', 'segmen5');" required>
                                      <option value="" disabled selected>Sub Pos</option>
                                      @foreach($subpos as $subp)
                                      <option {{ old('subpos') == $subp->VALUE ? 'selected=""' : '' }} value="{{ $subp->VALUE }}">{{ $subp->DESCRIPTION }}</option>
                                      @endforeach
                                    </select>
    		                          </div>
    		                          <div class="col-md-3">
    		                          	<input id="segmen5" class="form-control" name="segmen5" value="" readonly="">
    				                      </div>
    		                        </div>
                              	<div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen6">Mata Anggaran</label>
    		                          <div class="col-md-7">
    		                            <select class = "select2 form-control" id="kegiatan" name="kegiatan" onchange="getVal('kegiatan', 'segmen6');" required>
                                      <option value="" disabled selected>Mata Anggaran</option>
                                      @foreach($m_anggaran as $ma)
                                        <option {{ old('kegiatan') == $ma->VALUE ? 'selected=""' : '' }} value="{{ $ma->VALUE }}">{{ $ma->DESCRIPTION }}</option>
                                      @endforeach
                                    </select>
    		                          </div>
    		                          <div class="col-md-3">
    		                        	  <input id="segmen6" class="form-control" name="segmen6" value="" readonly="">
        				                  </div>
        				              	</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-block">
                              <div class="pull-right">
                                <a href="{{ url('item/transaksi') }}" class="btn btn-danger">
                                  <i class="ft-x"></i> Kembali
                                </a>    
                                <button type="submit" class="btn btn-outline-primary">
                                  <i class="fa fa-check-square-o"></i> Simpan
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                    <div class="modal fade text-xs-left" id="tambahJenis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Jenis Anggaran</h4>
                          </div>
                          <form class="form" id="jenis-form" action="{{ URL('item/submit/jenis') }}" method="POST">
                          {{ csrf_field() }}
                            <div class="modal-body" id="confirmation-msg">
                                <div class="form-group">
                                  <label for="kode_jenis">Kode</label>
                                    <input class="form-control" type="text" name="kode_jenis" placeholder="Kode Jenis Anggaran" value="">
                                </div>
                                <div class="form-group">
                                  <label for="nama_jenis">Jenis Anggaran</label>
                                    <input class="form-control" type="text" name="nama_jenis" placeholder="Nama Jenis Anggaran" value="">
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                              <button type="submit" id="simpan" class="btn btn-outline-primary">Simpan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="modal fade text-xs-left" id="tambahKelompok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Kelompok Anggaran</h4>
                          </div>
                          <form class="form" id="jenis-form" action="{{ URL('item/submit/kelompok') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="modal-body" id="confirmation-msg">
                              <div class="form-group">
                                <label for="kode_kelompok">Kode</label>
                                  <input class="form-control" type="text" name="kode_kelompok" placeholder="Kode Kelompok Anggaran" value="">
                              </div>
                              <div class="form-group">
                                <label for="nama_jenis">Kelompok Anggaran</label>
                                  <input class="form-control" type="text" name="nama_kelompok" placeholder="Nama Kelompok Anggaran" value="">
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                              <button type="submit" id="simpan" class="btn btn-outline-primary">Simpan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="modal fade text-xs-left" id="tambahPos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Pos Anggaran</h4>
                          </div>
                          <form class="form" id="pos-form" action="{{ URL('item/submit/pos') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="modal-body" id="confirmation-msg">
                              <div class="form-group">
                                <label for="kode_kelompok">Kode</label>
                                  <input class="form-control" type="text" name="kode_pos" placeholder="Kode Pos Anggaran" value="">
                              </div>
                              <div class="form-group">
                                <label for="nama_jenis">Pos Anggaran</label>
                                  <input class="form-control" type="text" name="nama_pos" placeholder="Nama Pos Anggaran" value="">
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                              <button type="submit" id="simpan" class="btn btn-outline-primary">Simpan</button>
                            </div>
                          </form>
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
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script> 
        			 	<script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/jquery.dataTables.min.js') }}"></script>
        				<script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
        				<script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/modal/components-modal.min.js') }}"></script>
                <script type="text/javascript">
                  function getVal(s, v){
                    var inv_nrs;
                    inv_nrs = document.getElementById(s);
                    /* Ketika nama item diambil dari nama mata anggaran */
                    // if(s = 'kegiatan'){
                    //   document.getElementById('nama_item').value = inv_nrs.options[inv_nrs.selectedIndex].text;
                    // }
                    return document.getElementById(v).value = inv_nrs.options[inv_nrs.selectedIndex].value;
                  }

                  //alert for required in bahasa
                  document.addEventListener("DOMContentLoaded", function() {
                      var elements = document.getElementsByTagName("INPUT");
                      for (var i = 0; i < elements.length; i++) {
                          elements[i].oninvalid = function(e) {
                              e.target.setCustomValidity("");
                              if (!e.target.validity.valid) {
                                  e.target.setCustomValidity("Kolom harap diisi");
                              }
                          };
                          elements[i].oninput = function(e) {
                              e.target.setCustomValidity("");
                          };
                      }

                      var select = document.getElementsByTagName("SELECT");
                      for (var i = 0; i < select.length; i++) {
                          select[i].oninvalid = function(e) {
                              e.target.setCustomValidity("");
                              if (!e.target.validity.valid) {
                                  e.target.setCustomValidity("Harap memilih pada kolom ini");
                              }
                          };
                          select[i].oninput = function(e) {
                              e.target.setCustomValidity("");
                          };
                      }
                  });

                  $('input[type="radio"]').iCheck('enable')
                  $('input').iCheck({
                    checkboxClass: 'icheckbox_square-red',
                    radioClass: 'iradio_square-red',
                    increaseArea: '20%' // optional
                  });
                </script>
                @endsection		