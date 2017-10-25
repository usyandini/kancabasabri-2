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
	        <h3><center>LAPORAN REALISASI TRANSAKSI PT ASABRI (PERSERO)</center></h3>
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
                <th class="bg-lighten-2" width="23%"><center>DESKRIPSI ANGGARAN</center></th>
                <th class="bg-lighten-2" width="23%"><center>URAIAN</center></th>
                <th class="bg-lighten-2" width="18%"><center>ANGGARAN</center></th>
                <th class="bg-lighten-2" width="18%"><center>REALISASI PERIODE</center></th>
                <th class="bg-lighten-2" width="18%"><center>SISA ANGGARAN</center></th>
              </tr>
              <tr>
                <th class="bg-lighten-2"><center>1</center></th>
                <th class="bg-lighten-2"><center>2</center></th>
                <th class="bg-lighten-2"><center>3</center></th>
                <th class="bg-lighten-2"><center>4</center></th>
                <th class="bg-lighten-2"><center>5</center></th>
              </tr>
            </thead>
            <tbody>
              <tr id="th1">
                <td style="padding-top:20px; padding-left:20px; padding-bottom:20px;" colspan="5"><b>a. Kancab</b></td>
                
              </tr>
              <?php 
                $no=1; 
                $tmp_anggaran = $tmp_realisasi = $tmp_sisa = 0;
                $longkap="longkap";
              ?>
              @foreach($transaksi as $trans)
              <tr>
                <td style="padding-left:20px;">@if ($longkap != $trans->DESCRIPTION) {{$no++}}.) {{ $trans->DESCRIPTION }} @endif</td>
                <td style="padding-left:20px;">{{ $trans->URAIAN }}</td>
                <td align="right">@if ($longkap != $trans->DESCRIPTION)Rp {{ number_format($trans->ANGGARAN_AWAL, 2, ',','.') }}<?php $tmp_anggaran += $trans->ANGGARAN_AWAL;?>@endif</td>
                <td align="right">Rp {{ number_format($trans->REALISASI_ANGGARAN, 2, ',','.') }}</td>
                <td align="right">Rp {{ number_format($trans->SISA_ANGGARAN, 2, ',','.') }}</td>
              </tr>
              <?php 
                $longkap = $trans->DESCRIPTION;
                $tmp_realisasi += $trans->REALISASI_ANGGARAN;
              ?>
              @endforeach
              <tr id="tf1">
                <td colspan="2" style="padding-top:20px; padding-bottom:20px;"><b><center>JUMLAH</center></b></td>
                <td align="right"><b>Rp {{ number_format($tmp_anggaran, 2, ',','.') }}</b></td>
                <td align="right"><b>Rp {{ number_format($tmp_realisasi, 2, ',','.') }}</b></td>
                <?php $sisa=$tmp_anggaran-$tmp_realisasi; ?>
                <td align="right"><b>Rp {{ number_format($sisa, 2, ',','.') }}</b></td>
              </tr>
              <tr id="tf2">
                @if($filters['start'] == $filters['end'])
                <td colspan="2" style="padding-top:20px;"><center><b>TOTAL DROPPING PERIODE </b><br>{{ $filters['start'] }} {{ $filters['year'] }}</center></br></td>
                @else
                <td colspan="2" style="padding-top:20px;"><center><b>TOTAL DROPPING PERIODE </b><br>{{ $filters['start'] }} s.d {{ $filters['end'] }} {{ $filters['year'] }}</center></br></td>
                @endif
                <td colspan="3" align="right"><center><b>Rp {{ number_format($tmp_realisasi, 2, ',','.') }}</b></center></td>
              </tr>
            </tbody>
          </table>
	    </div>
    </div>
</body>
<html>