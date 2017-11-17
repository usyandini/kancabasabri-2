<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<?php 
				header("Content-type: application/vnd-ms-word");
				header("Content-Disposition: attachment; filename=$filename.doc"); 
	?>
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
		<?php 
		$newheight = 50;
		$image=$_SERVER["DOCUMENT_ROOT"].'/app-assets/images/asabri-logo.png';
		list($originalwidth, $originalheight) = getimagesize($image);
		$ratio = $originalheight / $newheight;
		$newwidth = $originalwidth / $ratio;
		?>
		<!-- <img src='<?php echo $_SERVER["DOCUMENT_ROOT"].'/app-assets/images/asabri-logo.png'; ?>' align="left" width="6%"> -->
		<div="title">
	        <h3>
	        <center><?php echo '<img src="' . $image . '" height="50" width="' . $newwidth . '" align="left"/>';?>Pelaporan Anggaran dan Kegiatan PT ASABRI (PERSERO)</center></h3>	  
	    </div>
    </div>
    <br><br><br>
    <div id="content">
    	<div style="overflow-x:auto;">
			<table class='header'>
				@foreach($header as $head)
				<tr class='header'>
					<td width='13%'>Tahun</td>
					<td width='3%'>:</td>
					<td width='30%' align='left' colspan='3'>{{ date('Y',strtotime($head['tanggal'])) }}</td>
				</tr>
				<tr class='header'>
					<td width='13%'>Unit Kerja</td>
					<td width='3%'>:</td>
					<td width='30%' align='left' colspan='3'>{{ $head['unit_kerja'] }}</td>
				</tr>
				<tr class='header'>
					<td>TW</td>
					<td>:</td>
					<td><center>{{ $head['tw_dari'] }}</center></td>					
					<td><center>s/d</center></td>					
					<td><center>{{ $head['tw_ke'] }}</center></td>					
				</tr>
				@endforeach
			</table>
			<br><br>
			<table class='body'>
				<thead>
					<tr>
						<th>Program Prioritas</th>
						<th>Sasaran Yang ingin Dicapai</th>
						<th>Uraian Progress</th>
					</tr>
				</thead>
				<tbody>
					@foreach($list as $val)
					<tr class='body'>
						<td class='body' width='20%'>{{$val['program_prioritas']}}</td>
						<td class='body' width='30%'>{{$val['sasaran_dicapai']}}</td>
						<td class='body' width='30%'>{{$val['uraian_progress']}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>