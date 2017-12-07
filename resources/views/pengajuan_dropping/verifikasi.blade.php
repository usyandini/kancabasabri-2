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
                        <h3 class="content-header-title mb-0">Approval Pengajuan Dropping Level 1</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active"><a href="{{ url('/acc_pengajuan_dropping') }}">Approval Pengajuan Dropping Level 1 Kakancab</a>
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
												  $angka = number_format($bb->jumlah_diajukan,0,"",".");
												
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
			                  	<tr><td><b> Nomor Nota Dinas </b></td><td><b> : </b></td><td><input class="form-control" type="text" style="width:400px" value="{{$bb->nomor}}" disabled="disabled"></td></tr>
			                  	<tr><td></td></tr>
			                  	<tr><td><b> Tanggal </b></td><td><b> : </b></td><td><input class="form-control" type="text" style="width:400px" value="{{$tgl}} {{$bulan}} {{$tahun}}" disabled="disabled"></td></tr>
			                  	<tr><td></td></tr>
			                  	<tr><td><b> Jumlah Diajukan </b></td><td><b> : </b></td><td><input class="form-control" type="text" style="width:400px" value="Rp. {{$angka}}" disabled="disabled"></td></tr>
			                  	<tr><td></td></tr><tr><td></td></tr>
			                  	<tr><td><b> Terbilang </b></td><td><b> : </b></td><td>
			                  	<?php
    function terbilang($angka) {
	    // pastikan kita hanya berususan dengan tipe data numeric
	    $angka = (float)$angka;
	    
	    // array bilangan 
	    // sepuluh dan sebelas merupakan special karena awalan 'se'
	    $bilangan = array(
	            '',
	            'satu',
	            'dua',
	            'tiga',
	            'empat',
	            'lima',
	            'enam',
	            'tujuh',
	            'delapan',
	            'sembilan',
	            'sepuluh',
	            'sebelas'
	    );
	    
	    // pencocokan dimulai dari satuan angka terkecil
	    if ($angka < 12) {
	        // mapping angka ke index array $bilangan
	        return $bilangan[$angka];
	    } else if ($angka < 20) {
	        // bilangan 'belasan'
	        // misal 18 maka 18 - 10 = 8
	        return $bilangan[$angka - 10] . ' belas';
	    } else if ($angka < 100) {
	        // bilangan 'puluhan'
	        // misal 27 maka 27 / 10 = 2.7 (integer => 2) 'dua'
	        // untuk mendapatkan sisa bagi gunakan modulus
	        // 27 mod 10 = 7 'tujuh'
	        $hasil_bagi = (int)($angka / 10);
	        $hasil_mod = $angka % 10;
	        return trim(sprintf('%s puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
	    } else if ($angka < 200) {
	        // bilangan 'seratusan' (itulah indonesia knp tidak satu ratus saja? :))
	        // misal 151 maka 151 = 100 = 51 (hasil berupa 'puluhan')
	        // daripada menulis ulang rutin kode puluhan maka gunakan
	        // saja fungsi rekursif dengan memanggil fungsi terbilang(51)
	        return sprintf('seratus %s', terbilang($angka - 100));
	    } else if ($angka < 1000) {
	        // bilangan 'ratusan'
	        // misal 467 maka 467 / 100 = 4,67 (integer => 4) 'empat'
	        // sisanya 467 mod 100 = 67 (berupa puluhan jadi gunakan rekursif terbilang(67))
	        $hasil_bagi = (int)($angka / 100);
	        $hasil_mod = $angka % 100;
	        return trim(sprintf('%s ratus %s', $bilangan[$hasil_bagi], terbilang($hasil_mod)));
	    } else if ($angka < 2000) {
	        // bilangan 'seribuan'
	        // misal 1250 maka 1250 - 1000 = 250 (ratusan)
	        // gunakan rekursif terbilang(250)
	        return trim(sprintf('seribu %s', terbilang($angka - 1000)));
	    } else if ($angka < 1000000) {
	        // bilangan 'ribuan' (sampai ratusan ribu
	        $hasil_bagi = (int)($angka / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
	        $hasil_mod = $angka % 1000;
	        return sprintf('%s ribu %s', terbilang($hasil_bagi), terbilang($hasil_mod));
	    } else if ($angka < 1000000000) {
	        // bilangan 'jutaan' (sampai ratusan juta)
	        // 'satu puluh' => SALAH
	        // 'satu ratus' => SALAH
	        // 'satu juta' => BENAR 
	        // hasil bagi bisa satuan, belasan, ratusan jadi langsung kita gunakan rekursif
	        $hasil_bagi = (int)($angka / 1000000);
	        $hasil_mod = $angka % 1000000;
	        return trim(sprintf('%s juta %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
	    } else if ($angka < 1000000000000) {
	        // bilangan 'milyaran'
	        $hasil_bagi = (int)($angka / 1000000000);
	        // karena batas maksimum integer untuk 32bit sistem adalah 2147483647
	        // maka kita gunakan fmod agar dapat menghandle angka yang lebih besar
	        $hasil_mod = fmod($angka, 1000000000);
	        return trim(sprintf('%s miliar %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
	    } else if ($angka < 1000000000000000) {
	        // bilangan 'triliun'
	        $hasil_bagi = $angka / 1000000000000;
	        $hasil_mod = fmod($angka, 1000000000000);
	        return trim(sprintf('%s triliun %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
	    } 
	}
    if ($bb->jumlah_diajukan)
    {
    	echo"<div style=width:400px>";
        echo ucwords(Terbilang($bb->jumlah_diajukan))." Rupiah";
        echo"</div>";
    }
    
    ?></td></tr>
			                  	<tr><td></td></tr><tr><td></td></tr>
			                  	<tr><td><b> Periode Realisasi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><b> : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><input class="form-control" type="text" style="width:400px" value="<?php 
																																																																					  if($bb->periode_realisasi=='1'){ echo "TW I";}
																																																																					  if($bb->periode_realisasi=='2'){ echo "TW II";}
																																																																					  if($bb->periode_realisasi=='3'){ echo "TW III";}
																																																																					  if($bb->periode_realisasi=='4'){ echo "TW IV";}
																																																																				      ?>" disabled="disabled"></td></tr>
			                  	<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
			                  	<tr><td><b> Lampiran </b></td><td><b> : </b></td><td><a href="{{ URL('pengajuan_dropping/download/'. $bb->id) }}" target="_blank">{{ $bb->name }}</a>&nbsp;&nbsp;
			                  														 <span><a href="{{ URL('pengajuan_dropping/print/'. $bb->id) }}" target="_blank" class="btn btn-warning btn-sm" ><i class="fa fa-print"></i> Formulir Pengajuan</a></span></td></tr>
			                  	<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
			                  	<form enctype="multipart/form-data" role="form" action="{{ URL('acc_pengajuan_dropping/update_accpengajuandropping/'. $bb->id) }}" method="POST" onsubmit="return validasi_input(this)">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$bb->id}}" />
			                  	<tr><td><b> Verifikasi </b></td><td><b> : </b></td><td><select class="select form-control" name="verifikasi" style="width:400px" required="required" value="{{$bb->verifikasi}}" @if ($bb->kirim<>2) disabled="disabled" @endif>
													                                   <option value="">- Pilih Verifikasi -</option>
													                                   <option value="1" @if ($bb->verifikasi=='1')Selected @endif>Diterima</option>
																					   <option value="2" @if ($bb->verifikasi=='2')Selected @endif>Ditolak</option>                                                 
													                                   </select></td></tr>
			                  	<tr><td></td></tr>
			                  	<tr><td><b> keterangan </b></td><td><b> : </b></td><td><select class="select form-control" name="keterangan" style="width:400px" value="{{$bb->keterangan}}" @if (($bb->kirim<>2)||($bb->verifikasi!=2)) disabled="disabled" @endif>
													                                    <option value=""> - Pilih Keterangan - </option>
									                                                    <?php
									                                                    $second="SELECT * FROM reject_reasons where type=6";
																		                $return = DB::select($second);
																		                ?>
																						@foreach($return as $b)
									                                                      <option value="{{ $b->id }}"
											                                              @if($b->id == $bb->keterangan) Selected>{{ $b->content }}@endif
											                                              @if($b->id <> $bb->keterangan)>{{ $b->content }}@endif
											                                              </option>
									                                                    @endforeach                                               
													                                   </select></td></tr>
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
					                                            @if ($bb->verifikasi==1)
					                                            	<center><h4>Anda yakin ingin mengirim hasil verifikasi<br>ke verifikasi level 2 ?</h4></center>
					                                        	@elseif ($bb->verifikasi==2)
					                                        		<center><h4>Anda yakin ingin mengirim hasil verifikasi<br>ke {{$bb->kantor_cabang}} ?</h4></center>
					                                        	@endif
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
			                  	<div class="btn btn-success pull-right"><span><b>Telah dikirim ke verifikasi level 2</b></span></div>
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
				
				<script type="text/javascript">
					 $('select[name="verifikasi"]').on('change', function() {
				      if ($(this).val() !== '2') {
				        $('select[name="keterangan"]').prop("disabled", true);
				        $('select[name="keterangan"] option:selected').attr("selected",null);
				        $('select[name="keterangan"] option[value=00]').attr("selected","selected");
				        $('select[name="keterangan"]').val('00');
				        $('#select-keterangan-container').attr("title","");
				        $('#select-keterangan-container').html("");
				        // alert($('select[name="keterangan"]').val());
				        toastr.info("Keterangan tidak perlu dipilih jika verifikasi diterima.", "Verifiaksi diterima", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
				      } else {
				        $('select[name="keterangan"]').prop("disabled", false);
				      }
				    });
					
                	function validasi_input(form){
                        if (form.verifikasi.value ==1){
                         if (form.keterangan.value !=""){
                            toastr.info("Jika verifikasi diterima, anda tidak perlu memilih keterangan.", "Anda Tidak Perlu Memilih Keterangan", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                            return (false);
                         }
                        }
                        if (form.verifikasi.value ==2){
                         if (form.keterangan.value ==""){
                            toastr.info("Jika verifikasi ditolak, silahkan pilih keterangan terlebih dahulu.", "Anda Belum Memilih Keterangan", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                            return (false);
                         }
                        }
                        return (true);
                        }
                </script>
                @endsection
