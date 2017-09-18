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
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Tambah Item</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Manajemen Item</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Master Item</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="{{ url('/item/tambah') }}">Tambah Item</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body">
                  <div class="row">
                    <form class="form" action="{{ url('user') }}" method="POST">
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
                                  <input type="text" required="" class="form-control" placeholder="Kode Item" name="kode_item" value="{{ old('item') }}">
                                </div>
                                <div class="form-group">
                                  <label for="eventRegInput1">Item</label>
                                  <input type="text" required="" class="form-control" placeholder="Item" name="item" value="{{ old('item') }}">
                                </div>
                                <div class="form-group">
                                <label for="eventRegInput2">Jenis Anggaran</label>
                                  <div = "row">
                                    <div class = "col-md-10">
                                      <select class="select2 form-control" name="jenis">
                                        <option selected disabled="">Jenis Anggaran</option>
                                      </select>
                                    </div>
	                                  <div class = "col-md-2">
	                                  	<button type="submit" data-toggle="modal" data-target="#xSmall" class="btn btn-success">
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
                                      </select>
                                    </div>
                                    <div class = "col-md-2">
                                      <button type="submit" data-toggle="modal" data-target="#xSmall" class="btn btn-success">
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
                                      </select>
                                    </div>
                                    <div class = "col-md-2">
                                      <button type="submit" data-toggle="modal" data-target="#xSmall" class="btn btn-success">
                                        <i class="fa fa-plus"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                                {{-- <div class="form-group">
                                  <label>Cabang</label>
                                  <select class="select2 form-control" name="cabang">
                                    <option selected disabled="">Kantor Cabang</option>
                                    @foreach($cabang as $cab)
                                    <option {{ old('cabang') == $cab->VALUE ? 'selected=""' : '' }} value="{{ $cab->VALUE }}">{{ $cab->DESCRIPTION }}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label>Divisi</label>
                                  <select class="select2 form-control" name="divisi" >
                                    <option selected disabled="">Divisi</option>
                                    @foreach($divisi as $div)
                                    <option {{ old('divisi') == $div->VALUE ? 'selected=""' : '' }} value="{{ $div->VALUE }}">{{ $div->DESCRIPTION }}</option>
                                    @endforeach
                                  </select>
                                </div> --}}
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
                                    <select class = "select2 form-control" name="account">
                                      <option selected disabled="">COA</option>
                                    </select>
                                  </div>
                                  <div class="col-md-3">
    	                     			    <input type="text" id="segmen1" class="form-control" name="segmen1" value="" disabled>
    		                          </div>
    				                    </div>
    		                        <div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen2">Program</label>
    		                          <div class="col-md-7">
    		                          	<input type="text" id="program" class="form-control" name="program" value="" disabled>
    		                          </div>
    		                          <div class="col-md-3">
    		                          	<input type="text" id="segmen2" class="form-control" name="segmen2" value="" disabled>
      				                    </div>
    		                        </div>
    		                        <div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen3">KPKC</label>
    	                        	  <div class="col-md-7">
    	                          		<input type="text" id="kpkc" class="form-control" name="kpkc" value="" disabled>
    	                        	  </div>
    		                          <div class="col-md-3">
    	                          		<input type="text" id="segmen3" class="form-control" name="segmen3" value="" disabled>
    			                        </div>
    		                        </div>
    		                        <div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen4">Divisi</label>
    		                          <div class="col-md-7">
    		                          	<input type="text" id="divisi" class="form-control" name="divisi" value="" disabled>
    		                          </div>
    		                          <div class="col-md-3">
    		                          	<input type="text" id="segmen4" class="form-control" name="segmen4" value="" disabled>
    				                      </div>
    		                        </div>
    		                        <div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen5">Sub Pos</label>
    		                          <div class="col-md-7">
    		                          	<input type="text" id="subpos" class="form-control" name="subpos" value="" disabled>
    		                          </div>
    		                          <div class="col-md-3">
    		                          	<input type="text" id="segmen5" class="form-control" name="segmen5" value="" disabled>
    				                      </div>
    		                        </div>
                              	<div class="form-group row">
    		                          <label class="col-md-2 label-control" for="segmen6">Mata Anggaran</label>
    		                          <div class="col-md-7">
    		                            <input type="text" id="kegiatan" class="form-control" name="kegiatan" value="" disabled>
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
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script> 
			 	<script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/jquery.dataTables.min.js') }}"></script>
				<script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
				<script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
                @endsection		