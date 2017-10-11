<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


@if(count($a))
@foreach($a as $bb)		
			@if($excel)
				@if ($bb->internal=='1')
				<?php 
				header("Content-type: application/vnd-ms-excel");
				header("Content-Disposition: attachment; filename=tindak-lanjut-internal.xls"); ?>
				@else
				<?php 
				header("Content-type: application/vnd-ms-excel");
				header("Content-Disposition: attachment; filename=tindak-lanjut-eksternal.xls"); ?>
				@endif
			@endif

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
			                  <h2><center>

			                  @if($excel)
			                  <img src="{{ asset('app-assets/images/asabri-logo.png', $secure = null) }}" width="6%" align="middle" hspace="1%">
			                  @else
			                  <img src='<?php echo $_SERVER["DOCUMENT_ROOT"].'/app-assets/images/asabri-logo.png'; ?>' align="left" width="6%">		
			                  @endif

			                  @if ($bb->internal=='1')
			                  Form Laporan Tindak Lanjut Pengawasan Internal
			                  @else
			                  Form Laporan Tindak Lanjut Pengawasan Eksternal
			                  @endif
			                  </center></h2>
			                  <br><br><br>

			                  <table>
				                  <tr>
					                  <td><b> Unit Kerja </b></td>
					                  <td><b> : </b></td>
					                  <td align="left"><b>{{ $bb->unitkerja}}</b></td>
					              </tr>
					              <tr>
		                              <td><b> Tanggal Mulai </b></td>
		                              <td><b> : </b></td>
		                              <td align="left"><b>{{ $tgls }} {{ $bulans }} {{ $tahuns }} </b></td>
		                          </tr>
		                          <tr>
		                              <td><b> Durasi </b></td>
		                              <td><b> : </b></td>
		                              <td align="left"><b>{{ $bb->durasi }} Hari </b></td>
	                              </tr>
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
                                		<td><b>Total Temuan </b></td>
                                		<td><b> : </b></td>
                                		<td align="left"><b>{{$ab1}}</b></td>
                                	</tr>
                                	<tr>
                                		<td><b>Total Rekomendasi </b></td>
                                		<td><b> : </b></td>
                                		<td align="left"><b>{{$ab2}}</b></td>
                                	</tr>
                                	<tr>
                                		<td><b>Dalam Proses </b></td>
                                		<td><b> : </b></td>
                                		<td align="left"><b>{{$ab3}}</b></td>
                                	</tr>
                                	<tr>
                                		<td><b>Selesai </b></td>
                                		<td><b> : </b></td>
                                		<td align="left"><b>{{$ab4}}</b></td>
                                	</tr>
                                </table>
                                	
							<br>
							<style>
							        body {
							            font-family: Arial;
							        }
							        .classtable {
							            border-collapse: collapse;
							            width:100%;
							           	margin-left:auto;
							           	margin-right:auto;
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
								<table class="classtable">
			                        <thead>
			                          <tr>
			                            <th class="classth"><center>No</center></th>
			                            <th class="classth"><center>Unit Kerja</center></th>
			                            <th class="classth"><center>Temuan</center></th>
			                            <th class="classth"><center>Rekomendasi</center></th>
			                            <th class="classth"><center>Tindak Lanjut</center></th>
			                            <th class="classth"><center>Status</center></th>
			                            <th class="classth"><center>Keterangan</center></th>
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
			                        			<td class="classtd"><center>
			                        			@if ($longkap != $b->unitkerja)
												{{$no}}
												@endif
			                        			</center></td>
			                        			<td class="classtd"><center>
			                        			@if ($longkap != $b->unitkerja) 
			                        			{{ $b->unitkerja }}
			                        			@endif
			                        			</center></td>
			                        			<td class="classtd">
			                        			@if ($longkap2 != $b->temuan) 
				                           			{{ $b->temuan }}
				                           		@endif
				                           		</td>
			                        			<td class="classtd">
			                        			@if ($longkap3 != $b->rekomendasi) 
					                           			{{ $b->rekomendasi }}
					                           	@endif
					                            </td>
			                        			<td class="classtd">
			                        			@if ($b->rekomendasi!="")
			                        			{{ $b->tindaklanjut }}
					                           	@endif
				                           		</td>
				                           		<td class="classtd"><center>@if ($b->status=='1') Dalam Proses @endif
			                        				@if ($b->status=='2') Selesai @endif</center>
			                        			</td>
			                        			<td class="classtd"><center>{{ $b->keterangan }}</center>
			                        			</td>
			                        </tr>
			                        				
				                	<?php $longkap = $b->unitkerja;
				                		  $longkap2 = $b->temuan;
				                		  $longkap3 = $b->rekomendasi;
				                		  $no++; ?>
				                	@endforeach
			    					@endif
								    
			                        </tbody>
			                      </table>
			                      
			                   
