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
                	<div class="row match-height">
			            <div class="col-md-12">
			              <div class="card">
			                <div class="card-header">
			                  <h4 class="card-title" id="basic-layout-form-center">Event Registration</h4>
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
			                    <div class="card-text">
			                      <p>This example shows a way to center your form in the card. Here
			                        we have used <code>col-md-6 offset-md-3</code> classes to
			                        center the form in a full width card. User can always change
			                        those classes according to width and offset requirements.
			                        This example also uses form action buttons in the center
			                        bottom position of the card.</p>
			                    </div>
			                    <form class="form">
			                      <div class="row">
			                        <div class="col-md-6 offset-md-3">
			                          <div class="form-body">
			                            <div class="form-group">
			                              <label for="eventInput1">Full Name</label>
			                              <input type="text" id="eventInput1" class="form-control" placeholder="name" name="fullname">
			                            </div>
			                            <div class="form-group">
			                              <label for="eventInput2">Title</label>
			                              <input type="text" id="eventInput2" class="form-control" placeholder="title" name="title">
			                            </div>
			                            <div class="form-group">
			                              <label for="eventInput3">Company</label>
			                              <input type="text" id="eventInput3" class="form-control" placeholder="company" name="company">
			                            </div>
			                            <div class="form-group">
			                              <label for="eventInput4">Email</label>
			                              <input type="email" id="eventInput4" class="form-control" placeholder="email" name="email">
			                            </div>
			                            <div class="form-group">
			                              <label for="eventInput5">Contact Number</label>
			                              <input type="tel" id="eventInput5" class="form-control" name="contact" placeholder="contact number">
			                            </div>
			                            <div class="form-group">
			                              <label>Existing Customer</label>
			                              <div class="input-group">
			                                <label class="display-inline-block custom-control custom-radio ml-1">
			                                  <input type="radio" name="customer1" class="custom-control-input">
			                                  <span class="custom-control-indicator"></span>
			                                  <span class="custom-control-description ml-0">Yes</span>
			                                </label>
			                                <label class="display-inline-block custom-control custom-radio">
			                                  <input type="radio" name="customer1" checked class="custom-control-input">
			                                  <span class="custom-control-indicator"></span>
			                                  <span class="custom-control-description ml-0">No</span>
			                                </label>
			                              </div>
			                            </div>
			                          </div>
			                        </div>
			                      </div>
			                      <div class="form-actions center">
			                        <button type="button" class="btn btn-warning mr-1">
			                          <i class="ft-x"></i> Cancel
			                        </button>
			                        <button type="submit" class="btn btn-primary">
			                          <i class="fa fa-check-square-o"></i> Save
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
                <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script> 
			 	<script src="{{ asset('app-assets/vendors/js/tables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
				<script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"
				  type="text/javascript"></script>
				<script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"
				  type="text/javascript"></script>
                @endsection		