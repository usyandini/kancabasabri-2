<html>
	@if($excel)
		<?php 
		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=Realisasi-anggaran-".date("dmY").".xls"); 
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
	        <h3><center>LAPORAN REALISASI MATA ANGGARAN PT ASABRI (PERSERO)</center></h3>
	        <h3><center>{{ $cabangs->where('VALUE', $filters['cabang'])->first()['DESCRIPTION']}}</center></h3>
	        @if($filters['start'] == $filters['end'])
	        <h4><center>Periode {{ $filters['start'] }} Th. {{ $filters['year'] }}</center></h4>
	        @else
	        <h4><center>Periode {{ $filters['start'] }} s.d. {{ $filters['end'] }} Th. {{$filters['year']}}</center></h4>
	        @endif
	    </div>
    </div>
    <br><br>
    <div id="content">
    	<div style="overflow-x:auto;">
	    	<table>
	    		<thead>
	              <tr>
	                <th width="40%"><center>DESKRIPSI ANGGARAN</center></th>
	                <th width="20%"><center>ANGGARAN</center></th>
	                <th width="20%"><center>REALISASI PERIODE</center></th>
	                <th width="20%"><center>SISA ANGGARAN</center></th>
	              </tr>
	              <tr>
	                <th><center>1</center></th>
	                <th><center>2</center></th>
	                <th><center>3</center></th>
	                <th><center>4</center></th>
	              </tr>
	            </thead>
	            <tbody>
	              <tr id="th1">
	                <td style="padding-top:40px;" colspan="4"><b>a. Kancab</b></td>
	              </tr>
	              <?php 
	                $no=1; 
	                $tmp_anggaran = $tmp_realisasi = $tmp_sisa = 0;
	              ?>
	              @foreach($transaksi as $trans)
	              <?php
	                $mata=$trans->mata_anggaran;
	                $a = DB::table('item_master_transaksi')
	                ->where('SEGMEN_6', $mata)->first();
	                $nama=$a->nama_item;
	              ?>
	              <tr>
	                <td style="padding-left:20px;" width="35%">{{$no++}}) {{ $nama }}</td>
	                <td align="right" width="20%">Rp. {{ number_format($trans->anggaran, 0, '','.') }}</td>
	                <td align="right" width="20%">Rp. {{ number_format($trans->realisasi, 0, '','.') }}</td>
	                <td align="right" width="25%">Rp. {{ number_format($trans->sisa_anggaran, 0, '','.') }}</td>
	              </tr>
	              <?php 
	                $tmp_anggaran += $trans->anggaran;
	                $tmp_realisasi += $trans->realisasi;
	                $tmp_sisa += $trans->sisa_anggaran;
	              ?>
	              @endforeach
	              <tr id="tf1">
	                <td><center>JUMLAH</center></td>
	                <td align="right"><b>Rp. {{ number_format($tmp_anggaran,0, '','.') }}</b></td>
	                <td align="right"><b>Rp. {{ number_format($tmp_realisasi, 0, '','.') }}</b></td>
	                <td align="right"><b>Rp. {{ number_format($tmp_sisa, 0, '','.') }}</b></td>
	              </tr>
	              <tr id="tf2">
	              	@if($filters['start'] == $filters['end'])
			        <td><center>TOTAL DROPPING PERIODE <br>{{ $filters['start'] }} {{ $filters['year'] }}</br></center></td>
			        @else
	                <td><center>TOTAL DROPPING PERIODE <br>{{ $filters['start'] }} s.d {{ $filters['end'] }} {{ $filters['year'] }}</br></center></td>
	                @endif
	                <?php
	                $cb    = $cabangs->where('VALUE', $filters['cabang'])->first()['DESCRIPTION'];
	                $a2 = DB::table('dropping')
	                ->where('CABANG_DROPPING', $cb)
	                ->whereMonth('TRANSDATE','>=', $awal)
	                ->whereMonth('TRANSDATE','<=', $akhir)
	                ->whereYear('TRANSDATE', '=', $transyear)->first();
	                if ($a2)
	                {
	                  $uang=$a2->DEBIT;
	                }
	                else
	                {
	                  $uang="0";
	                }
	                ?>
	                <td colspan="3" align="right"><center><b>Rp. {{ number_format($uang, 0, '', '.') }}</b></center></td>
	              </tr>
	            </tbody>
	    	</table>
	    </div>
    </div>
</body>
<html>