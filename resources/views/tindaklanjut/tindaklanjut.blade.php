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
                    <div class="content-header-left col-md-12 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Laporan Tindak Lanjut Pengawasan Internal</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active"><a href="{{ url('/unitkerja') }}">Manajemen Tindak Lanjut</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="#">Laporan Tindak Lanjut Pengawasan Internal</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                @if(count($a))
				@foreach($a as $bb)
				<?php 							
											    
											    $tgl= date('d', strtotime(date('d-m-Y'))); 
												  $c= date('m', strtotime(date('d-m-Y')));
												  if ($c=="01"){
												    $bulan="Januari";
												  }
												  else if ($c=="02"){
												    $bulan="Februari";
												  }
												  else if ($c=="03"){
												    $bulan="Maret";
												  }
												  else if ($c=="04"){
												    $bulan="April";
												  }
												  else if ($c=="05"){
												    $bulan="Mei";
												  }
												  else if ($c=="06"){
												    $bulan="Juni";
												  }
												  else if ($c=="07"){
												    $bulan="Juli";
												  }
												  else if ($c=="08"){
												    $bulan="Agustus";
												  }
												  else if ($c=="09"){
												    $bulan="September";
												  }
												  else if ($c=="10"){
												    $bulan="Oktober";
												  }
												  else if ($c=="11"){
												    $bulan="November";
												  }
												  else if ($c=="12"){
												    $bulan="Desember";
												  }
												  $tahun= date('Y', strtotime(date('d-m-Y')));

												$tanggal2=$bb->tgl_mulai;								  
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
				@endforeach
			    @endif
				<div class="row">
                    <section id="select-inputs">
			          <div class="row">
			            <div class="col-xs-12">
			              <div class="card">
			                <div class="card-header">
			                  <h4 class="card-title">Tindak Lanjut Unit Kerja : {{ $bb->unitkerja}}</h4></br>
			                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			                  <div class="card-body collapse in">			                
			                  	<div class="col-xs-4">
			                  	<label class="control-label"><b> Tanggal : </b><input class="form-control"  disabled="disabled" value="{{ $tgl }} {{ $bulan }} {{ $tahun }}" /></label>
                                </div>
                                <div class="col-xs-3">
			                  	</div>
                                <div class="col-xs-2 pull-right">
			                  	<label class="control-label"><b> Durasi : </b><input class="form-control" disabled="disabled" value="{{ $bb->durasi }} Hari"/></label>
                                </div>
                                <div class="col-xs-2.5 pull-right">
                                <label class="control-label"><b> Tanggal Mulai : </b><input class="form-control"  disabled="disabled" value="{{ $tgls }} {{ $bulans }} {{ $tahuns }}"/></label>
                               	</div>
							  </div>
							<div class="col-xs-12">
								<div class="col-xs-8">
			                  	</div>
                                <div class="col-xs-3.5">
                                <table align="right">
                                <?php 
                                $id1=$bb->id1;
                                $ab1= DB::table('tl_temuan')
						        	 ->where('id_unitkerja', $id1)
						        	 ->count();
						        $ab2= DB::table('tl_temuan')
						        	 ->join('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
						        	 ->where('id_unitkerja', $id1)
						        	 ->count();
						        $ab3= DB::table('tl_temuan')
						        	 ->join('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
						        	 ->join('tl_tindaklanjut', 'tl_rekomendasi.id3','=','tl_tindaklanjut.id_rekomendasi')
						        	 ->where('id_unitkerja', $id1)
						        	 ->where('status', '1')
						        	 ->count();
						        $ab4= DB::table('tl_temuan')
						        	 ->join('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
						        	 ->join('tl_tindaklanjut', 'tl_rekomendasi.id3','=','tl_tindaklanjut.id_rekomendasi')
						        	 ->where('id_unitkerja', $id1)
						        	 ->where('status', '2')
						        	 ->count();
						        	 if ($ab4==""){
						        	 	$ab4="0";
						        	 }
                                ?>
                                	<tr>
                                		<td align="right"><b>Total Temuan</td></b><td><b> : </b></td><td><b>{{$ab1}}</b></td>
                                	</tr>
                                	<tr>
                                		<td align="right"><b>Total Rekomendasi</td></b><td><b> : </b></td><td><b>{{$ab2}}</b></td>
                                	</tr>
                                	<tr>
                                		<td align="right"><b>Dalam Proses</td></b><td><b> : </b></td><td><b>{{$ab3}}</b></td>
                                	</tr>
                                	<tr>
                                		<td align="right"><b>Selesai</td></b><td><b> : </b></td><td><b>{{$ab4}}</b></td>
                                	</tr>
                                </table>
			                  	</div>	
							<br>
							<br>
							</div>
							<div class="col-xs-12">
								<table align="right">
									<tr>
										<td><span><a href="{{ URL('tindaklanjut/export/'. $bb->id1) }}" class="btn btn-success pull-right" target="_blank"><i class="fa fa-file-excel-o"></i> <b> Export to Excel </b></a></span></td><td> </td>
										<td><span><a href="{{ URL('tindaklanjut/print/'. $bb->id1) }}" class="btn btn-success pull-right" target="_blank"><i class="fa fa-print"></i> <b> Print </b></a></span></td>
			                		</tr>
			                	</table>
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
			                            <th class="bg-success bg-lighten-2" id="filterable"><center>No</center></th>
			                            <th class="bg-success bg-lighten-2" id="filterable"><center>Unit Kerja</center></th>
			                            <th class="bg-danger bg-lighten-2" id="filterable"><center>Temuan</center></th>
			                            <th class="bg-warning bg-lighten-2" id="filterable"><center>Rekomendasi</center></th>
			                            <th class="bg-info bg-lighten-2" id="filterable"><center>Tindak Lanjut</center></th>
			                            <th class="bg-info bg-lighten-2" id="filterable"><center>Berkas</center></th>
			                            <th class="bg-info bg-lighten-2" id="filterable"><center>Status</center></th>
			                            <th class="bg-info bg-lighten-2" id="filterable"><center>Keterangan</center></th>
			                            <th class="bg-info bg-lighten-2"><center>Aksi</center></th>
			                          </tr>
			                        </thead>
			                        <tbody>
			                        <?php $no='1';
			                        $longkap="longkap";
			                        $longkap2="longkap";
			                        $longkap3="longkap";?>
					                @if(count($a))
								    @foreach($a as $b)
								    
			                        		<tr>
			                        			<td><center>
			                        			@if ($longkap != $b->unitkerja)
												{{$no}}
												@endif
			                        			</center></td>
			                        			
			                        			<td>
			                        			@if ($longkap != $b->unitkerja) 
			                        			{{ $b->unitkerja }}
			                        			@endif
			                        			</td>
			                        			<td>
			                        			@if ($b->temuan=="")
			                        			<span><a class="btn btn-success btn-sm" data-target="#tambahtemuan" data-toggle="modal"><i class="fa fa-plus"></i> <b>Tambah Temuan</b></a></span>
				                           		@else
				                           			@if ($longkap2 != $b->temuan) 
				                           			<span><a data-target="#tambahtemuan" data-toggle="modal"> {{ $b->temuan }}</a></span>
				                           			<span data-toggle='tooltip' title='Ubah'><a class="btn btn-info btn-sm" data-target="#ubahtemuan{{$b->id2}}" data-toggle="modal"><i class="fa fa-edit"></i> </a></span>
                                        				@if ($b->rekomendasi=="")
                                        				<span data-toggle='tooltip' title='Hapus'><a class="btn btn-danger btn-sm" data-target="#hapustemuan{{$b->id2}}" data-toggle="modal"><i class="fa fa-trash"></i> </a></span>
				                           				@endif
				                           			@endif
				                           		@endif
				                           		</td>
			                        			<td>
			                        			@if ($b->temuan!="")
			                        				@if ($b->rekomendasi=="")
				                        			<span><a class="btn btn-success btn-sm" data-target="#tambahrekomendasi" data-toggle="modal"><i class="fa fa-plus"></i> <b>Tambah Rekomendasi</b></a></span>
					                           		@else
						                           		@if ($longkap3 != $b->rekomendasi) 
					                           			<span><a data-target="#tambahrekomendasi" data-toggle="modal"> {{ $b->rekomendasi }}</a></span>
					                           			<span data-toggle='tooltip' title='Ubah'><a class="btn btn-info btn-sm" data-target="#ubahrekomendasi{{$b->id3}}" data-toggle="modal"><i class="fa fa-edit"></i> </a></span>
	                                        				@if ($b->tindaklanjut=="")
	                                        				<span data-toggle='tooltip' title='Hapus'><a class="btn btn-danger btn-sm" data-target="#hapusrekomendasi{{$b->id3}}" data-toggle="modal"><i class="fa fa-trash"></i> </a></span>
					                           				@endif
					                           			@endif
					                           		@endif
				                           		@endif
				                           		</td>
			                        			<td>
			                        			@if ($b->rekomendasi!="")
			                        				@if ($b->tindaklanjut=="")
				                        			<span><a class="btn btn-success btn-sm" data-target="#tambahtindaklanjut" data-toggle="modal"><i class="fa fa-plus"></i> <b>Tambah Tindak Lanjut</b></a></span>
					                           		@else
					                           		<span><a data-target="#tambahtindaklanjut" data-toggle="modal"> {{ $b->tindaklanjut }}</a></span>
					                           		@endif
				                           		@endif
				                           		</td>
				                           		<td><center>@if ($b->tindaklanjut!="")
				                           				@if ($b->name=="") Tidak Ada
				                           				@else 
				                           					<a href="{{ URL('tindaklanjut/download/'. $b->id4) }}">{{ $b->name }}</a>
				                           				@endif
				                           			@endif</center></td>
			                        			<td><center>@if ($b->status=='1') <div class="tag tag-warning label-square"><span>Dalam Proses</span></div> @endif
			                        				@if ($b->status=='2') <div class="tag tag-primary label-square"><span>Selesai</span></div> @endif</center></td>
			                        			<td>{{ $b->keterangan }}</td>
			                        			<td><center>@if ($b->tindaklanjut!="")											
													<span data-toggle='tooltip' title='Ubah'><a class="btn btn-info btn-sm" data-target="#ubahtindaklanjut{{$b->id4}}" data-toggle="modal"><i class="fa fa-edit"></i> </a></span>
                                        			<span data-toggle='tooltip' title='Hapus'><a class="btn btn-danger btn-sm" data-target="#hapustindaklanjut{{$b->id4}}" data-toggle="modal"><i class="fa fa-trash"></i> </a></span>
                                        		@endif</center></td>
			                        			</tr>
			                        				<div class="modal fade" data-backdrop="static" id="tambahtemuan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				                                        <div class="modal-dialog">
				                                            <div class="modal-content">
				                                                <div class="modal-header">
				                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
				                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-plus"></i> Tambah Temuan</h4></center>
				                                                </div>
				                                                <form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjut/store_temuan/'. $b->id1) }}" method="POST" >
				                                                 {{ csrf_field() }}
				                                                <div class="modal-body">
				                                                <label class="control-label"><b> Temuan </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <input class="form-control" type="text" name="temuan" required="required" placeholder="masukkan temuan" />
															    </div>
				                                            	<div class="modal-footer">
				                                                <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Tambah</button>
				                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
				                                            	</div>
				                                            	</form>
				                							</div>
				                						</div>
				                					</div>
				                					<div class="modal fade" data-backdrop="static" id="tambahrekomendasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				                                        <div class="modal-dialog">
				                                            <div class="modal-content">
				                                                <div class="modal-header">
				                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
				                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-plus"></i> Tambah Rekomendasi</h4></center>
				                                                </div>
				                                                <form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjut/store_rekomendasi/'. $b->id2) }}" method="POST" >
				                                                 {{ csrf_field() }}
				                                                <div class="modal-body">
				                                                <label class="control-label"><b> Rekomendasi </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <input class="form-control" type="text" name="rekomendasi" required="required" placeholder="masukkan rekomendasi"/>
															    </div>
				                                            	<div class="modal-footer">
				                                                <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Tambah</button>
				                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
				                                            	</div>
				                                            	</form>
				                							</div>
				                						</div>
				                					</div>
				                					<div class="modal fade" data-backdrop="static" id="tambahtindaklanjut" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				                                        <div class="modal-dialog">
				                                            <div class="modal-content">
				                                                <div class="modal-header">
				                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
				                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-plus"></i> Tambah Tindak Lanjut</h4></center>
				                                                </div>
				                                                <form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjut/store_tindaklanjut/'. $b->id3) }}" method="POST" >
				                                                 {{ csrf_field() }}
				                                                <div class="modal-body">
				                                                <label class="control-label"><b> Tindak Lanjut </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <input class="form-control" type="text" name="tindaklanjut" required="required" placeholder="masukkan tindak lanjut"/>
															    <br>
															    <label class="control-label"><b> Dokumen </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <input class="form-control" type="file" name="inputs"/>
															        <p class="help-block">*Jenis file yang didukung adalah pdf.<br>*Batas ukuran file maksimal adalah 5 MB.</p>
															    
															    <label class="control-label"><b> Status </b></label>
				                                                <label class="control-label"><b> : </b></label>
				                                                	<select class="select form-control" name="status" required="required" />
								                                    <option value="1">Dalam Proses</option>
																	<option value="2">Selesai</option>                                                  
								                                    </select>
															    <br>
															    <label class="control-label"><b> Keterangan </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <input class="form-control" type="text" name="keterangan" required="required" placeholder="masukkan keterangan" />
															    </div>
				                                            	<div class="modal-footer">
				                                                <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Tambah</button>
				                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
				                                            	</div>
				                                            	</form>
				                							</div>
				                						</div>
				                					</div>
				                					<div class="modal fade" data-backdrop="static" id="ubahtemuan{{$b->id2}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				                                        <div class="modal-dialog">
				                                            <div class="modal-content">
				                                                <div class="modal-header">
				                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
				                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-edit"></i> Ubah Temuan</h4></center>
				                                                </div>
				                                                <form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjut/update_temuan/'. $b->id1) }}" method="POST" >
				                                                 {{ csrf_field() }}
				                                                <input type="hidden" name="id2" value="{{$b->id2}}" />
				                                                <div class="modal-body">
				                                                <label class="control-label"><b> Temuan </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <input class="form-control" type="text" name="temuan" required="required" placeholder="masukkan temuan" value="{{ $b->temuan }}" />
															    </div>
				                                            	<div class="modal-footer">
				                                                <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Ubah</button>
				                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
				                                            	</div>
				                                            	</form>
				                							</div>
				                						</div>
				                					</div>
				                					<div class="modal fade" data-backdrop="static" id="ubahrekomendasi{{$b->id3}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				                                        <div class="modal-dialog">
				                                            <div class="modal-content">
				                                                <div class="modal-header">
				                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
				                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-edit"></i> Ubah Rekomendasi</h4></center>
				                                                </div>
				                                                <form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjut/update_rekomendasi/'. $b->id2) }}" method="POST" >
				                                                 {{ csrf_field() }}
				                                                <input type="hidden" name="id3" value="{{$b->id3}}" />
				                                                <div class="modal-body">
				                                                <label class="control-label"><b> Rekomendasi </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <input class="form-control" type="text" name="rekomendasi" required="required" placeholder="masukkan rekomendasi" value="{{ $b->rekomendasi }}" />
															    </div>
				                                            	<div class="modal-footer">
				                                                <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Ubah</button>
				                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
				                                            	</div>
				                                            	</form>
				                							</div>
				                						</div>
				                					</div>
				                					<div class="modal fade" data-backdrop="static" id="ubahtindaklanjut{{$b->id4}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				                                        <div class="modal-dialog">
				                                            <div class="modal-content">
				                                                <div class="modal-header">
				                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
				                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-edit"></i> Ubah Tindak Lanjut</h4></center>
				                                                </div>
				                                                <form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjut/update_tindaklanjut/'. $b->id3) }}" method="POST" >
				                                                 {{ csrf_field() }}
				                                                <input type="hidden" name="id4" value="{{$b->id4}}" />
				                                                <div class="modal-body">
				                                                <label class="control-label"><b> Tindak Lanjut </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <input class="form-control" type="text" name="tindaklanjut" required="required" placeholder="masukkan tindak lanjut" value="{{ $b->tindaklanjut }}" />
															    <br>
															    <label class="control-label"><b> Dokumen </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <input class="form-control" type="file" name="inputs"/>
															        <p class="help-block">*Kosongkan jika tidak ingin mengganti berkas.</p>
															    <br>
															    <label class="control-label"><b> Status </b></label>
				                                                <label class="control-label"><b> : </b></label>
				                                                	<select class="select form-control" name="status" required="required" value="{{ $b->status }}"/>
								                                    <option value="1" @if ($b->status=="1")Selected @endif>Dalam Proses</option>
																	<option value="2" @if ($b->status=="2")Selected @endif>Selesai</option>                                                 
								                                    </select>
															    <br>
															    <label class="control-label"><b> Keterangan </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <input class="form-control" type="text" name="keterangan" required="required" placeholder="masukkan keterangan" value="{{ $b->keterangan }}"/>
															    </div>
				                                            	<div class="modal-footer">
				                                                <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Ubah</button>
				                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
				                                            	</div>
				                                            	</form>
				                							</div>
				                						</div>
				                					</div>
				                					<div class="modal fade" data-backdrop="static" id="hapustemuan{{$b->id2}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        				<div class="modal-dialog">
                                            				<div class="modal-content">
                                                				<div class="modal-header">
                                                    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    				<center><h4 class="modal-title text-warning" id="myModalLabel" ><i class="fa fa-warning"></i> Perhatian !</h4></center>
                                                				</div>
                                                					<div class="modal-body">
                                                   						<center><h4>Anda yakin ingin menghapus temuan <br><span class=text-danger>{{ $b->temuan }}</span> ?</h4></center>
                                                					</div>
                                                				<div class="modal-footer">
                                                   					<a href="{{ URL('tindaklanjut/delete_temuan/'. $b->id2) }}"" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Ya</a>
                                                    				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                                				</div>
                                            				</div>
                                            			</div>
                                        			</div>
                                        			<div class="modal fade" data-backdrop="static" id="hapusrekomendasi{{$b->id3}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        				<div class="modal-dialog">
                                            				<div class="modal-content">
                                                				<div class="modal-header">
                                                    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    				<center><h4 class="modal-title text-warning" id="myModalLabel" ><i class="fa fa-warning"></i> Perhatian !</h4></center>
                                                				</div>
                                                					<div class="modal-body">
                                                   						<center><h4>Anda yakin ingin menghapus rekomendasi <br><span class=text-danger>{{ $b->rekomendasi }}</span> ?</h4></center>
                                                					</div>
                                                				<div class="modal-footer">
                                                   					<a href="{{ URL('tindaklanjut/delete_rekomendasi/'. $b->id3) }}"" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Ya</a>
                                                    				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                                				</div>
                                            				</div>
                                            			</div>
                                        			</div>
				                					<div class="modal fade" data-backdrop="static" id="hapustindaklanjut{{$b->id4}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        				<div class="modal-dialog">
                                            				<div class="modal-content">
                                                				<div class="modal-header">
                                                    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    				<center><h4 class="modal-title text-warning" id="myModalLabel" ><i class="fa fa-warning"></i> Perhatian !</h4></center>
                                                				</div>
                                                					<div class="modal-body">
                                                   						<h4><center>Anda yakin ingin menghapus tindak lanjut <br><span class=text-danger>{{ $b->tindaklanjut }}</span> ?</center></h4>
                                                					</div>
                                                				<div class="modal-footer">
                                                   					<a href="{{ URL('tindaklanjut/delete_tindaklanjut/'. $b->id4) }}"" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Ya</a>
                                                    				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                                				</div>
                                            				</div>
                                            			</div>
                                        			</div>
				                	<?php $longkap = $b->unitkerja;
				                		  $longkap2 = $b->temuan;
				                		  $longkap3 = $b->rekomendasi;
				                		  $no++; ?>
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