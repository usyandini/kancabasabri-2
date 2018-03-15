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
        	width:100%;
        	margin-left:auto;
			margin-right:auto;
        }
        tr.header{
        	border:none;
        }
	</style>
<body>
	<div id="header">
		<img src='<?php echo $_SERVER["DOCUMENT_ROOT"].'/app-assets/images/asabri-logo.png'; ?>' align="left" style="max-height: 80px;">
        <div="title">
	        <h3><center>LAPORAN Anggaran dan Kegiatan PT ASABRI (Persero)</center></h3>	  
	    </div>
    </div>
    <br><br><br>
    <div id="content">
    	<div style="overflow-x:auto;">
			<table class='header'>
				@foreach($header as $head)
				<tr class='header'>
					<td width='10%'>Tahun</td>
					<td width='5%'>:</td>
					<?php $date = str_replace('/', '-', $head['tanggal']); ?>
					<td width='30%' colspan='4'>{{date('Y',strtotime($date))}}</td>
					<td width='15%'>Tipe Anggaran</td>
					<td width='5%'>:</td>
					<td width='30%'colspan='5'>{{$head['tipe_anggaran']}}</td>
				</tr>
				<tr class='header'>
					<td>ND/Surat</td>
					<td>:</td>
					<td colspan='4'>{{$head['nd_surat']}}</td>
					<td>Status Anggaran</td>
					<td>:</td>
					<td colspan='5'>{{$head['stat_anggaran']}}</td>
				</tr>
				<tr class='header'>
					<td>Unit Kerja</td>
					<td>:</td>
					<td colspan='4'>{{$head['unit_kerja']}}</td>
					<td>Persetujuan</td>
					<td>:</td>
					<td colspan='5'>{{$head['persetujuan']}}</td>
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
						<th>Kuantitas</th>
						<th>Satuan</th>
						<th>Nilai Per Satuan</th>
						<th>Terpusat</th>
						<th>TW I</th>
						<th>TW II</th>
						<th>TW III</th>
						<th>TW IV</th>
						<th>Anggaran Setahun</th>
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
						<td class='body'>{{$val['kuantitas']}}</td>
						<td class='body'>{{$val['satuan']}}</td>
						<td class='body'>{{number_format($val['nilai_persatuan'],2,',','.')}}</td>
						<td class='body'>@if($val['terpusat']==1) Ya @else Tidak @endif</td>
						<td class='body'>@if($val['terpusat']==1) Terpusat @else {{number_format($val['TWI'],2,',','.')}} @endif</td>
						<td class='body'>@if($val['terpusat']==1) Terpusat @else {{number_format($val['TWII'],2,',','.')}} @endif</td>
						<td class='body'>@if($val['terpusat']==1) Terpusat @else {{number_format($val['TWIII'],2,',','.')}} @endif</td>
						<td class='body'>@if($val['terpusat']==1) Terpusat @else {{number_format($val['TWIV'],2,',','.')}} @endif</td>
						<td class='body'>{{number_format($val['anggaran_setahun'],2,',','.')}}</td>
					</tr>
					@endforeach
					{{--<tr class='body'>
						<td class='body'></td>
						<td class='body'></td>
						<td class='body'></td>
						<td class='body'></td>
						<td class='body'></td>
						<td class='body'></td>
						<td class='body'></td>
						<td class='body'></td>
						<td class='body'></td>
						<td class='body'></td>
						<td class='body'></td>
						<td class='body'></td>
						<td class='body'></td>
						<td class='body'></td>
					</tr>--}}
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>