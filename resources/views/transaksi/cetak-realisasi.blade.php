<html>
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css') }}">
  <body onload="window.print()">
  <style type="text/css" media="print">
    @page { size: portrait; }
  </style>
	<style>
        body { font-family: 'Helvetica'; }
        h3 { text-transform: uppercase; }
        table { border-collapse: collapse; }
        th { background-color: #cccccc; text-transform: uppercase; }
        th, td { border: 1px solid #000; margin:auto; padding: 5px; }
        td{ padding: 3px; font-size: 90%; }
  </style>
    <div id="header">
        <img src="{{ asset('app-assets/images/asabri-logo-kecil.png', $secure = null) }}" align="left">
        <h3><center>LAPORAN REALISASI ANGGARAN PT ASABRI (PERSERO)</center></h3>
        <h3><center>{{ $cabangs->where('VALUE', $filters['cabang'])->first()['DESCRIPTION']}}</center></h3>
        @if($filters['start'] == $filters['end'])
        <h4><center>Periode {{ $filters['start'] }} Th. {{ $filters['year'] }}</center></h4>
        @else
        <h4><center>Periode {{ $filters['start'] }} s.d. {{ $filters['end'] }} Th. {{$filters['year']}}</center></h4>
        @endif
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
                <td style="padding-top:40px;" colspan="4"><b>a. Kancab</b></td>
                {{-- <td></td>
                <td></td>
                <td></td> --}}
              </tr>
              <?php 
                $no=1; 
                $tmp_anggaran = $tmp_realisasi = $tmp_sisa = 0;
              ?>
              @foreach($transaksi as $trans)
              <tr>
                <td style="padding-left:20px;" width="35%">{{$no++}}.) {{ $trans->DESCRIPTION }}</td>
                <td align="right" width="20%">Rp {{ number_format($trans->ANGGARAN_AWAL, 2, ',','.') }}</td>
                <td align="right" width="20%">Rp {{ number_format($trans->REALISASI_ANGGARAN, 2, ',','.') }}</td>
                <td align="right" width="25%">Rp {{ number_format($trans->SISA_ANGGARAN, 2, ',','.') }}</td>
              </tr>
              <?php 
                $tmp_anggaran += $trans->ANGGARAN_AWAL;
                $tmp_realisasi += $trans->REALISASI_ANGGARAN;
                $tmp_sisa += $trans->SISA_ANGGARAN;
              ?>
              @endforeach
              <tr id="tf1">
                <td><center>JUMLAH</center></td>
                <td align="right"><b>Rp {{ number_format($tmp_anggaran, 2, ',','.') }}</b></td>
                <td align="right"><b>Rp {{ number_format($tmp_realisasi, 2, ',','.') }}</b></td>
                <td align="right"><b>Rp {{ number_format($tmp_sisa, 2, ',','.') }}</b></td>
              </tr>
              <tr id="tf2">
                @if($filters['start'] == $filters['end'])
                <td><center>TOTAL DROPPING PERIODE <br>{{ $filters['start'] }} {{ $filters['year'] }}</br></center></td>
                @else
                <td><center>TOTAL DROPPING PERIODE <br>{{ $filters['start'] }} s.d {{ $filters['end'] }} {{ $filters['year'] }}</br></center></td>
                @endif
                <td align="right"><b>Rp {{ number_format($tmp_realisasi, 2, ',','.') }}</b></td>
              </tr>
            </tbody>
          </table>
    </div>
  </body>
</html>