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
                        <h3 class="content-header-title mb-0">Approval Pengajuan Dropping</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active"><a href="{{ url('/acc_pengajuan_dropping') }}">Approval Pengajuan Dropping</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                
                
				@foreach($a as $bb)
				<?php 							
											    $dmy=$bb->tanggal;
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

												
				?>
				
			    
				<div class="row">
                    <section id="select-inputs">
			          <div class="row">
			            <div class="col-xs-12">
			              <div class="card">
			                <div class="card-header">
			                  <h2 class="card-title">Verifikasi Pengajuan Dropping</h2></br>
			                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			                  <div class="card-body collapse in">			                
			                  	<table>
			                  	<tr><td><b> Kantor Cabang </b></td><td><b> : </b></td><td><input class="form-control" type="text" style="width:400px" value="{{$bb->kantor_cabang}}" disabled="disabled"></td></tr>
			                  	<tr><td></td></tr>
			                  	<tr><td><b> Nomor </b></td><td><b> : </b></td><td><input class="form-control" type="text" style="width:400px" value="{{$bb->nomor}}" disabled="disabled"></td></tr>
			                  	<tr><td></td></tr>
			                  	<tr><td><b> Tanggal </b></td><td><b> : </b></td><td><input class="form-control" type="text" style="width:400px" value="{{$tgl}} {{$bulan}} {{$tahun}}" disabled="disabled"></td></tr>
			                  	<tr><td></td></tr>
			                  	<tr><td><b> Jumlah Diajukan </b></td><td><b> : </b></td><td><input class="form-control" type="text" style="width:400px" value="{{$bb->jumlah_diajukan}}" disabled="disabled"></td></tr>
			                  	<tr><td></td></tr>
			                  	<tr><td><b> Periode Realisasi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><b> : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><input class="form-control" type="text" style="width:400px" value="{{$bb->periode_realisasi}}" disabled="disabled"></td></tr>
			                  	<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
			                  	<tr><td><b> Lampiran </b></td><td><b> : </b></td><td><a href="{{ URL('pengajuan_dropping/download/'. $bb->id) }}" target="_blank">{{ $bb->name }}</a></td></tr>
			                  	<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
			                  	<form enctype="multipart/form-data" role="form" action="{{ URL('acc_pengajuan_dropping/update_accpengajuandropping/'. $bb->id) }}" method="POST" >
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$bb->id}}" />
			                  	<tr><td><b> Verifikasi </b></td><td><b> : </b></td><td><select class="select form-control" name="verifikasi" required="required" value="{{$bb->verifikasi}}" @if ($bb->kirim==3) disabled="disabled" @endif>
													                                   <option value="1" @if ($bb->verifikasi=='1')Selected @endif>Diterima</option>
																					   <option value="2" @if ($bb->verifikasi=='2')Selected @endif>Ditolak</option>                                                 
													                                   </select></td></tr>
			                  	<tr><td></td></tr>
			                  	<tr><td><b> keterangan </b></td><td><b> : </b></td><td><textarea class="form-control" name="keterangan" rows="3" placeholder="masukkan keterangan" @if ($bb->kirim==3) disabled="disabled" @endif>{{ $bb->keterangan }}</textarea></td></tr>
			                  	<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
			                  	<tr><td></td><td></td><td>
			                  	@if ($bb->kirim==2)
									@if ($bb->verifikasi!="")
			                  		<span data-toggle='tooltip' title='Kirim'><a class="btn btn-success" data-target="#kirim{{$bb->id}}" data-toggle="modal"><i class="fa fa-send"></i> Kirim</a></span>
			                  						<div class="modal fade" data-backdrop="static" id="kirim{{$bb->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					                                    <div class="modal-dialog">
					                                        <div class="modal-content">
					                                            <div class="modal-header">
					                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                                                <center><h4 class="modal-title text-primary" id="myModalLabel" ><i class="fa fa-send"></i> Dialog Konfirmasi</h4></center>
					                                            </div>
					                                        	<div class="modal-body">
					                                            	<center><h4>Anda yakin ingin mengirim pengajuan dropping ke {{$bb->kantor_cabang}} ?</h4></center>
					                                        	</div>
					                                        	<div class="modal-footer">
					                                           	 	<a href="{{ URL('acc_pengajuan_dropping/kirim/'. $bb->id) }}"" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Ya</a>
					                                        		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
					                                        	</div>
					                                    	</div>
					                                	</div>
					                                </div>
			                  		@endif
			                  	<button type="submit" name="save" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Verifikasi</button>
			                  	@elseif ($bb->kirim==3)
			                  	<div class="btn btn-success pull-right"><span><b>Telah Dikirim</b></span></div>
			                  	@endif
			                  	</td></tr>
			                  	</form>
			                  	</table>
							  </div>
							
							
							
			                </div>
			              </div>
			            </div>
			          </div>
			        </section>
                  	</div>
                </div>
                @endforeach
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