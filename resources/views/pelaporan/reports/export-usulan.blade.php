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
			width:100%;
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
        	border:none;
        	border-collapse:collapse;
        	width:30%;
        }
        tr.header{
        	border:none;
        }
	</style>
<body>
	<div id="header">
		<img src='<?php echo $_SERVER["DOCUMENT_ROOT"].'/app-assets/images/asabri-logo.png'; ?>' align="left" style="max-width: 80px;">
		<div="title">
	        <h3><center>Usulan Program Prioritas PT ASABRI (PERSERO)</center></h3>	  
	    </div>
    </div>
    <br><br><br>
    <div id="content">
    	<div style="overflow-x:auto;">
			<table class='header'>
				@foreach($header as $head)
				<tr class='header'>
					<td width='8%'>Tahun</td>
					<td width='3%'>:</td>
					<td width='30%' align='left' colspan='3'>{{date('Y', strtotime($head['tanggal']))}}</td>
				</tr>
				<tr class='header'>
					<td>TW</td>
					<td>:</td>
					<td><center>{{$head['tw_dari']}}</center></td>					
					<td><center>s/d</center></td>					
					<td><center>{{$head['tw_ke']}}</center></td>					
				</tr>
				@endforeach
			</table>
			<br><br>
			<table class='body'>
				<thead>
					<tr>
						<th>Nama Program</th>
						<th>Latar Belakang Alasan</th>
						<th>Dampak (+) Pelaksanaan bagi Perusahaan</th>
						<th>Dampak (-) Tidak Dilaksanakan</th>
					</tr>
				</thead>
				<tbody>
					@foreach($list as $val)
					<tr class='body'>
						<td class='body' width='20%'>{{$val['nama_program']}}</td>
						<td class='body' width='20%'>{{$val['latar_belakang']}}</td>
						<td class='body' width='30%'>{{$val['dampak_positif']}}</td>
						<td class='body' width='30%'>{{$val['dampak_negatif']}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>