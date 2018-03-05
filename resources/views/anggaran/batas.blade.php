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
                <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                <script>
                $( function() {
                  $( "#tanggal_mulai" ).datepicker({ dateFormat: 'dd-mm-yy' });
                } );
                </script>
                <script>
                $( function() {
                  $( "#tanggal_selesai" ).datepicker({ dateFormat: 'dd-mm-yy' });
                } );
                </script>
                @endsection

                @section('content')		         

               	<div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Manajemen Batas Pengajuan</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/anggaran')}}">Anggaran dan Kegiatan</a>
                                    </li>
                                    <li class="breadcrumb-item active">Manajemen Batas Pengajuan
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
			                  <h4 class="card-title">Daftar Alasan</h4></br>
			                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			                  <div class="card-body collapse in">			                
			                  	<div class="card-block">
			                  	<span><a class="btn btn-success" data-target="#tambah" data-toggle="modal" style="color:white"><i class="fa fa-plus"></i> <b>Tambah Batas Pengajuan Waktu</b></a></span>
                           			<div class="modal fade" data-backdrop="static" id="tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-plus"></i> Batas Pengajuan Anggaran dan Kegiatan</h4></center>
                                                </div>
                                                <form enctype="multipart/form-data" role="form" action="{{ url('/anggaran/batas/tambah/') }}" method="POST" >
                                                 {{ csrf_field() }}
                                                <div class="modal-body col-md-12">
                                                <div class="col-md-6">
	                                                <label class="control-label"><b> Tanggal Pengajuan Mulai </b></label>
	                                                <label class="control-label"> : </label>
											        <input class="form-control" id="tanggal_mulai" name="tanggal_mulai" required="required" min={{Date("Y-m-d")}}>
										        </div>
										         <div class="col-md-6">
	                                                <label class="control-label"><b> Tanggal Pengajuan Selesai </b></label>
	                                                <label class="control-label"> : </label>
											        <input class="form-control" id="tanggal_selesai" name="tanggal_selesai" required="required" min={{Date("Y-m-d")}}>
										        </div>
										        <div class="col-md-12">
										        	<br>
										        </div>
										        <div class="col-md-12">
	                                            	<label class="control-label"><b> Keterangan </b></label>
	                                            	<label class="control-label"><b> : </b></label>
											        <select class="select2 form-control" name="unit_kerja" required="required" style="width:100%"> 
											        <option value="Semua Unit Kerja">Semua Unit Kerja</option> 

											        @foreach($unit_kerja as $unit)
											        <option value="{{$unit->DESCRIPTION}}">{{$unit->DESCRIPTION}}</option> 
											        @endforeach                                       
				                                    </select>
                                            	</div>
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

				                @if(count($errors->all()) > 0)
		                          <div class="alert alert-danger alert-dismissable">
		                            @foreach ($errors->all() as $error)
		                            {!! $error !!}<br>
		                            @endforeach
		                          </div>
	                          	@endif
				                <name="data" id="data">
			                    <div class="table-responsive">
									<table class="table table-striped table-bordered datatable-select-inputs nowrap" cellspacing="0" width="100%">
										<thead>
										  <tr>
										    <th><center>No</center></th>
										    <th id="filterable"><center>Unit Kerja</center></th>
										    <th hidden><center>Tanggal Mulai</center></th>
										    <th id="filterable"><center>Tanggal Mulai</center></th>
										    <th hidden><center>Tanggal Selesai</center></th>
										    <th id="filterable"><center>Tanggal Selesai</center></th>
										    <th><center>Aktif</center></th>
										    <th><center>Edit Waktu</center></th>
										  </tr>
										</thead>
										<tbody>
												<?php $no='1';?>
												@if(count($batas_anggaran))
												@foreach($batas_anggaran as $batas)
												
												<tr>
													<td><center>{{ $no }}</center></td>
													<td>{{ $batas->unit_kerja }}</td>
													<td hidden id="tanggal_mulai_{{$batas->id}}">{{ $batas->tanggal_mulai }}</td>
													<td><center>{{ date('d-m-Y', strtotime($batas->tanggal_mulai)) }}</center></td>
													<td hidden id="tanggal_selesai_{{$batas->id}}">{{ $batas->tanggal_selesai }}</td>
													<td><center>{{ date('d-m-Y', strtotime($batas->tanggal_selesai)) }}</center></td>
													<td style="color:{{$batas->active?'green':'red'}}"><b><center>{{ $batas->active?"Ya":"Tidak"}}</center></b></td>
													<td><center>
														<input type="hidden" id="active_{{$batas->id}}" value="{{$batas->active}}">
														<span><a class="btn btn-info btn-sm" onclick='modal_ubah("{{$batas->id}}")' style="color:black"><i class="fa fa-edit"></i> </a></span>
													</center></td>
										 		</tr>
												<?php $no++;?>
												@endforeach
												@endif
										</tbody>
									</table>
									<div class="modal fade" data-backdrop="static" id="modal_ubah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									    <div class="modal-dialog">
									        <div class="modal-content">
									            <div class="modal-header">
									                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
									                <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-edit"></i> Batas Pengajuan Anggaran dan Kegiatan</h4></center>
									            </div>
									            <form method="post" action="#" id="form_edit_pengajuan" >
									             {{ csrf_field() }}
									            <div class="modal-body col-md-12">
	                                                <div class="col-md-6" id="mulai">
		                                                <label class="control-label"><b> Tanggal Pengajuan Mulai </b></label>
		                                                <label class="control-label"> : </label>
												        <input class="form-control" name="tanggal_mulai" id="tanggal_mulai_edit" required="required" min={{Date("Y-m-d")}}>
											        </div>
											        <div class="col-md-6">
		                                                <label class="control-label"><b> Tanggal Pengajuan Selesai </b></label>
		                                                <label class="control-label"> : </label>
												        <input class="form-control" name="tanggal_selesai" id="tanggal_selesai_edit" required="required" min={{Date("Y-m-d")}}>
											        </div>
										        </div>
									        	<div class="modal-footer">
									            <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Ubah</button>
									            <div class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
								        		</form>
								        	</div> 	
										</div>
									</div>
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

					function modal_ubah(id){	


						tanggal_mulai = document.getElementById('tanggal_mulai_'+id).innerHTML;
						tanggal_selesai = document.getElementById('tanggal_selesai_'+id).innerHTML;
						active = document.getElementById('active_'+id).value;
						// alert(tanggal_selesai);

						$('#tanggal_mulai_edit').val(tanggal_mulai);
						// document.getElementById('tanggal_mulai_edit').value = tanggal_mulai;
						// if(active == "0")
							// $('#tanggal_mulai_edit').datepicker().datepicker('disable');
						
							
						$('#tanggal_selesai_edit').val(tanggal_selesai);
						$('form[id="form_edit_pengajuan"').attr('action', '{{ url('anggaran/batas/ubah') }}' + '/' + id);
						$('#modal_ubah').modal({
	                    	backdrop: 'static'
	                      })     
						
					}

					$('.datatable-select-inputs').DataTable( {
							scrollX: true,
							"language": {
								"paginate": {
								  "previous": "Sebelumnya",
								  "next": "Selanjutnya"
								},

    							"emptyTable":  "Tidak Ada Batasan Pengajuan Menolak Tersimpan",
    							"info":  "Data Batasan Pengajuan _START_-_END_ dari _TOTAL_ Alasan",
    							"infoEmpty":  "Data Batasan Pengajuan 0-0 dari _TOTAL_ Alasan ",
    							"search": "Pencarian:",
    							"lengthMenu": "Perlihatkan _MENU_ masukan",
    							"infoFiltered": "(telah di filter dari _MAX_ total masukan)",
    							"zeroRecords": "Tidak ada data ditemukan"
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

				</script>
                @endsection