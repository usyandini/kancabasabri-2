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
        <img src="{{ asset('app-assets/images/asabri-logo-kecil.png', $secure = null) }}" align="left" height="80">
        <h3><center>LAPORAN REALISASI TRANSAKSI PT ASABRI (PERSERO)<br>
        {{ $cabangs->where('VALUE', $filters['cabang'])->first()['DESCRIPTION']}} <br>
        @if($filters['start'] == $filters['end'])
        Periode {{ $filters['start'] }} Th. {{ $filters['year'] }}
        @else
        Periode {{ $filters['start'] }} s.d. {{ $filters['end'] }} Th. {{$filters['year']}}</center></h3>
        @endif
    </div>
    <br><br>
    <div id="content">
        <table class="table table-striped table-bordered datatable-select-inputs nowrap" cellspacing="0" width="100%">
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
              <?php
                $mata=$trans->mata_anggaran;
                $a = DB::table('item_master_transaksi')
                ->where('SEGMEN_6', $mata)->first();
                $nama=$a->nama_item;
              ?>
              <tr>
                @if ($longkap != $trans->account)<td style="padding-left:20px;" rowspan = "{{$data_count[$trans->account]}}"> {{$no++}}.) {{ $nama }}</td> @endif
                <td style="padding-left:20px;"><?php echo nl2br(str_replace('', '', htmlspecialchars($trans->desc))); ?></td>
                @if ($longkap != $trans->account)<td align="right" rowspan = "{{$data_count[$trans->account]}}">Rp {{ number_format($trans->anggaran, 2, ',','.') }}<?php $tmp_anggaran += $trans->anggaran;?></td>@endif
                <td align="right">Rp. {{ number_format($trans->realisasi, 0, '', '.') }}</td>
                <td align="right">Rp. {{ number_format($trans->sisa_anggaran, 0, '', '.') }}</td>
              </tr>
              <?php 
                $longkap = $trans->account;
                $tmp_realisasi += $trans->realisasi;
              ?>
              @endforeach
              <tr id="tf1">
                <td colspan="2" style="padding-top:20px; padding-bottom:20px;"><b><center>JUMLAH</center></b></td>
                <td align="right"><b>Rp. {{ number_format($tmp_anggaran, 0, '', '.') }}</b></td>
                <td align="right"><b>Rp. {{ number_format($tmp_realisasi, 0, '', '.') }}</b></td>
                <?php $sisa=$tmp_anggaran-$tmp_realisasi; ?>
                <td align="right"><b>Rp. {{ number_format($sisa, 0, '', '.') }}</b></td>
              </tr>
              <tr id="tf2">
                @if($filters['start'] == $filters['end'])
                <td colspan="2" style="padding-top:20px;"><center><b>TOTAL DROPPING PERIODE </b><br>{{ $filters['start'] }} {{ $filters['year'] }}</center></br></td>
                @else
                <td colspan="2" style="padding-top:20px;"><center><b>TOTAL DROPPING PERIODE </b><br>{{ $filters['start'] }} s.d {{ $filters['end'] }} {{ $filters['year'] }}</center></br></td>
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
  </body>
</html>