<html>
	@if($excel)
		<?php 
		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=Report-kasbank-".date("dmY").".xls"); 
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		?>
	@endif
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
		body { font-family: 'Helvetica'; }
		h3 { text-transform: uppercase; }
		table{ border-collapse:collapse; margin-left:auto; margin-right:auto; }
		td, th{ border: 1px solid #000; margin:auto; padding:5px; }
        th { background-color: #cccccc; }
        td { border-bottom: 1px solid #000; padding: 3px; font-size: 90%; }
	</style>
<body>
	<div id="header">
		@if($excel == false)
		<img src='<?php echo $_SERVER["DOCUMENT_ROOT"].'/app-assets/images/asabri-logo.png'; ?>' align="left" style="max-width: 132px;">
		@endif
		
        <div="title">
          <h3><center>LAPORAN KAS & BANK PT  ASABRI (PERSERO)</center></h3>
          <h3><center>{{ $cabangs->where('VALUE', $filters['cabang'])->first()['DESCRIPTION']}}</center></h3>
          @if($start == $end)
          <h4><center>Periode {{$start}} Th. {{$year}}</center></h4>
          @else
          <h4><center>Periode {{$start}} s.d. {{$end}} Th. {{$year}}</center></h4>
          @endif
      </div>
    </div>
    <br><br>
    <div id="content">
    	<div style="overflow-x:auto;">
	    	<table>
          <thead>
                <tr>
                  <th rowspan="2" width="60px"><center>TGL</center></th>
                  <th rowspan="2" width="50px"><center>NO.BK</center></th>
                  <th rowspan="2" colspan="2"><center>URAIAN TRANSAKSI</center></th>
                  <th colspan="2" width="100px"><center>KAS</center></th>
                  <th colspan="2" width="100px"><center>BANK</center></th>
                  <th rowspan="2" width="80px"><center>SALDO</center></th>
                </tr>
                <tr>
                  <th><center>DEBET</center></th>
                  <th><center>KREDIT</center></th>
                  <th><center>DEBET</center></th>
                  <th><center>KREDIT</center></th>
                </tr>
                <tr>
                  <th><center>1</center></th>
                  <th><center>2</center></th>
                  <th colspan="2"><center>3</center></th>
                  <th><center>4</center></th>
                  <th><center>5</center></th>
                  <th><center>6</center></th>
                  <th><center>7</center></th>
                  <th><center>8</center></th>
                </tr>
              </thead>
              <tbody>
                                  @if($filters)
                                  @forelse($transaksi as $trans)
                                  <tr>
                                                <?php
                                                  $tanggal=$trans->PIL_TransDate;                                 
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
                                              ?>
                                    <td><center>{{$tgl}} {{$bulans}} {{$tahun}}</center></td>
                                    <td>{{$trans->PIL_BK}}</td>
                                    <td width="150px" colspan="2">{{$trans->PIL_Description}}</td>
                                    <?php
                                      $AccoudId = $trans->PIL_ACCOUNTID;
                                      $kas = explode('KAS',$AccoudId);
                                      $kkc = explode('KKC',$AccoudId);
                                      $isKas = false;
                                      if(count($kas) > 1 || count($kkc)>1 ){
                                        $isKas = true;
                                      }
                                    ?>
                                    <td align="right">@if($isKas)Rp {{ number_format($trans->PIL_AmountCurDebit, 2, ',','.') }} @endif</td>
                                    <td align="right">@if($isKas)Rp {{ number_format($trans->PIL_AmountCurCredit, 2, ',','.') }} @endif</td>
                                    <td align="right">@if(!$isKas)Rp {{ number_format($trans->PIL_AmountCurDebit, 2, ',','.') }} @endif</td>
                                    <td align="right">@if(!$isKas)Rp {{ number_format($trans->PIL_AmountCurCredit, 2, ',','.') }} @endif</td>
                                    <td align="right"></td>
                                  </tr>
                                  @empty
                                  <tr>
                                   <td colspan="4">Data tidak ditemukan.</td>
                                  </tr>
                                  @endforelse
                                  @endif
                                </tbody>              
        </table>
	    </div>
    </div>
</body>
<html>