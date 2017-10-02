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
                {{-- part alert --}}
		         @if (Session::has('after_save'))
		             <div class="row">
		                 <div class="col-md-12">
		                     <div class="alert alert-dismissible alert-{{ Session::get('after_save.alert') }}">
		                       <button type="button" class="close" data-dismiss="alert">×</button>
		                       <strong>{{ Session::get('after_save.title') }}</strong>
		                       
		                     </div>
		                 </div>
		             </div>
		         @endif
		         {{-- end part alert --}}


		         {{-- Kita cek, jika sessionnya ada maka tampilkan alertnya, jika tidak ada maka tidak ditampilkan alertnya --}}
        
		         @if (Session::has('after_update'))
		             <div class="row">
		                 <div class="col-md-12">
		                     <div class="alert alert-dismissible alert-{{ Session::get('after_update.alert') }}">
		                       <button type="button" class="close" data-dismiss="alert">×</button>
		                       <strong>{{ Session::get('after_update.title') }}</strong>
		                       
		                     </div>
		                 </div>
		             </div>
		         @endif
		         {{-- end part alert --}}

		         {{-- Kita cek, jika sessionnya ada maka tampilkan alertnya, jika tidak ada maka tidak ditampilkan alertnya --}}
        
		         @if (Session::has('after_delete'))
		             <div class="row">
		                 <div class="col-md-12">
		                     <div class="alert alert-dismissible alert-{{ Session::get('after_delete.alert') }}">
		                       <button type="button" class="close" data-dismiss="alert">×</button>
		                       <strong>{{ Session::get('after_delete.title') }}</strong>
		                       
		                     </div>
		                 </div>
		             </div>
		         @endif
		         {{-- end part alert --}}
		         

               	<div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Manajemen Program Prioritas</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Manajemen Item</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="{{ url('/program_prioritas') }}">Manajemen Program Prioritas</a>
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
			                  <h4 class="card-title">Daftar Program Prioritas</h4></br>
			                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			                  <div class="card-body collapse in">			                
			                  	<div class="card-block">
			                  	<span><a class="btn btn-success" data-target="#tambah" data-toggle="modal"><i class="fa fa-plus"></i> <b>Tambah Program Prioritas</b></a></span>
                           			<div class="modal fade" data-backdrop="static" id="tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-plus"></i> Tambah Program Prioritas</h4></center>
                                                </div>
                                                <form enctype="multipart/form-data" role="form" action="{{ URL('program_prioritas/store_program_prioritas') }}" method="POST" >
                                                 {{ csrf_field() }}
                                                <div class="modal-body">
                                                    
                                                <label class="control-label"><b> Program Prioritas </b></label>
                                                <label class="control-label"> : </label>
											        <input class="form-control" type="text" name="program_prioritas" placeholder="masukkan program prioritas" required="required"/>
											        
                                                	
                                            	</div>
                                            	<div class="modal-footer">
                                                <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Tambah</button>
                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                                            	</div>
                                            	</form>
                						</div>
                					</div>
                				</div>
                			</div>
						</div>
			                <div class="card-body collapse in">			                
			                  <div class="card-block">
		                  		@if(session('success'))
				                  	<div class="alert alert-success">
				                  		{!! session('success') !!}
				                	</div>
				                @endif
				                
			                    <div class="table-responsive">
			                      <table class="table table-striped table-bordered datatable-select-inputs nowrap" cellspacing="0" width="100%">
			                        <thead>
			                          <tr>
			                            <th><center>No</center></th>
			                            <th id="filterable"><center>Program prioritas</center></th>
			                            
			                            <th><center>Aksi</center></th>
			                          </tr>
			                        </thead>
			                        <tbody>
			                        		<?php $no='1';?>
			                        		@if(count($program_prioritas))
			                        		@foreach($program_prioritas as $reason)
			                        		
			                        		<tr>
			                        			<td><center>{{ $no }}</center></td>
			                        			<td>{{ $reason->program_prioritas }}</td>
												
												<td><center>
													<span data-toggle='tooltip' title='Ubah'><a class="btn btn-info btn-sm" data-target="#ubah{{$reason->id}}" data-toggle="modal"><i class="fa fa-edit"></i> </a></span>

													

                                        			<span data-toggle='tooltip' title='Hapus'><a class="btn btn-danger btn-sm" data-target="#hapus{{$reason->id}}" data-toggle="modal"><i class="fa fa-trash"></i> </a></span>

													<div class="modal fade" data-backdrop="static" id="hapus{{$reason->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        				<div class="modal-dialog">
                                            				<div class="modal-content">
                                                				<div class="modal-header">
                                                    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    				<h4 class="modal-title text-warning" id="myModalLabel" ><i class="fa fa-warning"></i> Perhatian !</h4>
                                                				</div>
                                                					<div class="modal-body">
                                                   						<h4>Anda yakin ingin menghapus Program Prioritas <br><span class=text-danger>{{ $reason->program_prioritas }}</span> ?</h4>
                                                					</div>
                                                						<div class="modal-footer">
                                                   							<a href="{{ URL('program_prioritas/delete_program_prioritas/'. $reason->id) }}"" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Ya</a>
                                                    						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                                						</div>
                                            				</div>
                                            			</div>
                                        			</div>

												</center></td>
								     		</tr>
								     		<div class="modal fade" data-backdrop="static" id="ubah{{$reason->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        				<div class="modal-dialog">
                                            				<div class="modal-content">
                                                				<div class="modal-header">
                                                    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    				<center><h4 class="modal-title text-info" id="myModalLabel" ><i class="fa fa-edit"></i> Ubah Program Prioritas</h4></center>
                                                				</div>
                                                					<div class="modal-body">
                                                						<form enctype="multipart/form-data" role="form" action="{{ URL('program_prioritas/update_program_prioritas/'. $reason->id) }}" method="POST" >
                                                 						{{ csrf_field() }}
                                                 						<input type="hidden" name="id"  value="{{$reason->id}}" />
                                                 						
                                                 						
                                                						<label class="control-label"><b> Program Prioritas </b></label>
                                                						<label class="control-label"> : </label>
											                            <input class="form-control" type="text" name="program_prioritas" placeholder="masukkan program prioritas" value="{{$reason->program_prioritas}}" required="required"/>
											                        </div>
                                                					<div class="modal-footer">
                                                						<button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Ubah</button>
                                                						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                                            						</div>
                                            							</form>
                                            				</div>
                                            			</div>
                                        			</div>
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

					
					$('.datatable-select-inputs').DataTable( {
							scrollX: true,
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

				</script>
				
                @endsection