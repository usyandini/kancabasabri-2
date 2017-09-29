                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
  				<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css') }}">
                <style type="text/css">
                  .hide {
                    display: none;
                  }
                </style>
                @endsection

                @section('content')
		         

               	<div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Informasi Semua Notifikasi</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('notification/read_all') }}">Informasi Semua Notifikasi</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
               
                  	<div class="row">
                    <section id="select-inputs">
			          <div class="row">
			            <div class="col-xs-12">
			              <div class="card">
			                <div class="card-header">
			                  <h4 class="card-title">Semua Notifikasi</h4></br>
			                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			                  <div class="card-body collapse in">			                
			                  	<div class="card-block">
			                  	
                				</div>
                			</div>
						</div>
			                <div class="card-body collapse in">			                
			                  <div class="card-block">
				                <name="data" id="data">
			                    <div class="table-responsive">
			                      <table class="table table-striped table-bordered datatable-select-inputs" cellspacing="0" width="100%">
			                        <thead>
			                          <tr>
			                            <th><center>No</center></th>
			                            <th id="filterable"><center>Keterangan</center></th>
			                            <th id="filterable"><center>Waktu</center></th>
			                            <th><center>Aksi</center></th>
			                          </tr>
			                        </thead>
			                        <tbody>
			                        		<?php $no='1';?>
			                        		@if(count($notification_all))
			                        		@foreach($notification_all as $notif)
			                        		
			                        		<tr>
			                        			<td><center>{{ $no }}</center></td>
			                        			<td><p class="notification-text font-small-3 text-muted">{{$notif['wording'] }}</p>
			                        			<td><center>{{$notif['time']}}</center>
												<td><center>
													<?php
														// $link = false;
														$url =  url('notification/redirect')."/".$notif['id'];
														if($notif['type'] == 17||$notif['type'] == 19||$notif['type'] == 21||
															$notif['type'] == 23||$notif['type'] == 25||$notif['type'] == 27||$notif['type'] == 29){
															if(Gate::check('notif_ubah_a')){
													            
																if($notif['type'] == 17&&Gate::check('notif_setuju_iia')){

																}else if($notif['type'] == 19&&Gate::check('notif_setuju_iiia')){

																}else if($notif['type'] == 21&&Gate::check('notif_setuju_iva')){

																}else if($notif['type'] == 23&&Gate::check('notif_setuju_va')){

																}else if($notif['type'] == 25&&Gate::check('notif_setuju_via')){

																}else if($notif['type'] == 27&&Gate::check('notif_setuju_viia')){

																}else if($notif['type'] == 29&&Gate::check('notif_setuju_viiia')){

																}else{
													            	$url = "";
													            }
													        }
														}else if($notif['type'] == 12){
															if(Gate::check('notif_ubah_d')&&Gate::check('notif_setuju_p2_d')){
																$url = "";
															}

														}else if($notif['type'] == 4){
															if(Gate::check('notif_ubah_t')&&Gate::check('notif_setuju2_t')){
																$url = "";
															}
														}

													?>
													@if($url!=""||$notif['is_read'] == 1)
													<a href="{{ $url }}" class="btn btn-sm btn-primary"><i class="fa fa-send"></i></a>
													@endif
													</center>
												</td>
								     		</tr>
			                        		<?php $no++;?>
			                        		@endforeach
			                        		@endif
			                        </tbody>
			                      </table>
			                      
			                    </div>
			                  </div>
			                </div>
			              </div>
			            </div>
			          </div>
			        </section>
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
				<script type="text/javascript">

					

					function remove_attr_data_table(){
						$("#DataTables_Table_0_length").css("display", "none");
						// $("#DataTables_Table_0_info").css("display", "none");
						// $("#DataTables_Table_0_previous").empty();
						// $("#DataTables_Table_0_previous").append('<a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">Sebelumnya</a>');

						// $("#DataTables_Table_0_next").empty();
						// $("#DataTables_Table_0_next").append('<a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">Selanjutnya</a>');

					}
					$('.datatable-select-inputs').DataTable( {
							scrollX: true,
							"language": {
								"paginate": {
								  "previous": "Sebelumnya",
								  "next": "Selanjutnya"
								},

    							"emptyTable":  "Tidak Ada Notifikasi Masuk",
    							"info":  "Data Notifikasi _START_-_END_ dari _TOTAL_ Notifikasi",
    							"infoEmpty":  "",
    							"search": "Pencarian:",
							},
							
						    initComplete: function () {
						        this.api().columns('#filterable').every( function () {
						            var column = this;
						            var select = $('<select><option value="">Filter kolom</option></select>')
						                .appendTo( $(column.footer()).empty() )
						                .on( 'change', function () {
						                    var val = $.fn.dataTable.util.escapeRegex(
						                        $(this).val()
						                    );

						                    column
						                        .search( val ? '^'+val+'$' : '', true, false )
						                        .draw();
						                } );

						            column.data().unique().sort().each( function ( d, j ) {
						                select.append( '<option value="'+d+'">'+d+'</option>' );
						            } );
						        } );
						    }
						} );

					window.remove_attr_data_table();

				</script>
                @endsection