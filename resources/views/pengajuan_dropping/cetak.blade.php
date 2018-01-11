<html>
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css') }}">
<body onload="window.print()">
<style>
									.uppercase {
    								text-transform: uppercase;
}									}
							        body {
							            font-family: Arial;
							        }
							        .classtable {
							            border-collapse: collapse;
							        }
							        .classth {
							            background-color: #cccccc;
							            border: 1px solid #000;
							            padding: 15px;
							        }
							        .classtd {
							            border: 1px solid #000;
							            padding: 15px;
							        }
							</style>
						@foreach($a as $b)
						<?php
												$tanggal=$b->tanggal;								  
												$tgl= date('d', strtotime($tanggal)); 
												$bs= date('m', strtotime($tanggal));
												  if ($bs=="01"){
												    $bulans="JANUARI";
												  }
												  else if ($bs=="02"){
												    $bulans="FEBRUARI";
												  }
												  else if ($bs=="03"){
												    $bulans="MARET";
												  }
												  else if ($bs=="04"){
												    $bulans="APRIL";
												  }
												  else if ($bs=="05"){
												    $bulans="MEI";
												  }
												  else if ($bs=="06"){
												    $bulans="JUNI";
												  }
												  else if ($bs=="07"){
												    $bulans="JULI";
												  }
												  else if ($bs=="08"){
												    $bulans="AGUSTUS";
												  }
												  else if ($bs=="09"){
												    $bulans="SEPTEMBER";
												  }
												  else if ($bs=="10"){
												    $bulans="OKTOBER";
												  }
												  else if ($bs=="11"){
												    $bulans="NOVEMBER";
												  }
												  else if ($bs=="12"){
												    $bulans="DESEMBER";
												  }
												  $tahun= date('Y', strtotime($tanggal));
												  $angka = number_format($b->jumlah_diajukan,0,"",".");
												  if ($b->periode_realisasi==1){
												  	$periode="TW I";
												  }
												  if ($b->periode_realisasi==2){
												  	$periode="TW II";
												  }
												  if ($b->periode_realisasi==3){
												  	$periode="TW III";
												  }
												  if ($b->periode_realisasi==4){
												  	$periode="TW IV";
												  }
						?>
							  
			                  <div id="header">
						        <img src="{{ asset('app-assets/images/asabri-logo-kecil.png', $secure = null) }}" align="left">
						        <h3><center><p class="uppercase">{{$b->kantor_cabang}}</p></center></h3>
						        <h3><center>FORMULIR PENGAJUAN DROPPING</center></h3>
						        <h3><center>TAHUN ANGGARAN {{$tahun}}</center></h3>
						      </div>
						      <br>
						      <br>
						      <br>
			                  <table>
			                  <tr>
			                  <td><b>
			                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			                  NOMOR NOTA DINAS</b></td><td> </td><td><b> : </b></td><td> </td><td><b>{{ $b->nomor }}</b></td>
			                  </tr>
			                  <tr>
                              <td><b>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              TANGGAL </b></td><td> </td><td><b> : </b></td><td> </td><td><b>{{ $tgl }} {{ $bulans }} {{ $tahun }}</b></td>
                              </tr>
                              <tr>
                              <td><b> 
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              JUMLAH DIAJUKAN </b></td><td> </td><td><b> : </b></td><td> </td><td><b>Rp {{ $angka }},-</b></td>
                              </tr>
                              <tr>
                              	<td><b> 
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              TERBILANG </b></td><td> </td><td><b> : </b></td><td> </td><td><b><?php
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
	        // @#$%^ WT*
	        
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
    if ($b->jumlah_diajukan)
    {
    	echo"<div style=width:250px>";
        echo ucwords(Terbilang($b->jumlah_diajukan))." Rupiah";
        echo"</div>";
    }
    
    ?></b></td>
                              </tr>
                              <tr>
                              <td><b> 
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              PERIODE REALISASI </b></td><td> </td><td><b> : </b></td><td> </td><td><b>{{ $periode }}</b></td>
                              </tr>
                              <tr>
                              <td><b> 
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              LAMPIRAN </b></td><td> </td><td><b> : </b></td><td> </td><td>
                              @if ($b->name!="")
                              <div style=width:250px><b>{{ $b->name }}</b></div>
                              @else
                              <b>Tidak ada</b>
                              @endif
                              </td>
                              </tr>
                              </table>
                              </p>
                        @endforeach
                        <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Demikian Pengajuan dari kami untuk menjadi periksa dan mohon ditindaklanjuti.
                        </b></p>							
                        <table>
                        <tr>
                        <td>
                        <b><center>
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            Kepala<br>
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            {{$b->kantor_cabang}}</center></b>
                        </td>
                        </tr>
                        <tr>
                        <td>
                        &nbsp;
                        </td>
                        </tr>
                        <tr>
                        <td>
                        &nbsp;
                        </td>
                        </tr>
                        <tr>
                        <td>
                        &nbsp;
                        </td>
                        </tr>
                        <tr>
                        <td>
                        <b><center>
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        ttd</center></b>
                        </td>
                        </tr>	
                        </table>
                        <br>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        *form ini adalah form resmi yang dibuat melalui sistem aplikasi yang telah disetujui<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        oleh Kakancab dan tidak memerlukan tanda tangan basah							
						
								
			                        
			                      
			                   
