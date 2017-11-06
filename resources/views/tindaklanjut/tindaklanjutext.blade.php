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
                        <h3 class="content-header-title mb-0">Laporan Tindak Lanjut Pengawasan Eksternal</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active"><a href="{{ url('/tindaklanjutex') }}">Manajemen Tindak Lanjut Eksternal</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="#">Laporan Tindak Lanjut Pengawasan Eksternal</a>
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
            						<h4 class="card-title">Pencarian Tindak Lanjut</h4>
            						<a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
            					</div>
            					<div class="card-body collapse in">
            						<div class="card-block">
            							<form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjutex/tindaklanjuteksternal') }}" method="GET" >
				                    		<div class="row">
            								{{ csrf_field() }}
            									<div class="col-xs-4">
            										<div class="form-group">
            										<label>Unit Kerja</label><br>
            										<select class="select2 form-control block" name="unitkerja" id="unitkerja" style="width:300px" onchange="changeUnit()" required="required">
                                                    <option value="0"> - Pilih Unit Kerja - </option>
                                                    <?php
                                                    $second="SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_DIVISI] WHERE VALUE!='00') AS A UNION ALL SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_KPKC]  WHERE VALUE!='00') AS B";
									                $return = DB::select($second);
									                ?>
                                                    @foreach($return as $b)
                                                      <option value="{{ $b->DESCRIPTION }}" >{{ $b->DESCRIPTION }}</option>
                                                    @endforeach
                                                  </select>
            										</div>
            									</div>
            									<div class="col-xs-3.5">
            										<div class="form-grpup">
            											<label>Tanggal Mulai</label><br>
            											<select class="select2 form-control block" name="tgl_mulai" style="width:200px" required="required"></select>
            										</div>
            									</div>
            								</div>
            								<div class="row">
            									<div class="col-xs-7">
            										<button type="submit" class="btn btn-outline-primary"><i class="fa fa-search "></i> Cari</button>
            									</div>
            								</div>
            							</form>
            						</div>
            					</div>
            				</div>
            				<script type="text/javascript">
											    function changeUnit(){
										    		var unitkerja = $('#unitkerja').val();
									                var uri = "{{ url('tindaklanjutex/myform').'/'}}"+ encodeURI(unitkerja);

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
            			</div>
            		</div>
            	</div>
                
                @if(count($a))
				@foreach($a as $bb)
				<?php 							
											    $dmy=$bb->tgl_input;
											    $tgl= date('d', strtotime($dmy)); 
												  $c= date('m', strtotime($dmy));
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
												  $tahun= date('Y', strtotime($dmy));

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
			                  	<label class="control-label"><b> Tanggal Input: </b><input class="form-control"  disabled="disabled" value="{{ $tgl }} {{ $bulan }} {{ $tahun }}" /></label>
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
						        $ab5= DB::table('tl_temuan')
						        	 ->join('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
						        	 ->join('tl_tindaklanjut', 'tl_rekomendasi.id3','=','tl_tindaklanjut.id_rekomendasi')
						        	 ->where('id_unitkerja', $id1)
						        	 ->count();
						        	 
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
			                      	@if ($ab5)	
										<td><span><a href="{{ URL('tindaklanjut/export/'. $bb->id1.'/excel') }}" class="btn btn-success pull-right" target="_blank"><i class="fa fa-file-excel-o"></i> <b> Export to Excel </b></a></span></td><td> </td><td> </td>
										<td><span><a href="{{ URL('tindaklanjut/export/'. $bb->id1.'/pdf') }}" class="btn btn-success pull-right" target="_blank"><i class="fa fa-file-pdf-o"></i> <b> Export to PDF </b></a></span></td><td> </td><td> </td>
										<td><span><a href="{{ URL('tindaklanjut/print/'. $bb->id1) }}" class="btn btn-success pull-right" target="_blank"><i class="fa fa-print"></i> <b> Print </b></a></span></td>
			                		@endif
			                		
			                		</tr>
			                	</table>
			                	
			                </div>
			                @endif
							<div class="card-body collapse in">			                
			                  <div class="card-block">
		                  		@if(session('success'))
				                  	<div class="alert alert-success">
				                  		{!! session('success') !!}
				                	</div>
				                @endif
				                
			                    <div class="table-responsive">
			                      <table class="table table-striped table-bordered datatable-select-inputs mb-0">
			                        <thead>
			                          <tr>
			                            <th id="filterable"><center>No</center></th>
			                            <th id="filterable"><center>Unit Kerja</center></th>
			                            <th id="filterable"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Temuan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
			                            <th id="filterable"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rekomendasi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
			                            <th id="filterable"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tindak Lanjut&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
			                            <th id="filterable"><center>Berkas Tindak Lanjut</center></th>
			                            <th id="filterable"><center>Status</center></th>
			                            <th id="filterable"><center>Keterangan</center></th>
			                            <th><center>Aksi Tindak Lanjut</center></th>
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
			                        			<center><span><a class="btn btn-success btn-sm" data-target="#tambahtemuan{{$b->id1}}" data-toggle="modal"><i class="fa fa-plus"></i> <b>Tambah Temuan</b></a></span></center>
			                        				
				                           		@else
				                           			@if ($longkap2 != $b->temuan) 
				                           				{{ $b->temuan }}<br>
				                           				<span data-toggle='tooltip' title='Tambah Temuan'><a class="btn btn-success btn-sm" data-target="#tambahtemuan{{$b->id2}}" data-toggle="modal"><i class="fa fa-plus"></i> </a></span>
				                           				<span data-toggle='tooltip' title='Ubah Temuan'><a class="btn btn-info btn-sm" data-target="#ubahtemuan{{$b->id2}}" data-toggle="modal"><i class="fa fa-edit"></i> </a></span>
                                        				@if ($b->rekomendasi=="")
                                        				<span data-toggle='tooltip' title='Hapus Temuan'><a class="btn btn-danger btn-sm" data-target="#hapustemuan{{$b->id2}}" data-toggle="modal"><i class="fa fa-trash"></i> </a></span>
				                           				@endif
				                           			@endif
				                           		@endif
				                           		</td>
			                        			<td>
			                        			@if ($b->temuan!="")
			                        				@if ($b->rekomendasi=="")
				                        			<center><span><a class="btn btn-success btn-sm" data-target="#tambahrekomendasi{{$b->id2}}" data-toggle="modal"><i class="fa fa-plus"></i> <b>Tambah Rekomendasi</b></a></span></center>
				                        			
					                           		@else
						                           		@if ($longkap3 != $b->rekomendasi) 
					                           			{{ $b->rekomendasi }}<br>
					                           			<span data-toggle='tooltip' title='Tambah Rekomendasi'><a class="btn btn-success btn-sm" data-target="#tambahrekomendasi{{$b->id3}}" data-toggle="modal"><i class="fa fa-plus"></i> </a></span>
					                           			<span data-toggle='tooltip' title='Ubah Rekomendasi'><a class="btn btn-info btn-sm" data-target="#ubahrekomendasi{{$b->id3}}" data-toggle="modal"><i class="fa fa-edit"></i> </a></span>
	                                        				@if ($b->tindaklanjut=="")
	                                        				<span data-toggle='tooltip' title='Hapus Rekomendasi'><a class="btn btn-danger btn-sm" data-target="#hapusrekomendasi{{$b->id3}}" data-toggle="modal"><i class="fa fa-trash"></i> </a></span>
					                           				@endif
					                           			@endif
					                           		@endif
				                           		@endif
				                           		</td>
			                        			<td>
			                        			@if ($b->rekomendasi!="")
			                        				@if ($b->tindaklanjut=="")
				                        			<center><span><a class="btn btn-success btn-sm" data-target="#tambahtindaklanjut{{$b->id3}}" data-toggle="modal"><i class="fa fa-plus"></i> <b>Tambah Tindak Lanjut</b></a></span></center>
				                        			@else
					                           		{{ $b->tindaklanjut }}<br>
					                           		<span data-toggle='tooltip' title='Tambah Tindak Lanjut'><a class="btn btn-success btn-sm" data-target="#tambahtindaklanjut{{$b->id4}}" data-toggle="modal"><i class="fa fa-plus"></i> </a></span>
					                           		@endif
				                           		@endif
				                           		</td>
				                           		<td><center>
				                           			@if ($b->tindaklanjut!="")
				                           				@if ($b->name=="") Tidak Ada
				                           				@else 
				                           					{{ $b->name }}<br>
				                           					<a href="{{ URL('tindaklanjut/download/'. $b->id4) }}" target="_blank">{{ $b->name }}</a>
				                           				@endif
				                           			@endif</center></td>
			                        			<td><center>
			                        				@if ($b->status=='1') <div class="tag tag-warning label-square"><span>Dalam Proses</span></div> @endif
			                        				@if ($b->status=='2') <div class="tag tag-primary label-square"><span>Selesai</span></div> @endif</center></td>
			                        			<td>{{ $b->keterangan }}</td>
			                        			<td><center>
			                        			@if ($b->tindaklanjut!="")											
													<span data-toggle='tooltip' title='Ubah Tindak Lanjut'><a class="btn btn-info btn-sm" data-target="#ubahtindaklanjut{{$b->id4}}" data-toggle="modal"><i class="fa fa-edit"></i></a></span>
                                        			<span data-toggle='tooltip' title='Hapus Tindak Lanjut'><a class="btn btn-danger btn-sm" data-target="#hapustindaklanjut{{$b->id4}}" data-toggle="modal"><i class="fa fa-trash"></i></a></span>
                                        		@endif</center></td>
			                        			</tr>
			                        				<div class="modal fade" data-backdrop="static" id="tambahtemuan{{$b->id1}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				                                        <div class="modal-dialog">
				                                            <div class="modal-content">
				                                                <div class="modal-header">
				                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
				                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-plus"></i> Tambah Temuan</h4></center>
				                                                </div>
				                                                <form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjut/store_temuan') }}" method="POST" >
				                                                 {{ csrf_field() }}
				                                                <div class="modal-body">
				                                                <input type="hidden" name="id1" value="{{$b->id1}}" />
				                                                <label class="control-label"><b> Temuan </b></label>
				                                                <label class="control-label"><b> : </b></label>
				                                                	<textarea class="form-control" name="temuan" rows="3" required="required" placeholder="masukkan temuan"></textarea>
															    </div>
				                                            	<div class="modal-footer">
				                                                <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Tambah</button>
				                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
				                                            	</div>
				                                            	</form>
				                							</div>
				                						</div>
				                					</div>
			                        				<div class="modal fade" data-backdrop="static" id="tambahtemuan{{$b->id2}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				                                        <div class="modal-dialog">
				                                            <div class="modal-content">
				                                                <div class="modal-header">
				                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
				                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-plus"></i> Tambah Temuan</h4></center>
				                                                </div>
				                                                <form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjut/store_temuan') }}" method="POST" >
				                                                 {{ csrf_field() }}
				                                                <div class="modal-body">
				                                                <input type="hidden" name="id1" value="{{$b->id1}}" />
				                                                <label class="control-label"><b> Temuan </b></label>
				                                                <label class="control-label"><b> : </b></label>
				                                                	<textarea class="form-control" name="temuan" rows="3" required="required" placeholder="masukkan temuan"></textarea>
															    </div>
				                                            	<div class="modal-footer">
				                                                <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Tambah</button>
				                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
				                                            	</div>
				                                            	</form>
				                							</div>
				                						</div>
				                					</div>
				                					<div class="modal fade" data-backdrop="static" id="tambahrekomendasi{{$b->id2}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				                                        <div class="modal-dialog">
				                                            <div class="modal-content">
				                                                <div class="modal-header">
				                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
				                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-plus"></i> Tambah Rekomendasi</h4></center>
				                                                </div>
				                                                <form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjut/store_rekomendasi') }}" method="POST" >
				                                                 {{ csrf_field() }}
				                                                <div class="modal-body">
				                                                <input type="hidden" name="id2" value="{{$b->id2}}" />
				                                                <label class="control-label"><b> Rekomendasi </b></label>
				                                                <label class="control-label"><b> : </b></label>
															    	<textarea class="form-control" name="rekomendasi" rows="3" required="required" placeholder="masukkan rekomendasi"></textarea>
															    </div>
				                                            	<div class="modal-footer">
				                                                <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Tambah</button>
				                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
				                                            	</div>
				                                            	</form>
				                							</div>
				                						</div>
				                					</div>
				                					<div class="modal fade" data-backdrop="static" id="tambahrekomendasi{{$b->id3}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				                                        <div class="modal-dialog">
				                                            <div class="modal-content">
				                                                <div class="modal-header">
				                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
				                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-plus"></i> Tambah Rekomendasi</h4></center>
				                                                </div>
				                                                <form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjut/store_rekomendasi') }}" method="POST" >
				                                                 {{ csrf_field() }}
				                                                <div class="modal-body">
				                                                <input type="hidden" name="id2" value="{{$b->id2}}" />
				                                                <label class="control-label"><b> Rekomendasi </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <textarea class="form-control" name="rekomendasi" rows="3" required="required" placeholder="masukkan rekomendasi"></textarea>
															    </div>
				                                            	<div class="modal-footer">
				                                                <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Tambah</button>
				                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
				                                            	</div>
				                                            	</form>
				                							</div>
				                						</div>
				                					</div>
				                					<div class="modal fade" data-backdrop="static" id="tambahtindaklanjut{{$b->id3}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				                                        <div class="modal-dialog">
				                                            <div class="modal-content">
				                                                <div class="modal-header">
				                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
				                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-plus"></i> Tambah Tindak Lanjut</h4></center>
				                                                </div>
				                                                <form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjut/store_tindaklanjut') }}" method="POST" >
				                                                 {{ csrf_field() }}
				                                                <div class="modal-body">
				                                                <input type="hidden" name="id3" value="{{$b->id3}}" />
				                                                <label class="control-label"><b> Tindak Lanjut </b></label>
				                                                <label class="control-label"><b> : </b></label>
				                                                	<textarea class="form-control" name="tindaklanjut" rows="3" required="required" placeholder="masukkan tindaklanjut"></textarea>
															    <br>
															    <label class="control-label"><b> Dokumen </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <input class="form-control" type="file" name="inputs"/>
															    <br>    
															    <label class="control-label"><b> Status </b></label>
				                                                <label class="control-label"><b> : </b></label>
				                                                	<select class="select form-control" name="status" required="required" />
								                                    <option value="1">Dalam Proses</option>
																	<option value="2">Selesai</option>                                                  
								                                    </select>
															    <br>
															    <label class="control-label"><b> Keterangan </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <textarea class="form-control" name="keterangan" rows="3" placeholder="masukkan keterangan"></textarea>
															    </div>
				                                            	<div class="modal-footer">
				                                                <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Tambah</button>
				                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
				                                            	</div>
				                                            	</form>
				                							</div>
				                						</div>
				                					</div>
				                					<div class="modal fade" data-backdrop="static" id="tambahtindaklanjut{{$b->id4}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				                                        <div class="modal-dialog">
				                                            <div class="modal-content">
				                                                <div class="modal-header">
				                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
				                                                    <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-plus"></i> Tambah Tindak Lanjut</h4></center>
				                                                </div>
				                                                <form enctype="multipart/form-data" role="form" action="{{ URL('tindaklanjut/store_tindaklanjut') }}" method="POST" >
				                                                 {{ csrf_field() }}
				                                                <div class="modal-body">
				                                                <input type="hidden" name="id3" value="{{$b->id3}}" />
				                                                <label class="control-label"><b> Tindak Lanjut </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <textarea class="form-control" name="tindaklanjut" rows="3" required="required" placeholder="masukkan tindaklanjut"></textarea>
															    <br>
															    <label class="control-label"><b> Dokumen </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <input class="form-control" type="file" name="inputs"/>
															    <br>    
															    <label class="control-label"><b> Status </b></label>
				                                                <label class="control-label"><b> : </b></label>
				                                                	<select class="select form-control" name="status" required="required" />
								                                    <option value="1">Dalam Proses</option>
																	<option value="2">Selesai</option>                                                  
								                                    </select>
															    <br>
															    <label class="control-label"><b> Keterangan </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <textarea class="form-control" name="keterangan" rows="3" placeholder="masukkan keterangan"></textarea>
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
															        <textarea class="form-control" name="temuan" rows="3" required="required" placeholder="masukkan temuan">{{ $b->temuan }}</textarea>
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
															        <textarea class="form-control" name="rekomendasi" rows="3" required="required" placeholder="masukkan rekomendasi">{{ $b->rekomendasi }}</textarea>
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
															        <textarea class="form-control" name="tindaklanjut" rows="3" required="required" placeholder="masukkan tindak lanjut">{{ $b->tindaklanjut }}</textarea>
															    <br>
															    <label class="control-label"><b> Dokumen </b></label>
				                                                <label class="control-label"><b> : </b></label>
															        <input class="form-control" type="file" name="inputs"/>
															        @if ($b->name!="")
															        <p class="help-block">*Kosongkan jika tidak ingin mengganti berkas.</br> Berkas Lama = {{ $b->name }}.</p>
															        @endif
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
															        <textarea class="form-control" name="keterangan" rows="3" placeholder="masukkan keterangan">{{ $b->keterangan }}</textarea>
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
                @endif
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