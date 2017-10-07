<html>
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css') }}">

  <body onload="window.print()">
	<style>
        body {
            font-family: Arial;
        }
        h3 {
            text-transform: uppercase;
        }
        table {
            border-collapse: collapse;
        }
        th {
            background-color: #cccccc;
            text-transform: uppercase;
        }
        th, td {
            border: 1px solid #000;
            margin:auto;
            padding: 5px;
        }
        td{
            padding: 3px;
            font-size: 90%;
        }
  </style>
    <div id="header">
        <img src="{{ asset('app-assets/images/asabri-logo-kecil.png', $secure = null) }}" align="left">
        <h3><center>LAPORAN REALISASI ANGGARAN PT ASABRI (PERSERO)</center></h3>
        <h3><center>{{ $cabangs->where('VALUE', $filters['cabang'])->first()['DESCRIPTION']}}</center></h3>
        <h4><center>Periode {{$start}} s.d. {{$end}} Th. {{$year}}</center></h4>
    </div>
    <br><br>
    <div id="content">
        <table class="table table-striped table-bordered datatable-select-inputs nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="bg-lighten-2" width="40%"><center>DESKRIPSI ANGGARAN</center></th>
                <th class="bg-lighten-2" width="20%"><center>ANGGARAN</center></th>
                <th class="bg-lighten-2" width="20%"><center>REALISASI PERIODE</center></th>
                <th class="bg-lighten-2" width="20%"><center>SISA ANGGARAN</center></th>
              </tr>
              <tr>
                <th class="bg-lighten-2"><center>1</center></th>
                <th class="bg-lighten-2"><center>2</center></th>
                <th class="bg-lighten-2"><center>3</center></th>
                <th class="bg-lighten-2"><center>4</center></th>
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
                <td><center>TOTAL DROPPING PERIODE <br>{{$start}} s.d {{$end}} {{$year}}</br></center></td>
                <td align="right">{{ number_format($tmp_realisasi, 2, ',','.') }}</td>
              </tr>
            </tbody>
          </table>
    </div>
  </body>
</html>