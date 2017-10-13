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
                        <h3 class="content-header-title mb-0">Pengajuan Dropping Kantor Cabang</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Pengajuan Dropping</a>
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
			                  <h4 class="card-title">Daftar Pengajuan Dropping</h4></br>
			                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			                  <div class="card-body collapse in">			                
			                  	
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
			                            <th id="filterable"><center>Kantor Cabang</center></th>
			                            <th id="filterable"><center>Nomor</center></th>
			                            <th id="filterable"><center>Tanggal</center></th>
			                            <th id="filterable"><center>Jumlah Diajukan</center></th>
			                            <th id="filterable"><center>Periode Realisasi</center></th>
			                            <th id="filterable"><center>Lampiran</center></th>
			                            <th id="filterable"><center>Verifikasi</center></th>
			                            <th id="filterable"><center>Keterangan</center></th>
			                            <th><center>Aksi</center></th>
			                          </tr>
			                        </thead>
			                        <tbody>
			                        		<?php $no='1';?>
			                        		@if(count($a))
			                        		@foreach($a as $b)
			                        		<tr>
			                        			<td><center>{{ $no }}</center></td>
			                        			<td>{{ $b->kantor_cabang }}</td>
												<td><center>{{ $b->nomor }}</center></td>
												<?php
												$tanggal=$b->tanggal;								  
												$tgl= date('d', strtotime($tanggal)); 
												  $bs= date('m', strtotime($tanggal));
												  if ($bs=="01"){
												    $bulans="Januari";
												  }
												  else if ($bs=="02"){
												    $bulans="Februari";
												  }
												  else if ($bs=="03"){
												    $bulans="Maret";
												  }
												  else if ($bs=="04"){
												    $bulans="April";
												  }
												  else if ($bs=="05"){
												    $bulans="Mei";
												  }
												  else if ($bs=="06"){
												    $bulans="Juni";
												  }
												  else if ($bs=="07"){
												    $bulans="Juli";
												  }
												  else if ($bs=="08"){
												    $bulans="Agustus";
												  }
												  else if ($bs=="09"){
												    $bulans="September";
												  }
												  else if ($bs=="10"){
												    $bulans="Oktober";
												  }
												  else if ($bs=="11"){
												    $bulans="November";
												  }
												  else if ($bs=="12"){
												    $bulans="Desember";
												  }
												  $tahun= date('Y', strtotime($tanggal));
												  $angka = number_format($b->jumlah_diajukan,0,"",".");
												  ?>
												<td><center>{{ $tgl }} {{ $bulans }} {{ $tahun }}</center></td>
												<td><center>Rp {{ $angka }},-</center></td>
												<td><center><?php 
														  if($b->periode_realisasi=='1'){ echo "TW I";}
														  if($b->periode_realisasi=='2'){ echo "TW II";}
														  if($b->periode_realisasi=='3'){ echo "TW III";}
														  if($b->periode_realisasi=='4'){ echo "TW IV";}
													?></center></td>
												<td><center>
				                           			@if ($b->name=="") Tidak Ada
				                           			@else 
				                           			<a href="{{ URL('pengajuan_dropping/download/'. $b->id) }}" target="_blank">{{ $b->name }}</a>
				                           			@endif
				                           		</center></td>
												<td><center><?php 
														  if($b->verifikasi=='1'){ echo "<div class=\"tag tag-success label-square\"><span><b>Diterima</b></span></div>";}
														  if($b->verifikasi=='2'){ echo "<div class=\"tag tag-danger label-square\"><span><b>Ditolak</b></span></div>";}
													?></center></td>
												<td><center>{{ $b->keterangan }}</center></td>
												<td><center>
												@if ($b->kirim==2)
												  @if ($b->verifikasi!="")
													<span data-toggle='tooltip' title='Kirim'><a class="btn btn-success btn-sm" data-target="#kirim{{$b->id}}" data-toggle="modal"><i class="fa fa-send"></i> </a></span>
												  @endif
												  	<span data-toggle='tooltip' title='Print'><a href="{{ URL('pengajuan_dropping/print/'. $b->id) }}" target="_blank" class="btn btn-warning btn-sm" ><i class="fa fa-print"></i> </a></span>
													<span data-toggle='tooltip' title='Verifikasi'><a class="btn btn-info btn-sm" data-target="#ubah{{$b->id}}" data-toggle="modal"><i class="fa fa-check"></i> </a></span>
												@else
													<div class="btn btn-success btn-sm"><span><b>Telah Dikirim</b></span></div>
												@endif		
													<div class="modal fade" data-backdrop="static" id="kirim{{$b->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					                                    <div class="modal-dialog">
					                                        <div class="modal-content">
					                                            <div class="modal-header">
					                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                                                <center><h4 class="modal-title text-primary" id="myModalLabel" ><i class="fa fa-send"></i> Dialog Konfirmasi</h4></center>
					                                            </div>
					                                        	<div class="modal-body">
					                                            	<center><h4>Anda yakin ingin mengirim pengajuan dropping<br>ke {{$b->kantor_cabang}} ?</h4></center>
					                                        	</div>
					                                        	<div class="modal-footer">
					                                           	 	<a href="{{ URL('acc_pengajuan_dropping/kirim/'. $b->id) }}"" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Ya</a>
					                                        		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
					                                        	</div>
					                                    	</div>
					                                	</div>
					                                </div>
												</center></td>
								     		</tr>
								     				<div class="modal fade" data-backdrop="static" id="ubah{{$b->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        				<div class="modal-dialog">
                                            				<div class="modal-content">
                                                				<div class="modal-header">
                                                    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    				<center><h4 class="modal-title text-info" id="myModalLabel" ><i class="fa fa-check"></i> Verifikasi Pengajuan Dropping</h4></center>
                                                				</div>
                                                					<div class="modal-body">
                                                					<form enctype="multipart/form-data" role="form" action="{{ URL('acc_pengajuan_dropping/update_accpengajuandropping/'. $b->id) }}" method="POST" >
                                                 						{{ csrf_field() }}
                                                 						<input type="hidden" name="id" value="{{$b->id}}" />
                                                 						
																	    <label class="control-label"><b> Verifikasi </b></label>
						                                                <label class="control-label"> : </label>
																	        <select class="select form-control" name="verifikasi" required="required" value="{{$b->verifikasi}}" >
										                                    
										                                    <option value="1" @if ($b->verifikasi=='1')Selected @endif>Diterima</option>
																			<option value="2" @if ($b->verifikasi=='2')Selected @endif>Ditolak</option>                                                 
										                                    </select>   
																		<br>
																	    <label class="control-label"><b> Keterangan </b></label>
						                                                <label class="control-label"><b> : </b></label>
																	        <textarea class="form-control" name="keterangan" rows="3" placeholder="masukkan keterangan">{{ $b->keterangan }}</textarea>
																	        
						                                            </div>
                                                					<div class="modal-footer">
                                                						<button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Verifikasi</button>
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
							"language": {
								"paginate": {
								  "previous": "Sebelumnya",
								  "next": "Selanjutnya"
								},

    							"emptyTable":  "Tidak Ada Data Tersimpan",
    							"info":  "Menampilkan _START_-_END_ dari _TOTAL_ Data",
    							"infoEmpty":  "Menampilkan 0-0 dari _TOTAL_ Data ",
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