<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
		h3 {
            text-transform: uppercase;
        }
		table{
			border-collapse:collapse;
			
			margin-left:auto;
			margin-right:auto;
		}
		td, th{
        	border: 1px solid #000;
        	margin:auto;
        	padding:5px;			
		}
        th {
            background-color: #cccccc;
        }
        td{
        	border-bottom: 1px solid #000;
        	padding: 3px;
            font-size: 90%;
        }
	</style>
<body>
	<div id="header">
		<img src='<?php echo $_SERVER["DOCUMENT_ROOT"].'/app-assets/images/asabri-logo.png'; ?>' align="left" style="max-width: 132px;">
        <div="title">
	        <h3><center>LAPORAN REALISASI ANGGARAN PT ASABRI (PERSERO)</center></h3>
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
	                <td style="padding-top:40px;">a. Kancab</td>
	                <td></td>
	                <td></td>
	                <td></td>
	              </tr>
	              <?php 
	                $no=1; 
	                $tmp_anggaran = $tmp_realisasi = $tmp_sisa = 0;
	              ?>
	              @foreach($transaksi as $trans)
	              <tr>
	                <td style="padding-left:20px;" width="35%">{{$no++}}) {{$items->where('SEGMEN_1',$trans->item)->first()['nama_item']}}</td>
	                <td align="right" width="20%">{{ number_format($trans->anggaran, 2, ',','.') }}</td>
	                <?php $total_real = $trans->total; ?>
	                <td align="right" width="20%">{{ number_format($total_real, 2, ',','.') }}</td>
	                <?php $sisa_angg = ($trans->anggaran - $total_real);?>
	                <td align="right" width="25%">{{ number_format($sisa_angg, 2, ',','.') }}</td>
	              </tr>
	              <?php 
	                $tmp_anggaran = $tmp_anggaran + $trans->anggaran;
	                $tmp_realisasi = $tmp_realisasi + $trans->total;
	                $tmp_sisa = $tmp_sisa + $sisa_angg;
	              ?>
	              @endforeach
	              <tr id="tf1">
	                <td><center>JUMLAH</center></td>
	                <td align="right">{{ number_format($tmp_anggaran, 2, ',','.') }}</td>
	                <td align="right">{{ number_format($tmp_realisasi, 2, ',','.') }}</td>
	                <td align="right">{{ number_format($tmp_sisa, 2, ',','.') }}</td>
	              </tr>
	              <tr id="tf2">
	              	@if($start == $end)
			        <td><center>TOTAL DROPPING PERIODE <br>{{$start}} {{$year}}</br></center></td>
			        @else
	                <td><center>TOTAL DROPPING PERIODE <br>{{$start}} s.d {{$end}} {{$year}}</br></center></td>
	                @endif
	                <td align="right">{{ number_format($tmp_realisasi, 2, ',','.') }}</td>
	                <td colspan="2" style="border-bottom:none; border-right:none"></td>
	              </tr>
	            </tbody>
	    	</table>
	    </div>
    </div>
</body>
<html>