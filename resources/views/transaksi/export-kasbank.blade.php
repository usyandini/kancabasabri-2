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
	    	<table>
          <thead>
                <tr>
                                      <th rowspan="2" style="vertical-align:middle;"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TANGGAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                      <th rowspan="2" style="vertical-align:middle;"><center>NO.BK</center></th>
                                      <th rowspan="2" style="vertical-align:middle;"><center>Journal Name</center></th>
                                      <th rowspan="2" colspan="2" style="vertical-align:middle;"><center>URAIAN TRANSAKSI</center></th>
                                      <th colspan="2"><center>KAS</center></th>
                                      <th colspan="2"><center>BANK</center></th>
                                      <th style="vertical-align:middle;"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SALDO KAS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                      
                                      <th style="vertical-align:middle;"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SALDO BANK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                      
                                    </tr>
                                    <tr>
                                      <th><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEBET&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                      <th><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;KREDIT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                      <th><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEBET&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                      <th><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;KREDIT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                      <?php
                                      $tgl1="".$filters['transyear']."-".$filters['awal']."-01";
                                      $tgl2 = date('Y-m-d', strtotime('-1 days', strtotime($tgl1))); 
                                      $saldoo=DB::select("SELECT 
                                                         accountid,
                                                         SUM(AmountCur)+SUM(AmountCorrect) as saldo
                                                              FROM [AX_DUMMY].[dbo].[BANKACCOUNTTRANS] as a
                                                              join [AX_DUMMY].[dbo].[PIL_BANK_VIEW] as b
                                                              on a.ACCOUNTID=b.BANK
                                                              where  b.ID_CABANG = '".$filters['cabang']."'
                                                              and a.TRANSDATE <= '$tgl2'
                                                              and a.ACCOUNTID like '%KKC%'
                                                              group by a.ACCOUNTID");
                                      ?>
                                      <td align="right"><b>@foreach($saldoo as $aa) Rp {{ number_format($aa->saldo, 2, ',','.') }} @endforeach</b></td>
                                      
                                      <?php
                                      $tglb="".$filters['transyear']."-".$filters['awal']."-01";
                                      $tglb = date('Y-m-d', strtotime('-1 days', strtotime($tglb))); 
                                      $saldob=DB::select("SELECT 
                                                         accountid,
                                                         SUM(AmountCur)+SUM(AmountCorrect) as saldo
                                                              FROM [AX_DUMMY].[dbo].[BANKACCOUNTTRANS] as a
                                                              join [AX_DUMMY].[dbo].[PIL_BANK_VIEW] as b
                                                              on a.ACCOUNTID=b.BANK
                                                              where  b.ID_CABANG = '".$filters['cabang']."'
                                                              and a.TRANSDATE <= '$tgl2'
                                                              and a.ACCOUNTID like '%GKC%'
                                                              group by a.ACCOUNTID");
                                      ?>
                                      <td align="right"><b>@foreach($saldob as $bb) Rp {{ number_format($bb->saldo, 2, ',','.') }} @endforeach</b></td>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                  if (empty($aa->saldo)){
                                    $saldokas=0;
                                  }
                                  else {
                                    $saldokas=$aa->saldo;
                                  }
                                  if (empty($bb->saldo)){
                                    $saldobank=0;
                                  }
                                   else {
                                    $saldobank=$bb->saldo;
                                  }
                                  ?>
                                  @if($filters)
                                  @forelse($transaksi as $trans)
                                  <tr>
                                                <?php
                                                  
                                                  $tanggal=$trans->tanggal;                                 
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
                                    <td>{{$trans->Nomor_BK}}</td>
                                    <td>{{$trans->JournalName}}</td>
                                    <td width="150px" colspan="2">{{$trans->Description}}</td>
                                    
                                    <?php
                                      $AccoudId = $trans->bankid;
                                      $gkc = explode('GKC',$AccoudId);
                                      $kkc = explode('KKC',$AccoudId);
                                      
                                      if(count($kkc) > 1 ){
                                      $isKas = true;
                                      }
                                      if(count($gkc) > 1 ){
                                      $isKas = false;
                                      }
                                    ?>
                                    
                                    <td align="right">@if($isKas)Rp {{ number_format($trans->debit, 2, ',','.') }} @endif</td>
                                    <td align="right">@if($isKas)Rp {{ number_format($trans->credit, 2, ',','.') }} @endif</td>
                                    <td align="right">@if(!$isKas)Rp {{ number_format($trans->debit, 2, ',','.') }} @endif</td>
                                    <td align="right">@if(!$isKas)Rp {{ number_format($trans->credit, 2, ',','.') }} @endif</td>
                                    <?php
                                    if(!$isKas){  
                                    $saldobank +=  $trans->debit;
                                    $saldobank -=  $trans->credit;
                                    }
                                    if($isKas){  
                                    $saldokas +=  $trans->debit;
                                    $saldokas -=  $trans->credit;
                                    }
                                    ?>
                                    <td align="right">@if($isKas)<b>Rp {{ number_format($saldokas, 2, ',','.') }}</b> @endif</td>
                                    <td align="right">@if(!$isKas)<b>Rp {{ number_format($saldobank, 2, ',','.') }}</b> @endif</td>
                                    
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
</body>
<html>