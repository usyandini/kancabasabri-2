                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
                @endsection

                @section('content')
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Informasi Dropping</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index-2.html">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">Informasi Dropping
                                    </li>
                                    <li class="breadcrumb-item active">Tarik Tunai
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body"><!-- Basic scenario start -->
                    <section id="basic">
                        <div class="row">
                            <div class="col-xs-7">
                                <div class="card">
                                    <div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Tarik Tunai Dropping</h4>
	                            </div>
	                            <div class="card-content table-responsive">
		                            <div class="col-md-6">
			                            	<div class="form-group" style="overflow: hidden;" >
				                                <div class="col-md-3">
				                                    <label for="">Tanggal</label>
				                                </div>
				                                <div class="col-md-9">
				                                    <input type="text" placeholder="{{date('d/m/Y')}}" class="form-control" disabled>
				                                </div>
				                            </div>
				                            <div class="form-group" style="overflow: hidden;" >
				                                <div class="col-md-3">
				                                    <label for="">Jumlah</label>
				                                </div>
				                                <div class="col-md-9">
				                                    <input type="text" placeholder="100.000.000" class="form-control" disabled>
				                                </div>
				                            </div>
				                            <div class="form-group" style="overflow: hidden;" >
				                                <div class="col-md-3">
				                                    <label for="">Nama Bank</label>
				                                </div>
				                                <div class="col-md-9">
				                                    <input type="text" placeholder="BCA" class="form-control" disabled>
				                                </div>
				                            </div>
				                            <div class="form-group" style="overflow: hidden;" >
				                                <div class="col-md-3">
				                                    <label for="">No. Rekening</label>
				                                </div>
				                                <div class="col-md-9">
				                                    <input type="text" placeholder="121000111098" class="form-control" disabled>
				                                </div>
				                            </div>
				                            <div class="form-group" style="overflow: hidden;" >
				                                <div class="col-md-3">
				                                    <label for="">Cabang</label>
				                                </div>
				                                <div class="col-md-9">
				                                    <input type="text" placeholder="Jakarta Timur" class="form-control" disabled>
				                                </div>
				                            </div>
				                            <div class="form-group" style="overflow: hidden;" >
				                                <div class="col-md-9">
				                                    <label for="">Apakah nominal sesuai dengan dropping?</label>
				                                </div>
				                                <div class="col-md-6">
				                                    <input type="checkbox" name="check1" value="ya" class="form-control">Iya<br/>
				                                    <input type="checkbox" name="check2" value="tidak" class="form-control">Tidak<br/>
				                                </div>
				                            </div>						                         
				                        <a href="<?php echo $app->make('url')->to('/table');?>" class="btn btn-primary pull-right">Posting<div class="ripple-container"></div></a>

			                            <a href="<?php echo $app->make('url')->to('/table');?>" class="btn btn-primary pull-right" style = "background-color:#F1C40F">Keluar<div class="ripple-container"></div></a>

			                            <?php
			                            	
			                            ?>
			                            <a href="<?php echo $app->make('url')->to('/pengembalian');?>" class="btn btn-primary">Pengembalian kelebihan dropping</a>

			                            <a href="<?php echo $app->make('url')->to('/penambahan');?>" class="btn btn-primary">Penambahan kekurangan dropping</a>

			                        </div>
		                     	</div>
	                        </div>
	                    </div>

	                    
	                    </div>
	                </div>
	            </div>
	        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                        
                                    </div>
                                    <!--<div class="card-body collapse in">
                                        <div class="card-block card-dashboard ">
                                            <!-- <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p> >--
                                            <div id="basicScenario"></div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Basic scenario end -->
                </div>
                @endsection

                @section('customjs')
                <!-- BEGIN PAGE VENDOR JS-->
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
                <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/griddata.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                {{-- <script src="{{ asset('app-assets/js/scripts/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script> --}}
                <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE LEVEL JS-->

                <script type="text/javascript">
                  $(document).ready(function() {
                    $("#basicScenario").jsGrid( {
                      width:"100%", 
                      // height:"400px",
                      sorting:!0, 
                      autoload:!0,
                      paging:!0,
                      pagesize:15,
                      pageButtonCount:5, 
                      controller: {
                        loadData: function(filter) {
                          return $.ajax({
                              type: "GET",
                              url: "{{ url('dropping/get') }}",
                              data: filter,
                              dataType: "JSON"
                          })
                        }
                      }, 
                      fields: [
                          { name: "journalnum", type: "text", title: "Nomor Jurnal", width: 90 },
                          { name: "account", type: "text", title: "Nama Bank", width: 80 },
                          { name: "mainaccount", type: "text", title: "No. Rekening", width: 100 },
                          { name: "transdate", type: "text", title: "Tanggal Transaksi", width: 100 },
                          { name: "credit", type: "text", title: "Nominal", width: 100 },
                          { name: "company", type: "text", title: "Cabang", width: 100 },
                          { name: "company", type: "control", itemTemplate:function(e) {
                            return "<a href='{{ url('/dropping/get') }}/"+ e +"' class='btn btn-success btn-sm'>Lanjut</a>"
                          }}
                      ]
                    })
                  });
                </script>
                @endsection