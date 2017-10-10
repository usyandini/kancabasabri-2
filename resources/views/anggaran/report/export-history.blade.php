<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
		h3 {
            text-transform: uppercase;
        }		
		td, th{
        	margin:auto;
        	padding:5px;			
		}
        th {
            background-color: #cccccc;
            text-align:center;
			border: 1px solid #000;
        }
        table.body{
			border-collapse:collapse;
			
			margin-left:auto;
			margin-right:auto;

        	border: 1px solid #000;
		}
        tr.body, td.body{
			border: 1px solid #000;
        	padding: 5px;
            font-size: 80%;
        }
        table.header{
        	border: none;
        	width:50%;
        }
        tr.header{
        	border:none;
        }
	</style>
<body>
	<div id="header">
		<img src='<?php echo $_SERVER["DOCUMENT_ROOT"].'/app-assets/images/asabri-logo.png'; ?>' align="left" style="max-width: 80px;">
        <div="title">
	        <h3><center>History Anggaran dan Kegiatan PT ASABRI (PERSERO)</center></h3>	  
	    </div>
    </div>
    <br><br><br>
    <div id="content">
    	<div style="overflow-x:auto;">
			<table class='header' style="max-width: 50%;">
				@foreach($header as $head)
				<tr class='header'>
					<td width='8%'>Tahun</td>
					<td width='3%'>:</td>
					<td width='30%' align='left' colspan='4'>{{ $head['tahun'] }}</td>
				</tr>
				<tr class='header'>
					<td>Unit Kerja</td>
					<td>:</td>
					<td colspan='4'>{{ $head['unit_kerja'] }}</td>					
				</tr>
				@endforeach
			</table>
			<br><br>
			<table class='body'>
				<thead>
					<tr>
						<th>Jenis</th>
						<th>Kelompok</th>
						<th>Pos Anggaran</th>
						<th>Sub Pos</th>
						<th>Mata Anggaran</th>
						<th>Input Anggaran dan Kegiatan</th>
						<th>Clearing House</th>
						<th>Naskah RKAP</th>
						<th>Persetujuan Dewan Komisaris</th>
						<th>Rapat Teknis</th>
						<th>RUPS</th>
						<th>Finalisasi RUPS</th>
						<th>Risalah RUPS</th>
					</tr>
				</thead>
				<tbody>
					@foreach($list as $val)
					<tr class='body'>
						<td class='body'>{{$val['jenis']}}</td>
						<td class='body'>{{$val['kelompok']}}</td>
						<td class='body'>{{$val['pos_anggaran']}}</td>
						<td class='body'>{{$val['sub_pos']}}</td>
						<td class='body'>{{$val['mata_anggaran']}}</td>
						<td class='body'>{{number_format($val['input_anggaran'],2,',','.')}}</td>
						<td class='body'>{{number_format($val['clearing_house'],2,',','.')}}</td>
						<td class='body'>{{number_format($val['naskah_rkap'],2,',','.')}}</td>
						<td class='body'>{{number_format($val['dewan_komisaris'],2,',','.')}}</td>
						<td class='body'>{{number_format($val['rapat_teknis'],2,',','.')}}</td>
						<td class='body'>{{number_format($val['rups'],2,',','.')}}</td>
						<td class='body'>{{number_format($val['finalisasi_rups'],2,',','.')}}</td>
						<td class='body'>{{number_format($val['risalah_rups'],2,',','.')}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>