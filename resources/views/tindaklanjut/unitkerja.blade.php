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
                        <h3 class="content-header-title mb-0">Manajemen Tindak Lanjut</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Tindak Lanjut dan Temuan</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="{{ url('/unitkerja') }}">Manajemen Tindak Lanjut</a>
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
			                  
			                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			                  	<div class="card-body collapse in">
			                  	
			                  		<table>
			                  		<form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjut') }}" method="GET" >
				                    {{ csrf_field() }}
			                  			<tr>
			                  				<td><b>Unit Kerja</b></td><td>  </td><td><b> : </b></td><td>  </td>
			                  				<td><select class="select2 form-control block" name="unitkerja" id="unitkerja" onchange="changeUnit()" required="required">
                                                    <option value="0"> - Pilih Unit Kerja - </option>
                                                    <?php
                                                    $second="SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_DIVISI] WHERE VALUE!='00') AS A UNION ALL SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_KPKC]  WHERE VALUE!='00') AS B";
									                $return = DB::select($second);
									                ?>
                                                    @foreach($return as $b)
                                                      <option value="{{ $b->DESCRIPTION }}" >{{ $b->DESCRIPTION }}</option>
                                                    @endforeach
                                                  </select></td>
			                  			</tr>
			                  			<tr>
			                  				<td>  </td>
			                  			</tr>
			                  			<tr>
			                  				<td><b>Tanggal Mulai</b></td><td>  </td><td><b> : </b></td><td>  </td>
			                  				<td><select name="tgl_mulai" class="form-control" style="width:300px" required="required"></select></td>
			                  				<script type="text/javascript">
											    function changeUnit(){
										    		var unitkerja = $('#unitkerja').val();
									                var uri = "{{ url('tindaklanjut/myform').'/'}}"+ encodeURI(unitkerja);

									                $.ajax({
								                        'async': false, 
								                        'type': "GET", 
								                        'dataType': 'JSON', 
								                        'url': uri,
								                        'success': function (data) {

								                          $('select[name="tgl_mulai"]').empty();
											                        $.each(data, function(key, value) {
											                        	var tanggal = new Date(value).getDate();
											                        	var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
											                        	var _bulan = new Date(value).getMonth();
											                        	var bulana = bulan[_bulan];
											                        	var tahun = new Date(value).getFullYear();
											                        	$('select[name="tgl_mulai"]').append('<option value="'+ value +'">'+ tanggal +' '+ bulana +' '+ tahun +'</option>');
											                        	//$('select[name="tgl_mulai"]').append('<option value="'+ value +'">'+ value +'</option>');
											                        });
								                        }
								                    });
										    	}
											</script>
											
			                  			</tr>
			                  			<tr>
			                  				<td>  </td>
			                  			</tr>
			                  			<tr>
			                  				<td>  </td>
			                  			</tr>
			                  			<tr>										 
			                  			<td></td><td></td><td></td><td></td><td><button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search "></i> Cari</button></td>

			                  			</tr>
			                  			</form>
			                  		</table>
			                  	
			                	</div>
			              	</div>
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
			                  <h4 class="card-title">Daftar Unit Kerja</h4></br>
			                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			                  <div class="card-body collapse in">			                
			                  	<div class="card-block">
			                  	<span><a class="btn btn-success" data-target="#tambah" data-toggle="modal"><i class="fa fa-plus"></i> <b>Tambah Tindak Lanjut</b></a></span>
                           			<div class="modal fade" data-backdrop="static" id="tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-plus"></i> Tambah Tindak Lanjut</h4></center>
                                                </div>
                                                <form enctype="multipart/form-data" role="form" action="{{ URL('unitkerja/store_unitkerja') }}" method="POST" >
                                                 {{ csrf_field() }}
                                                <div class="modal-body">
                                                <label class="control-label"><b> Unit Kerja </b></label>
                                                <label class="control-label"><b> : </b></label><br>
												<select class="select2 form-control block" name="unitkerja" style="width:300px">
                                                    <option value="0"> - Pilih Unit Kerja - </option>
                                                    <?php
                                                    $second="SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_DIVISI] WHERE VALUE!='00') AS A UNION ALL SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_KPKC]  WHERE VALUE!='00') AS B";
									                $return = DB::select($second);
									                ?>
                                                    @foreach($return as $b)
                                                      <option value="{{ $b->DESCRIPTION }}" >{{ $b->DESCRIPTION }}</option>
                                                    @endforeach
                                                  </select><br><br>
                                                <label class="control-label"><b> Tanggal Mulai </b></label>
                                                <label class="control-label"><b> : </b></label>
											        <input class="form-control" type="date" name="tgl_mulai" min=<?php echo date('Y-m-d')?> required="required"/>
											        <br>
											    <label class="control-label"><b> Durasi </b></label>
                                                <label class="control-label"><b> : </b></label>
											        <input class="form-control" type="number" min="1" name="durasi" placeholder="masukkan durasi dalam hari" required="required"/>
											        <br>	
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
			                            <th id="filterable"><center>Unit Kerja</center></th>
			                            <th id="filterable"><center>Tanggal Mulai</center></th>
			                            <th id="filterable"><center>Durasi</center></th>
			                            <th id="filterable"><center>Sisa Durasi</center></th>
			                            <th id="filterable"><center>Tanggal Selesai</center></th>
			                            <th><center>Aksi</center></th>
			                          </tr>
			                        </thead>
			                        <tbody>
			                        		{{ $a->links() }}
			                        		<?php $no='1';?>
			                        		@if(count($a))
			                        		@foreach($a as $reason)
			                        		<?php 
			                        			$tanggal = $reason->tgl_mulai;
			                        			$tanggal2 = $reason->tgl_selesai;
												$tanggal3=date('Y-m-d');
												$selisih=((abs(strtotime($tanggal2)-strtotime($tanggal3)))/(60*60*24));
			                        			$durasi=$reason->durasi;
												$tgl= date('d', strtotime($tanggal)); 
												  $b= date('m', strtotime($tanggal));
												  if ($b=="01"){
												    $bulan="Januari";
												  }
												  else if ($b=="02"){
												    $bulan="Februari";
												  }
												  else if ($b=="03"){
												    $bulan="Maret";
												  }
												  else if ($b=="04"){
												    $bulan="April";
												  }
												  else if ($b=="05"){
												    $bulan="Mei";
												  }
												  else if ($b=="06"){
												    $bulan="Juni";
												  }
												  else if ($b=="07"){
												    $bulan="Juli";
												  }
												  else if ($b=="08"){
												    $bulan="Agustus";
												  }
												  else if ($b=="09"){
												    $bulan="September";
												  }
												  else if ($b=="10"){
												    $bulan="Oktober";
												  }
												  else if ($b=="11"){
												    $bulan="November";
												  }
												  else if ($b=="12"){
												    $bulan="Desember";
												  }
												  $tahun= date('Y', strtotime($tanggal));


												  $tgls= date('d', strtotime($tanggal2)); 
												  $bs= date('m', strtotime($tanggal2));
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
												  $tahuns= date('Y', strtotime($tanggal2));
												  ?>
			                        		<tr>
			                        			<td><center>{{ $no }}</center></td>
			                        			<td>{{ $reason->unitkerja }}</td>
			                        			<td><center>{{ $tgl }} {{ $bulan }} {{ $tahun }}</center></td>
			                        			<td align="right">{{ $reason->durasi }} Hari</td>
			                        			<td align="right">@if ($tanggal2>$tanggal3)<p class="info"> {{ $selisih }} Hari </p>@endif
			                        							  @if ($tanggal3>$tanggal2)<p class="danger"> -{{ $selisih }} Hari </p>@endif
			                        							  @if ($selisih=="")<p class="warning"> 0 Hari </p>@endif</td>
			                        			<td><center>{{ $tgls }} {{ $bulans }} {{ $tahuns }}</center></td>
												<td><center>
													<span data-toggle='tooltip' title='Proses'><a href="{{ URL('unitkerja/tindaklanjut/'. $reason->id1) }}" class="btn btn-success btn-sm"><i class="fa fa-share-square-o"></i> </a></span>											
													<span data-toggle='tooltip' title='Ubah'><a class="btn btn-info btn-sm" data-target="#ubah{{$reason->id1}}" data-toggle="modal"><i class="fa fa-edit"></i> </a></span>
                                        			<?php
                                        			$z = DB::table('tl_temuan')
		        										 ->where('id_unitkerja', $reason->id1)
					                        			 ->count();
			                        				?>
			                        				@if (!$z)
	                                        			<span data-toggle='tooltip' title='Hapus'><a class="btn btn-danger btn-sm" data-target="#hapus{{$reason->id1}}" data-toggle="modal"><i class="fa fa-trash"></i> </a></span>
	                                        		@endif
													<div class="modal fade" data-backdrop="static" id="hapus{{$reason->id1}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        				<div class="modal-dialog">
                                            				<div class="modal-content">
                                                				<div class="modal-header">
                                                    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    				<h4 class="modal-title text-warning" id="myModalLabel" ><i class="fa fa-warning"></i> Perhatian !</h4>
                                                				</div>
                                                					<div class="modal-body">
                                                   						<h4>Anda yakin ingin menghapus tindak lanjut <br><span class=text-danger>{{ $reason->unitkerja }}</span> ?</h4>
                                                					</div>
                                                				<div class="modal-footer">
                                                   					<a href="{{ URL('unitkerja/delete_unitkerja/'. $reason->id1) }}"" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Ya</a>
                                                    				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                                				</div>
                                            				</div>
                                            			</div>
                                        			</div>

												</center></td>
								     		</tr>
								     		<div class="modal fade" data-backdrop="static" id="ubah{{$reason->id1}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        				<div class="modal-dialog">
                                            				<div class="modal-content">
                                                				<div class="modal-header">
                                                    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    				<center><h4 class="modal-title text-info" id="myModalLabel" ><i class="fa fa-edit"></i> Ubah Tindak Lanjut</h4></center>
                                                				</div>
                                                					<div class="modal-body">
                                                						<form enctype="multipart/form-data" role="form" action="{{ URL('unitkerja/update_unitkerja/'. $reason->id1) }}" method="POST" >
                                                 						{{ csrf_field() }}
                                                 						<input type="hidden" name="id" value="{{$reason->id1}}" />
                                                 						<br>
                                                						<label class="control-label"><b> Unit Kerja </b></label>
						                                                <label class="control-label"><b> : </b></label>
																		<select class="form-control" name="unitkerja" value="{{$reason->unitkerja}}">
						                                                    <option value=""> - Pilih Unit Kerja - </option>
						                                                    <?php
						                                                    $secondq="SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_DIVISI] WHERE VALUE!='00') AS A UNION ALL SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_KPKC]  WHERE VALUE!='00') AS B";
															                $returnq = DB::select($secondq);
															                ?>
																			@foreach($returnq as $bq)
						                                                    <option value="{{ $bq->DESCRIPTION }}"
								                                            @if($bq->DESCRIPTION == $reason->unitkerja) Selected>{{ $bq->DESCRIPTION}} @endif
								                                            @if($bq->DESCRIPTION <> $reason->unitkerja)>{{ $bq->DESCRIPTION}} @endif
								                                            </option> 
								                                            @endforeach
						                                                </select><br>
						                                                <label class="control-label"><b> Tanggal Mulai </b></label>
						                                                <label class="control-label"><b> : </b></label>
																	        <input class="form-control" type="date" name="tgl_mulai" min=<?php echo date('Y-m-d')?> required="required" value="{{$reason->tgl_mulai}}"/>
																	        <br>
																	    <label class="control-label"><b> Durasi </b></label>
						                                                <label class="control-label"><b> : </b></label>
																	        <input class="form-control" type="number" min="1" name="durasi" placeholder="masukkan durasi dalam hari" required="required" value="{{$reason->durasi}}"/>
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