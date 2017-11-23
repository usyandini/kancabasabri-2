                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css') }}">
                <style type="text/css">
                .hide {
                  display: none;
                }
              </style>
              @endsection

              @section('content')
              {{-- part alert --}}
              @if (Session::has('after_save'))
              <div class="row">
               <div class="col-md-12">
                 <div class="alert alert-dismissible alert-{{ Session::get('after_save.alert') }}">
                   <button type="button" class="close" data-dismiss="alert">×</button>
                   <strong>{{ Session::get('after_save.title') }}</strong>

                 </div>
               </div>
             </div>
             @endif
             {{-- end part alert --}}

             {{-- Kita cek, jika sessionnya ada maka tampilkan alertnya, jika tidak ada maka tidak ditampilkan alertnya --}}
             @if (Session::has('after_update'))
             <div class="row">
               <div class="col-md-12">
                 <div class="alert alert-dismissible alert-{{ Session::get('after_update.alert') }}">
                   <button type="button" class="close" data-dismiss="alert">×</button>
                   <strong>{{ Session::get('after_update.title') }}</strong>

                 </div>
               </div>
             </div>
             @endif
             {{-- end part alert --}}

             {{-- Kita cek, jika sessionnya ada maka tampilkan alertnya, jika tidak ada maka tidak ditampilkan alertnya --}}
             @if (Session::has('after_delete'))
             <div class="row">
               <div class="col-md-12">
                 <div class="alert alert-dismissible alert-{{ Session::get('after_delete.alert') }}">
                   <button type="button" class="close" data-dismiss="alert">×</button>
                   <strong>{{ Session::get('after_delete.title') }}</strong>

                 </div>
               </div>
             </div>
             @endif
             {{-- end part alert --}}

             <div class="content-header row">
              <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Pengajuan Dropping Kantor Cabang</h3>
                <div class="row breadcrumbs-top">
                  <div class="breadcrumb-wrapper col-xs-12">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="#">Pengajuan Dropping</a></li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <section id="select-inputs">
                <div class="row">
                  <div class="col-xs-12">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Pencarian Pengajuan Dropping</h4>
                        <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                      </div>
                      <div class="card-body collapse in">
                        <div class="card-block">
                          <form enctype="multipart/form-data" role="form" action="{{ URL('pengajuan_dropping/carimyform') }}" method="GET" >
                            <div class="row">
                              {{ csrf_field() }}
                              <div class="col-xs-4">
                                <div class="form-group">
                                  <label>Kantor Cabang</label><br>
                                  <select class="select2 form-control block" name="cabang" id="cabang" style="width:300px" onchange="changeUnit()" required="required">
                                    <option value=""> - Pilih Kantor Cabang - </option>
                                    <?php
                                    $second="SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_KPKC]  WHERE VALUE!='00'";
                                    $return = DB::select($second);
                                    ?>
                                    @foreach($return as $b)
                                    <?php $id = $b->VALUE."00"; ?>
                                    @if(Gate::check("unit_".$id) )
                                    <option value="{{ $b->DESCRIPTION }}" >{{ $b->DESCRIPTION }}</option>
                                    @endif
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-xs-3.5">
                                <div class="form-group">
                                  <label>Tanggal</label><br>
                                  <select class="select2 form-control block" name="tanggal" style="width:200px" required="required"></select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-7">
                                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-search "></i> Cari</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <script type="text/javascript">
                      function changeUnit(){
                        var cabang = $('#cabang').val();
                        var uri = "{{ url('pengajuan_dropping/myform').'/'}}"+ encodeURI(cabang);

                        $.ajax({
                          'async': false, 
                          'type': "GET", 
                          'dataType': 'JSON', 
                          'url': uri,
                          'success': function (data) {

                            $('select[name="tanggal"]').empty();
                            $.each(data, function(key, value) {
                              var tanggal = new Date(value).getDate();
                              var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                              var _bulan = new Date(value).getMonth();
                              var bulana = bulan[_bulan];
                              var tahun = new Date(value).getFullYear();
                              $('select[name="tanggal"]').append('<option value="'+ value +'">'+ tanggal +' '+ bulana +' '+ tahun +'</option>');
                            });
                          }
                        });
                      }
                    </script>                   
                  </div>
                </div>
              </div>

              <div class="row">
                <section id="select-inputs">
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">Daftar Pengajuan Dropping</h4></br>
                          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                          <div class="card-body collapse in">                           
                            <div class="card-block">
                              <a href="#" class="btn btn-outline-success btn" data-target="#tambah" data-toggle="modal"><i class="fa fa-plus"></i><b> Tambah Pengajuan</b></a>
                              <div class="modal fade" data-backdrop="static" id="tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><center>
                                        <center><h4 class="modal-title text-success" id="myModalLabel" ><i class="fa fa-plus"></i> Tambah Pengajuan Dropping</h4></center>
                                      </div>
                                      <form enctype="multipart/form-data" role="form" action="{{ URL('pengajuan_dropping/store_pengajuandropping') }}" method="POST" >
                                       {{ csrf_field() }}
                                       <div class="modal-body">
                                        <label class="control-label"><b> Kantor Cabang </b></label>
                                        <label class="control-label"> : </label><br>
                                        <select class="select2 form-control block" name="kantor_cabang" style="width:300px" required="required">
                                          <option value=""> - Pilih Kantor Cabang - </option>
                                          <option value="{{$userCab}}" > {{$userCab}} </option>
                                        </select>
                                        
                                                    <!--<input class="form-control" type="text" name="kantor_cabang" disabled="disabled" required="required" value="{{$userCab}}">
                                                    -->
                                                    <br><br>
                                                    <label class="control-label"><b> Nomor </b></label>
                                                    <label class="control-label"> : </label>
                                                    <input class="form-control" type="text" name="nomor" placeholder="masukkan nomor" required="required">
                                                    <br>
                                                    <label class="control-label"><b> Tanggal </b></label>
                                                    <label class="control-label"> : </label>
                                                    <input class="form-control" type="date" name="tanggal" required="required">  
                                                    <br> 
                                                    <label class="control-label"><b> Jumlah Diajukan </b></label>
                                                    <label class="control-label"> : </label>
                                                    <input class="form-control" type="text" name="jumlah_diajukan" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="masukkan jumlah diajukan" required="required">   
                                                    <br>
                                                    <label class="control-label"><b> Periode Realiasi </b></label>
                                                    <label class="control-label"> : </label>
                                                    <select class="select form-control" name="periode_realisasi" required="required" >
                                                      <!-- <option value="">Pilih Periode Realisasi</option> -->
                                                      <?php
                                                      if (date('n')==1||date('n')==2||date('n')==3){ echo "<option value=1>TW I</option><option value=2>TW II</option><option value=3>TW III</option><option value=4>TW IV</option>";}
                                                      if (date('n')==4||date('n')==5||date('n')==6){ echo "<option value=2>TW II</option><option value=3>TW III</option><option value=4>TW IV</option>";}
                                                      if (date('n')==7||date('n')==8||date('n')==9){ echo "<option value=3>TW III</option><option value=4>TW IV</option>";}
                                                      if (date('n')==10||date('n')==11||date('n')==12){ echo "<option value=4>TW IV</option>";}
                                                      ?>                                                
                                                    </select> 
                                                    <br>
                                                    <label class="control-label"><b> Lampiran </b></label>
                                                    <label class="control-label"><b> : </b></label>
                                                    <input class="form-control" type="file" name="inputs" required="required" />  
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Tambah</button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                                                  </div>
                                                </form>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="card-body collapse in">                         
                                        <div class="card-block">
                                          @if(session('success'))
                                          <div class="alert alert-success">
                                            {!! session('success') !!}
                                          </div>
                                          @endif

                                          <div class="table-responsive">
                                            <table class="table table-striped table-bordered datatable-select-inputs mb-0">
                                              <thead>
                                                <tr>
                                                  <th><center>No</center></th>
                                                  <th id="filterable"><center>Kantor Cabang</center></th>
                                                  <th id="filterable"><center>Nomor</center></th>
                                                  <th id="filterable"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tanggal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                                  <th id="filterable"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jumlah Diajukan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                                  <th id="filterable"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Terbilang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                                  <th id="filterable"><center>Periode Realisasi</center></th>
                                                  <th id="filterable"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lampiran&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                                  <th id="filterable"><center>Verifikasi</center></th>
                                                  <th id="filterable"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Keterangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                                  <th><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <?php $no='1';?>
                                                @if(count($a))
                                                @foreach($a as $b)
                                                <tr>
                                                  <td><center>{{ $no }}</center></td>
                                                  <td>{{ $b->kantor_cabang }}</td>
                                                  <td><center>{{ $b->nomor }}</center></td>
                                                  <?php
                                                  $tanggal=$b->tanggal;                                 
                                                  $tgl= date('d', strtotime($tanggal)); 
                                                  $bs= date('m', strtotime($tanggal));
                                                  if ($bs=="01"){
                                                    $bulans="Januari";
                                                  }
                                                  else if ($bs=="02"){
                                                    $bulans="Februari";
                                                  }
                                                  else if ($bs=="03"){
                                                    $bulans="Maret";
                                                  }
                                                  else if ($bs=="04"){
                                                    $bulans="April";
                                                  }
                                                  else if ($bs=="05"){
                                                    $bulans="Mei";
                                                  }
                                                  else if ($bs=="06"){
                                                    $bulans="Juni";
                                                  }
                                                  else if ($bs=="07"){
                                                    $bulans="Juli";
                                                  }
                                                  else if ($bs=="08"){
                                                    $bulans="Agustus";
                                                  }
                                                  else if ($bs=="09"){
                                                    $bulans="September";
                                                  }
                                                  else if ($bs=="10"){
                                                    $bulans="Oktober";
                                                  }
                                                  else if ($bs=="11"){
                                                    $bulans="November";
                                                  }
                                                  else if ($bs=="12"){
                                                    $bulans="Desember";
                                                  }
                                                  $tahun= date('Y', strtotime($tanggal));
                                                  $angka = number_format($b->jumlah_diajukan,0,"",".");
                                                  ?>
                                                  <td><center>{{ $tgl }} {{ $bulans }} {{ $tahun }}</center></td>
                                                  <td><center>Rp {{ $angka }},-</center></td>
                                                  <td><center><?php
                                                  function terbilang($angka) {
    // pastikan kita hanya berususan dengan tipe data numeric
                                                    $angka = (float)$angka;

    // array bilangan 
    // sepuluh dan sebelas merupakan special karena awalan 'se'
                                                    $bilangan = array(
                                                      '',
                                                      'satu',
                                                      'dua',
                                                      'tiga',
                                                      'empat',
                                                      'lima',
                                                      'enam',
                                                      'tujuh',
                                                      'delapan',
                                                      'sembilan',
                                                      'sepuluh',
                                                      'sebelas'
                                                    );

    // pencocokan dimulai dari satuan angka terkecil
                                                    if ($angka < 12) {
        // mapping angka ke index array $bilangan
                                                      return $bilangan[$angka];
                                                    } else if ($angka < 20) {
        // bilangan 'belasan'
        // misal 18 maka 18 - 10 = 8
                                                      return $bilangan[$angka - 10] . ' belas';
                                                    } else if ($angka < 100) {
        // bilangan 'puluhan'
        // misal 27 maka 27 / 10 = 2.7 (integer => 2) 'dua'
        // untuk mendapatkan sisa bagi gunakan modulus
        // 27 mod 10 = 7 'tujuh'
                                                      $hasil_bagi = (int)($angka / 10);
                                                      $hasil_mod = $angka % 10;
                                                      return trim(sprintf('%s puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
                                                    } else if ($angka < 200) {
        // bilangan 'seratusan' (itulah indonesia knp tidak satu ratus saja? :))
        // misal 151 maka 151 = 100 = 51 (hasil berupa 'puluhan')
        // daripada menulis ulang rutin kode puluhan maka gunakan
        // saja fungsi rekursif dengan memanggil fungsi terbilang(51)
                                                      return sprintf('seratus %s', terbilang($angka - 100));
                                                    } else if ($angka < 1000) {
        // bilangan 'ratusan'
        // misal 467 maka 467 / 100 = 4,67 (integer => 4) 'empat'
        // sisanya 467 mod 100 = 67 (berupa puluhan jadi gunakan rekursif terbilang(67))
                                                      $hasil_bagi = (int)($angka / 100);
                                                      $hasil_mod = $angka % 100;
                                                      return trim(sprintf('%s ratus %s', $bilangan[$hasil_bagi], terbilang($hasil_mod)));
                                                    } else if ($angka < 2000) {
        // bilangan 'seribuan'
        // misal 1250 maka 1250 - 1000 = 250 (ratusan)
        // gunakan rekursif terbilang(250)
                                                      return trim(sprintf('seribu %s', terbilang($angka - 1000)));
                                                    } else if ($angka < 1000000) {
        // bilangan 'ribuan' (sampai ratusan ribu
        $hasil_bagi = (int)($angka / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
        $hasil_mod = $angka % 1000;
        return sprintf('%s ribu %s', terbilang($hasil_bagi), terbilang($hasil_mod));
      } else if ($angka < 1000000000) {
        // bilangan 'jutaan' (sampai ratusan juta)
        // 'satu puluh' => SALAH
        // 'satu ratus' => SALAH
        // 'satu juta' => BENAR 
        // @#$%^ WT*

        // hasil bagi bisa satuan, belasan, ratusan jadi langsung kita gunakan rekursif
        $hasil_bagi = (int)($angka / 1000000);
        $hasil_mod = $angka % 1000000;
        return trim(sprintf('%s juta %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
      } else if ($angka < 1000000000000) {
        // bilangan 'milyaran'
        $hasil_bagi = (int)($angka / 1000000000);
        // karena batas maksimum integer untuk 32bit sistem adalah 2147483647
        // maka kita gunakan fmod agar dapat menghandle angka yang lebih besar
        $hasil_mod = fmod($angka, 1000000000);
        return trim(sprintf('%s miliar %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
      } else if ($angka < 1000000000000000) {
        // bilangan 'triliun'
        $hasil_bagi = $angka / 1000000000000;
        $hasil_mod = fmod($angka, 1000000000000);
        return trim(sprintf('%s triliun %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
      } else {
        return 'Wow...';
      }
    }

    if ($b->jumlah_diajukan)
    {
      echo ucwords(Terbilang($b->jumlah_diajukan))." Rupiah";
    }

    ?></center></td>
    <td><center><?php 
    if($b->periode_realisasi=='1'){ echo "TW I";}
    if($b->periode_realisasi=='2'){ echo "TW II";}
    if($b->periode_realisasi=='3'){ echo "TW III";}
    if($b->periode_realisasi=='4'){ echo "TW IV";}
    ?></center></td>
    <td><center>
      @if ($b->name=="") Tidak Ada
      @else 
      <a href="{{ URL('pengajuan_dropping/download/'. $b->id) }}" target="_blank">{{ $b->name }}</a>
      @endif
    </center></td>
    <td><center><?php
    if($b->kirim<>'2'){ 
      if($b->verifikasi=='1'){ echo "<div class=\"tag tag-success label-square\"><span><b>Diterima</b></span></div>";}
      if($b->verifikasi=='2'){ echo "<div class=\"tag tag-danger label-square\"><span><b>Ditolak</b></span></div>";}
    }
    ?></center></td>
    <td><center>
      @if ($b->kirim!=2)
      @if ($b->keterangan!="")
      <?php
      $second="SELECT * FROM reject_reasons where id=$b->keterangan";
      $return = DB::select($second);
      ?>
      @foreach($return as $bb)
      <?php
      if($bb->type==6){
        $type="Reject pengajuan dropping oleh staff Akuntansi (lv1)";
      }
      if($bb->type==7){
        $type="Reject pengajuan dropping oleh kabid Akuntansi (lv2)";
      }
      if($bb->type==8){
        $type="Reject pengajuan dropping oleh kadiv Akuntansi (lv3)";
      }

      ?>
      {{ $bb->content }} - {{ $type }}
      @endforeach
      @endif
      @endif
    </center></td>
    <td><center>
      @if ($b->kirim==1)
      @if ($userCab)
      <span data-toggle='tooltip' title='Kirim'><a class="btn btn-success btn-sm" data-target="#kirim{{$b->id}}" data-toggle="modal"><i class="fa fa-send"></i> </a></span>
      <span data-toggle='tooltip' title='Ubah'><a class="btn btn-info btn-sm" data-target="#ubah{{$b->id}}" data-toggle="modal"><i class="fa fa-edit"></i> </a></span>
      <span data-toggle='tooltip' title='Hapus'><a class="btn btn-danger btn-sm" data-target="#hapus{{$b->id}}" data-toggle="modal"><i class="fa fa-trash"></i> </a></span>
      @endif
      @elseif ($b->kirim==2)
      <div class="btn btn-info btn-sm"><span><b>Telah Dikirim</b></span></div>
      @elseif ($b->kirim==4)
      <div class="btn btn-success btn-sm"><span><b>Telah Diterima</b></span></div>
      @endif
      <div class="modal fade" data-backdrop="static" id="kirim{{$b->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <center><h4 class="modal-title text-primary" id="myModalLabel" ><i class="fa fa-send"></i> Dialog Konfirmasi</h4></center>
            </div>
            <div class="modal-body">
              <center><h4>Anda yakin ingin mengirim pengajuan dropping ?</h4></center>
            </div>
            <div class="modal-footer">
              <a href="{{ URL('pengajuan_dropping/kirim/'. $b->id) }}"" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Ya</a>
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" data-backdrop="static" id="hapus{{$b->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title text-warning" id="myModalLabel" ><i class="fa fa-warning"></i> Peringatan !</h4>
            </div>
            <div class="modal-body">
              <h4>Anda yakin ingin menghapus Pengajuan Dropping <br><span class=text-danger>{{ $b->kantor_cabang }}</span> ?</h4>
            </div>
            <div class="modal-footer">
              <a href="{{ URL('pengajuan_dropping/delete_pengajuandropping/'. $b->id) }}"" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Ya</a>
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
            </div>
          </div>
        </div>
      </div>

    </center></td>
  </tr>
  <div class="modal fade" data-backdrop="static" id="ubah{{$b->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <center><h4 class="modal-title text-info" id="myModalLabel" ><i class="fa fa-edit"></i> Ubah Pengajuan Dropping</h4></center>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" role="form" action="{{ URL('pengajuan_dropping/update_pengajuandropping/'. $b->id) }}" method="POST" >
            {{ csrf_field() }}
            <input type="hidden" name="id"  value="{{$b->id}}" />
            <label class="control-label"><b> Kantor Cabang </b></label>
            <label class="control-label"> : </label><br>
            <select class="select2 form-control block" name="kantor_cabang" style="width:300px" required="required" value="{{$b->kantor_cabang}}">
              <option value="0"> - Pilih Kantor Cabang - </option>
              <?php
              $second="SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_KPKC]  WHERE VALUE!='00'";
              $return = DB::select($second);
              ?>
              @foreach($return as $bq)
              <option value="{{ $bq->DESCRIPTION }}"
                @if($bq->DESCRIPTION == $b->kantor_cabang) Selected>{{ $bq->DESCRIPTION}} @endif
                @if($bq->DESCRIPTION <> $b->kantor_cabang)>{{ $bq->DESCRIPTION}} @endif
              </option> 
              @endforeach
            </select><br><br>
            <label class="control-label"><b> Nomor </b></label>
            <label class="control-label"> : </label>
            <input class="form-control" type="text" name="nomor" placeholder="masukkan nomor" required="required" value="{{$b->nomor}}">
            <br>
            <label class="control-label"><b> Tanggal </b></label>
            <label class="control-label"> : </label>
            <input class="form-control" type="date" name="tanggal" required="required" value="{{$b->tanggal}}">  
            <br> 
            <label class="control-label"><b> Jumlah Diajukan </b></label>
            <label class="control-label"> : </label>
            <input class="form-control" type="text" name="jumlah_diajukan" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="masukkan jumlah diajukan" required="required" value="{{$angka}}">  
            <br>
            <label class="control-label"><b> Periode Realiasi </b></label>
            <label class="control-label"> : </label>
            <select class="select form-control" name="periode_realisasi" required="required" >
              <option value="">Pilih Periode Realisasi</option>
              <option value="1" @if ($b->periode_realisasi=="1")Selected @endif>TW I</option>
              <option value="2" @if ($b->periode_realisasi=="2")Selected @endif>TW II</option>  
              <option value="3" @if ($b->periode_realisasi=="3")Selected @endif>TW III</option>
              <option value="4" @if ($b->periode_realisasi=="4")Selected @endif>TW IV</option>                                                 
            </select>   
            <br>
            <label class="control-label"><b> Lampiran </b></label>
            <label class="control-label"><b> : </b></label>
            <input class="form-control" type="file" name="inputs"/>
            @if ($b->name!="")
            <p class="help-block">*Kosongkan jika tidak ingin mengganti lampiran.</br> Lampiran Lama = {{ $b->name }}.</p>
            @endif  
          </div>
          <div class="modal-footer">
            <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Ubah</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php $no++;?>
  @endforeach
  @endif
</tbody>
</table>

</div>
</div>
</div>
</div>
</div>
</div>
</section>
</div>
</div>
@endsection

@section('customjs')
<!-- BEGIN PAGE VENDOR JS-->
<script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
<script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script> 
<script src="{{ asset('app-assets/vendors/js/tables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"
type="text/javascript"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"
type="text/javascript"></script>
<script type="text/javascript">



  $('.datatable-select-inputs').DataTable( {
    scrollX: true,
    "language": {
      "paginate": {
        "previous": "Sebelumnya",
        "next": "Selanjutnya"
      },

      "emptyTable":  "Silahkan pilih kantor cabang dan tanggal",
      "info":  "Menampilkan _START_-_END_ dari _TOTAL_ Data",
      "infoEmpty":  "Menampilkan 0-0 dari _TOTAL_ Data ",
      "search": "Pencarian:",
      "lengthMenu": "Perlihatkan _MENU_ masukan",
      "infoFiltered": "(telah di filter dari _MAX_ total masukan)",
      "zeroRecords": "Tidak ada data ditemukan"
    },
    initComplete: function () {
      this.api().columns('#filterable').every( function () {
        var column = this;
        var select = $('<select><option value="">Filter kolom</option></select>')
        .appendTo( $(column.footer()).empty() )
        .on( 'change', function () {
          var val = $.fn.dataTable.util.escapeRegex(
            $(this).val()
            );

          column
          .search( val ? '^'+val+'$' : '', true, false )
          .draw();
        } );

        column.data().unique().sort().each( function ( d, j ) {
          select.append( '<option value="'+d+'">'+d+'</option>' );
        } );
      } );
    }
  } );


  function tandaPemisahTitik(b){
    var _minus = false;
    if (b<0) _minus = true;
    b = b.toString();
    b=b.replace(".","");
    b=b.replace("-","");
    c = "";
    panjang = b.length;
    j = 0;
    for (i = panjang; i > 0; i--){
      j = j + 1;
      if (((j % 3) == 1) && (j != 1)){
        c = b.substr(i-1,1) + "." + c;
      } else {
        c = b.substr(i-1,1) + c;
      }
    }
    if (_minus) c = "-" + c ;
    return c;
  }

  function numbersonly(ini, e){
    if (e.keyCode>=49){
      if(e.keyCode<=57){
        a = ini.value.toString().replace(".","");
        b = a.replace(/[^\d]/g,"");
        b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
        ini.value = tandaPemisahTitik(b);
        return false;
      }
      else if(e.keyCode<=105){
        if(e.keyCode>=96){
                        //e.keycode = e.keycode - 47;
                        a = ini.value.toString().replace(".","");
                        b = a.replace(/[^\d]/g,"");
                        b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
                        ini.value = tandaPemisahTitik(b);
                        //alert(e.keycode);
                        return false;
                      }
                      else {return false;}
                    }
                    else {
                      return false; }
                    }else if (e.keyCode==48){
                      a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
                      b = a.replace(/[^\d]/g,"");
                      if (parseFloat(b)!=0){
                        ini.value = tandaPemisahTitik(b);
                        return false;
                      } else {
                        return false;
                      }
                    }else if (e.keyCode==95){
                      a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
                      b = a.replace(/[^\d]/g,"");
                      if (parseFloat(b)!=0){
                        ini.value = tandaPemisahTitik(b);
                        return false;
                      } else {
                        return false;
                      }
                    }else if (e.keyCode==8 || e.keycode==46){
                      a = ini.value.replace(".","");
                      b = a.replace(/[^\d]/g,"");
                      b = b.substr(0,b.length -1);
                      if (tandaPemisahTitik(b)!=""){
                        ini.value = tandaPemisahTitik(b);
                      } else {
                        ini.value = "";
                      }

                      return false;
                    } else if (e.keyCode==9){
                      return true;
                    } else if (e.keyCode==17){
                      return true;
                    } else {
                        //alert (e.keyCode);
                        return false;
                      }

                    }
                  </script>

                  @endsection