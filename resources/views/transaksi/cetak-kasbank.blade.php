<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
		h3 {
            text-transform: uppercase;
        }
		table{
			border-collapse:collapse;
			width:100%;
			margin-left:auto;
			margin-right:auto;
		}
		td, th{
        	border: 1px solid #000;
        	padding: 5px;	
		}
        th {
            background-color: #cccccc;
        }
        td{
        	border-bottom: 1px solid #000;
            font-size: 75%;
        }
	</style>
	<style type="text/css" media="print">
      @page { size: landscape; }
    </style>
<body onload="window.print()">
	<div id="header">
		<img src="{{ asset('app-assets/images/asabri-logo-kecil.png', $secure = null) }}" align="left">
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
	            	<tr id="th1">
	            		<td colspan="4"><center><b>SALDO PER 31 Juli 2017</b></center></td>
		                <td align="right"><?php $debitkas = 1912862; echo number_format($debitkas,'2',',','.'); ?></td>
		                <td align="right"></td>
		                <td align="right"><?php $debitbank = 37910743.8; echo number_format($debitbank,'2',',','.'); ?></td>
		                <td align="right"></td>
		                <td align="right"><?php $saldo = $debitkas+$debitbank; echo number_format($saldo,'2',',','.'); ?></td>
	            	</tr>
	            	<tr id"content">
	            		<td></td>
		                <td></td>
		                <td width="150px"></td>
		                <td width="80px"></td>
		                <td align="right"></td>
		                <td align="right"></td>
		                <td align="right"></td>
		                <td align="right"></td>
		                <td align="right"><?php $saldo = $debitkas+$debitbank; echo number_format($saldo,'2',',','.'); ?></td>
	            	</tr>
	            	<tr id"content">
	            		<td></td>
		                <td></td>
		                <td width="150px"></td>
		                <td width="80px"></td>
		                <td align="right"></td>
		                <td align="right"></td>
		                <td align="right"></td>
		                <td align="right"></td>
		                <td align="right"><?php $saldo = $debitkas+$debitbank; echo number_format($saldo,'2',',','.'); ?></td>
	            	</tr>
	            	<tr id="tf1">
	            		<td colspan="4"><center><b>JUMLAH</b></center></td>
		                <td align="right"><?php $debitkas = 1912862; echo number_format($debitkas,'2',',','.'); ?></td>
		                <td align="right">-</td>
		                <td align="right"><?php $debitbank = 37910743.8; echo number_format($debitbank,'2',',','.'); ?></td>
		                <td align="right">-</td>
		                <td align="right"><?php $saldo = $saldo; echo number_format($saldo,'2',',','.'); ?></td>
	            	</tr>
	            </tbody>	            
	    	</table>
	    </div>
    </div>
</body>
<html>