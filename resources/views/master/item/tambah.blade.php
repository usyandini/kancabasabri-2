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
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
                @endsection

                @section('content')
               	<div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Tambah Item</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Manajemen Item</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Master Item</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="{{ url('/item/create') }}">Tambah Item</a>
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
                    <form class="form" action="{{ url('item/add') }}" method="POST">
                      <div class="col-md-6">
                        {{ csrf_field() }}
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-card-center">Data Item</h4>
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
                                  <label for="eventRegInput1">Kode Item</label>
                                  <input type="text" required="" class="form-control" placeholder="Kode Item" name="kode_item" value="{{ old('kode_item') }}">
                                </div>
                                <div class="form-group">
                                  <label for="eventRegInput1">Item</label>
                                  <input type="text" required="" class="form-control" placeholder="Item" name="nama_item" value="{{ old('nama_item') }}">
                                </div>
                                <div class="form-group">
                                <label for="jenis">Jenis Anggaran</label>
                                  <div = "row">
                                    <div class = "col-md-10">
                                      <select class="select2 form-control" name="jenis" id="jenis">
                                        <option selected disabled="">Jenis Anggaran</option>
                                        @foreach($jenis as $ja)
                                        <option {{ old('jenis') == $ja->kode ? 'selected=""' : '' }} value="{{ $ja->name }}">{{ $ja->kode }} - {{ $ja->name }}</option>
                                        @endforeach
                                      </select>
                                    </div>
	                                  <div class = "col-md-2">
                                      <button type="button" class="btn btn-success" data-target="#tambahJenis" data-toggle="modal">
                                        <i class="fa fa-plus"></i>
                                      </button>
	                                  </div>
                                  </div>
                             	  </div>
                                <div class="form-group">
                                  <label for="eventRegInput3">Kelompok Anggaran</label>
                                  <div = "row">
                                    <div class = "col-md-10">
                                      <select class="select2 form-control" name="kelompok">
                                        <option selected disabled="">Kelompok Anggaran</option>
                                        @foreach($kelompok as $ka)
                                        <option {{ old('kelompok') == $ka->kode ? 'selected=""' : '' }} value="{{ $ka->name }}">{{ $ka->kode }} - {{ $ka->name }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class = "col-md-2">
                                      <button type="button" class="btn btn-success" data-target="#tambahKelompok" data-toggle="modal">
                                        <i class="fa fa-plus"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="eventRegInput4">Pos Anggaran</label>
                                  <div = "row">
                                    <div class = "col-md-10">
                                      <select class="select2 form-control" name="pos">
                                        <option selected disabled="">Pos Anggaran</option>
                                        @foreach($pos as $pa)
                                        <option {{ old('pos') == $pa->kode ? 'selected=""' : '' }} value="{{ $pa->name }}">{{ $pa->kode }} - {{ $pa->name }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class = "col-md-2">
                                      <button type="button" class="btn btn-success" data-target="#tambahPos" data-toggle="modal">
                                        <i class="fa fa-plus"></i>
                                      </button>
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
                                    <select class = "select2 form-control" name="account" id="account">
                                      <option selected disabled="">Main Account</option>
                                      @foreach($item as $coa)
                                      <option {{ old('account') == $coa->MAINACCOUNTID ? 'selected=""' : '' }} value="{{ $coa->MAINACCOUNTID }}">{{ $coa->NAME }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="col-md-3">
                                    <input type="text" id="segmen1" class="form-control" name="segmen1" onblur="getVal()" readonly="">
    		                          </div>
    				                    </div>
    		                        <div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen2">Program</label>
    		                          <div class="col-md-7">
                                    <select class = "select2 form-control" name="program">
                                      <option selected disabled="">Program</option>
                                      @foreach($program as $prog)
                                      <option {{ old('program') == $prog->VALUE ? 'selected=""' : '' }} value="{{ $prog->VALUE }}">{{ $prog->DESCRIPTION }}</option>
                                      @endforeach
                                    </select>
    		                          </div>
    		                          <div class="col-md-3">
    		                          	<input type="text" id="segmen2" class="form-control" name="segmen2" value="" disabled>
      				                    </div>
    		                        </div>
    		                        <div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen3">KPKC</label>
    	                        	  <div class="col-md-7">
                                    <select class = "select2 form-control" name="kpkc">
                                      <option selected disabled="">KPKC</option>
                                      @foreach($kpkc as $unit)
                                      <option {{ old('kpkc') == $unit->VALUE ? 'selected=""' : '' }} value="{{ $unit->VALUE }}">{{ $unit->DESCRIPTION }}</option>
                                      @endforeach
                                    </select>
    	                        	  </div>
    		                          <div class="col-md-3">
    	                          		<input type="text" id="segmen3" class="form-control" name="segmen3" value="" disabled>
    			                        </div>
    		                        </div>
    		                        <div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen4">Divisi</label>
    		                          <div class="col-md-7">
                                    <select class = "select2 form-control" name="divisi">
                                      <option selected disabled="">Divisi</option>
                                      @foreach($divisi as $div)
                                      <option {{ old('divisi') == $div->VALUE ? 'selected=""' : '' }} value="{{ $div->VALUE }}">{{ $div->DESCRIPTION }}</option>
                                      @endforeach
                                      </select>
    		                          </div>
    		                          <div class="col-md-3">
    		                          	<input type="text" id="segmen4" class="form-control" name="segmen4" value="" disabled>
    				                      </div>
    		                        </div>
    		                        <div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen5">Sub Pos</label>
    		                          <div class="col-md-7">
    		                          	<select class = "select2 form-control" name="subpos">
                                      <option selected disabled="">Sub Pos</option>
                                      @foreach($subpos as $subp)
                                      <option {{ old('subpos') == $subp->VALUE ? 'selected=""' : '' }} value="{{ $subp->VALUE }}">{{ $subp->DESCRIPTION }}</option>
                                      @endforeach
                                    </select>
    		                          </div>
    		                          <div class="col-md-3">
    		                          	<input type="text" id="segmen5" class="form-control" name="segmen5" value="" disabled>
    				                      </div>
    		                        </div>
                              	<div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen6">Mata Anggaran</label>
    		                          <div class="col-md-7">
    		                            <select class = "select2 form-control" name="kegiatan">
                                      <option selected disabled="">Mata Anggaran</option>
                                      @foreach($m_anggaran as $ma)
                                        <option {{ old('kegiatan') == $ma->VALUE ? 'selected=""' : '' }} value="{{ $ma->VALUE }}">{{ $ma->DESCRIPTION }}</option>
                                      @endforeach
                                    </select>
    		                          </div>
    		                          <div class="col-md-3">
    		                        	  <input type="text" id="segmen6" class="form-control" name="segmen6" value="" disabled>
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
                              <div class="form-actions right">
                                <a href="{{ url('item') }}" class="btn btn-warning mr-1">
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
        			 	<script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/jquery.dataTables.min.js') }}"></script>
        				<script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
        				<script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/modal/components-modal.min.js') }}"></script>
                <script type="text/javascript">
                  function getVal(){
                    // var coa1 = coa = account_field = null;
                    // coa1 = document.getElementById("account").value;
                    // coa = document.getElementById("segmen1");
                    // account_field = fields.text.prototype.coa.call(this);
                    // $(account_field).val(coa1);
                    var inv_nrs;
                    inv_nrs = document.getElementById('account');
                    //document.getElementById('txt2').value = inv_nrs;
                    return inv_nrs.options[inv_nrs.selectedIndex].value;
                  }
                </script>
                @endsection		