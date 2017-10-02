<html>
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css') }}">
<?php
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=tindak-lanjut-internal.xls");
?>
<style>
        body {
            font-family: Arial;
        }
        table {
            border-collapse: collapse;
        }
        th {
            background-color: #cccccc;
        }
        th, td {
            border: 1px solid #000;
        }
    </style>
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
				
			                  <h2><center>Form Laporan Tindak Lanjut Pengawasan Internal</center></h2><br>
                              <b> Unit Kerja : {{ $bb->unitkerja}} </b><br>
                              <b> Tanggal Mulai : {{ $tgls }} {{ $bulans }} {{ $tahuns }} </b><br>
                              <b> Durasi : {{ $bb->durasi }} Hari </b><br>
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
                                	<b>Total Temuan : {{$ab1}}</b><br>
                                	<b>Total Rekomendasi : </b></td><td><b>{{$ab2}}</b><br>
                                	<b>Dalam Proses : {{$ab3}}</b><br>
                                	<b>Selesai : {{$ab4}}</b><br>
                                	
							<br>
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
			                        			<td><center>
			                        			@if ($longkap != $b->unitkerja) 
			                        			{{ $b->unitkerja }}
			                        			@endif
			                        			</center></td>
			                        			<td><center>
			                        			@if ($longkap2 != $b->temuan) 
				                           			{{ $b->temuan }}
				                           		@endif
				                           		</center></td>
			                        			<td><center>
			                        			@if ($longkap3 != $b->rekomendasi) 
					                           			{{ $b->rekomendasi }}
					                           	@endif
					                            </center></td>
			                        			<td><center>
			                        			@if ($b->rekomendasi!="")
			                        			{{ $b->tindaklanjut }}
					                           	@endif
				                           		</center></td>
				                           		<td><center>@if ($b->tindaklanjut!="")
				                           			@if ($b->name=="") Tidak Ada
				                           				@else 
				                           					{{ $b->name }}</a>
				                           				@endif
				                           			@endif</center></td>
			                        			<td><center>@if ($b->status=='1') Dalam Proses @endif
			                        				@if ($b->status=='2') Selesai @endif</center></td>
			                        			<td><center>{{ $b->keterangan }}</center></td>
			                        			</tr>
			                        				
				                	<?php $longkap = $b->unitkerja;
				                		  $longkap2 = $b->temuan;
				                		  $longkap3 = $b->rekomendasi;
				                		  $no++; ?>
				                	@endforeach
			    					@endif
								    
			                        </tbody>
			                      </table>
			                      
			                   
