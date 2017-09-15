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
                        <h3 class="content-header-title mb-0">Manajemen Alasan Menolak</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Manajemen Item</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="{{ url('/reason') }}">Manajemen Alasan Menolak</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body">
                  <div class="row">
                    <section id="select-inputs">
			          <div class="row">
			            <div class="col-xs-12">
			              <div class="card">
			                <div class="card-header">
			                  <h4 class="card-title">Filter Alasan</h4></br>
			                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			                  
                                                    <table>
                                                    
                                            		<tr>
                                            		<td><b>Keterangan </b></td><td><b> : </b></td>

                                            		<td><select class="select form-control" name="keterangan">
                                                    	<option value="0">Semua keterangan</option>
                                                        <option value="1">Reject transaksi by kasimin (lv1)</option>
														<option value="2">Reject transaksi by akuntansi (lv2)</option>  
														<option value="3">Reject tarik tunai by akuntansi (lv1)</option>
														<option value="4">Reject penyesuaian dropping by bia (lv1)</option>
														<option value="5">Reject penyesuaian dropping by akuntansi (lv2)</option>                                                  
                                                  		</select></td>
                                            		</tr>
                                                	</table>
	                              
			                </div>
			                <div class="card-body collapse in">			                
			                  <div class="card-block">
		                  		
			                    
			                  </div>
			                </div>
			              </div>
			            </div>
			          </div>
			        </section>
                  	</div>



		 {{-- part alert --}}
         @if (Session::has('after_save'))
             <div class="row">
                 <div class="col-md-12">
                     <div class="alert alert-dismissible alert-{{ Session::get('after_save.alert') }}">
                       <button type="button" class="close" data-dismiss="alert">×</button>
                       <strong>{{ Session::get('after_save.title') }}</strong>
                       <a href="javascript:void(0)" class="alert-link">{{ Session::get('after_save.text-1') }}</a> {{ Session::get('after_save.text-2') }}
                     </div>
                 </div>
             </div>
         @endif
         {{-- end part alert --}}



                  	<div class="row">
                    <section id="select-inputs">
			          <div class="row">
			            <div class="col-xs-12">
			              <div class="card">
			                <div class="card-header">
			                  <h4 class="card-title">Daftar Alasan</h4></br>
			                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			                  <div class="card-body collapse in">			                
			                  	<div class="card-block">
			                  	<span><a class="btn btn-info" data-target="#tambah" data-toggle="modal"><i class="fa fa-plus"></i> <b>Tambah Alasan</b></a></span>
                           			<div class="modal fade" data-backdrop="static" id="tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
                                                    <h4 class="modal-title text-success" id="myModalLabel" ><i class="glyphicon glyphicon-edit"></i> Tambah Alasan</h4>
                                                </div>
                                                <form enctype="multipart/form-data" role="form" action="{{ URL('reason/store') }}" method="POST" >
                                                <div class="modal-body text-info">
                                                    <center><table>
                                                    <tr>
                                            		<td><b>Alasan </b></td><td><b> : </b></td>
                                            		<td><input class="form-control" type="text" name="alasan" placeholder="masukkan alasan" /></td>
                                            		</tr>
                                            		</br>
                                            		<tr>
                                            		<td><b>Keterangan </b></td><td><b> : </b></td>

                                            		<td><select class="select form-control" name="keterangan">
                                                    	<option value="0">Pilih keterangan</option>
                                                        <option value="1">Reject transaksi by kasimin (lv1)</option>
														<option value="2">Reject transaksi by akuntansi (lv2)</option>  
														<option value="3">Reject tarik tunai by akuntansi (lv1)</option>
														<option value="4">Reject penyesuaian dropping by bia (lv1)</option>
														<option value="5">Reject penyesuaian dropping by akuntansi (lv2)</option>                                                  
                                                  		</select></td>
                                            		</tr>
                                                </div>
                                                   </table></center>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-ok "></i> Tambah</button>
                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Batal</button>
                                            </div>
                                            	</form><center>
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
			                            <th id="filterable"><center>Alasan</center></th>
			                            <th id="filterable"><center>Keterangan</center></th>
			                            <th><center>Aksi</center></th>
			                          </tr>
			                        </thead>
			                        <tbody>
			                        		<?php $no='1';?>
			                        		@if(count($reject_reasons))
			                        		@foreach($reject_reasons as $reason)
			                        		
			                        		<tr>
			                        			<td><center>{{ $no }}</center></td>
			                        			<td>{{ $reason->content }}</td>
												<td><?php 
														  if($reason->type=='1'){ echo "Reject transaksi by kasimin (lv1)";}
														  if($reason->type=='2'){ echo "Reject transaksi by akuntansi (lv2)";}
														  if($reason->type=='3'){ echo "Reject tarik tunai by akuntansi (lv1)";}
														  if($reason->type=='4'){ echo "Reject penyesuaian dropping by bia (lv1)";}
														  if($reason->type=='5'){ echo "Reject penyesuaian dropping by akuntansi (lv2)";}
													?>
												</td>
												<td><center>
													<span data-toggle='tooltip' title='Ubah'><a class="btn btn-info btn-sm" data-target="#ubah" data-toggle="modal"><i class="fa fa-edit"></i> </a></span>

													<div class="modal fade" data-backdrop="static" id="ubah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        				<div class="modal-dialog">
                                            				<div class="modal-content">
                                                				<div class="modal-header">
                                                    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    				<h4 class="modal-title text-danger" id="myModalLabel" ><i class="glyphicon glyphicon-warning-sign"></i> Peringatan</h4>
                                                				</div>
                                                					<div class="modal-body">
                                                   						<h4>Anda yakin ingin mengubah <span class=text-danger>{{ $reason->content }}</h4>
                                                					</div>
                                                						<div class="modal-footer">
                                                   							<a href="{{ url('item/edit') }}"" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-trash"></i> Ya</a>
                                                    						<button type="button\" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tidak</button>
                                                						</div>
                                            				</div>
                                            			</div>
                                        			</div>

                                        			<span data-toggle='tooltip' title='Hapus'><a class="btn btn-danger btn-sm" data-target="#hapus" data-toggle="modal"><i class="fa fa-trash"></i> </a></span>

													<div class="modal fade" data-backdrop="static" id="hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        				<div class="modal-dialog">
                                            				<div class="modal-content">
                                                				<div class="modal-header">
                                                    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    				<h4 class="modal-title text-info" id="myModalLabel" ><i class="glyphicon glyphicon-warning-sign"></i> Dialog Konfirmasi</h4>
                                                				</div>
                                                					<div class="modal-body">
                                                   						<h4>Anda yakin ingin menghapus alasan <span class=text-danger>{{ $reason->content }}</span> ?</h4>
                                                					</div>
                                                						<div class="modal-footer">
                                                   							<a href="{{ url('item/edit') }}"" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-trash"></i> Ya</a>
                                                    						<button type="button\" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tidak</button>
                                                						</div>
                                            				</div>
                                            			</div>
                                        			</div>

												</center></td>
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