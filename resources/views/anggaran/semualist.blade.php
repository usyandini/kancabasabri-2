                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/checkboxes-radios.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/custom.css') }}">
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
                <h3 class="content-header-title mb-0">Anggaran dan Kegiatan</h3>
                <div class="row breadcrumbs-top">
                  <div class="breadcrumb-wrapper col-xs-12">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="#">Anggaran dan Kegiatan</a>
                      </li>
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
                        <h4 class="card-title">Pencarian Persetujuan</h4>
                        <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                      </div>
                      <div class="card-body collapse in">
                        <div class="card-block">
                          <form enctype="multipart/form-data" role="form" action="{{ URL('anggaran/semualist/cari') }}" method="GET" >
                                <div class="row">
                            {{ csrf_field() }}
                              <div class="col-xs-2">
                                <div class="form-group">
                                <label>Tahun</label><br>
                                <select class="select2 form-control block" name="tahun" required="required">
                                  <option value=""> - Pilih Tahun - </option>
                                  <?php
                                    $thn_skr = date('Y');
                                    for($x=$thn_skr; $x >= 2015; $x--){
                                      echo "<option value=$x> $x </option>";
                                    }
                                  ?>
                                </select>
                                </div>
                              </div>
                              <div class="col-xs-4">
                                <div class="form-grpup">
                                  <label>Persetujuan</label><br>
                                  <select class="select2 form-control block" name="persetujuan" required="required">
                                    <option value=""> - Pilih Persetujuan - </option>
                                    @if(Gate::check('setuju_iia'))<option value="2"> Persetujuan Kadiv Renbang </option>@endif
                                    @if(Gate::check('setuju_iiia'))<option value="3"> Persetujuan Direksi </option>@endif
                                    @if(Gate::check('setuju_iva'))<option value="4"> Persetujuan Dekom </option>@endif
                                    @if(Gate::check('setuju_va'))<option value="5"> Persetujuan Ratek </option>@endif
                                    @if(Gate::check('setuju_via'))<option value="6"> Persetujuan RUPS </option>@endif
                                    @if(Gate::check('setuju_viia'))<option value="7"> Persetujuan FinRUPS </option>@endif
                                    @if(Gate::check('setuju_viiia'))<option value="8"> Persetujuan Risalah RUPS </option>@endif
                                  </select>
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
                    
                  </div>
                </div>
              </div>


              <div class="row">
                <section id="select-inputs">
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">Daftar Anggaran dan Kegiatan</h4></br>
                          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                          <div class="card-body collapse in">                     
                            
                          </div>
                          <div class="card-body collapse in">                     
                            <div class="card-block">
                              @if(session('success'))
                              <div class="alert alert-success">
                                {!! session('success') !!}
                              </div>
                              @endif
                              
                              <form enctype="multipart/form-data" action="{{ url('anggaran/semualist/verifikasi') }}" method="POST" >
                              
                              {{ csrf_field() }}
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered datatable-select-inputs mb-0">
                                  <thead>
                                    <tr>
                                      <th><center>No</center></th>
                                      <th id="filterable"><center>&nbsp;&nbsp;&nbsp;Tanggal&nbsp;&nbsp;&nbsp;</center></th>
                                      <th id="filterable"><center>ND/Surat</center></th>
                                      <th id="filterable"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit Kerja&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                      <th id="filterable"><center>Tipe Anggaran</center></th>
                                      <th id="filterable"><center>Persetujuan</center></th>
                                      <th id="filterable"><center>Detail</center></th>
                                      <th>
                                        <div class="skin skin-flat">
                                         <input type="checkbox" id="check" name="check">
                                        </div>
                                      </th>
                                      <!-- <th>
                                        <div class="skin skin-flat">
                                          Terima
                                         <input type="checkbox" id="terima_all" name="check">
                                        </div>
                                      </th>
                                      <th>
                                        <div class="skin skin-flat">
                                          Tolak
                                         <input type="checkbox" id="tolak_all" name="check">
                                        </div>
                                      </th> -->
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $no='1';
                                    $nol='0';?>
                                    @if(count($a))
                                    @foreach($a as $b)
                                    <tr>
                                      <td><center>{{ $no }}</center></td>
                                      <td>{{ date('d-m-Y', strtotime($b->tanggal)) }}</td>
                                      <td><center>{{ $b->nd_surat }}</center></td>
                                      <td><center>{{ $b->unit_kerja }}</center></td>
                                      <td><center>{{ $b->tipe_anggaran }}</center></td>
                                      <td><center>@if ($b->persetujuan==2) Persetujuan Kadiv Renbang 
                                                  @elseif ($b->persetujuan==3) Persetujuan Direksi
                                                  @elseif ($b->persetujuan==4) Persetujuan Dekom
                                                  @elseif ($b->persetujuan==5) Persetujuan Ratek
                                                  @elseif ($b->persetujuan==6) Persetujuan RUPS
                                                  @elseif ($b->persetujuan==7) Persetujuan FinRUPS
                                                  @elseif ($b->persetujuan==8) Persetujuan Risalah RUPS
                                                  @else Disetujui dan Ditandatangani @endif</center></td>
                                      <td><center><a href="{{ url('anggaran/edit/'. $b->nd_surat)}}" target="_blank" class='btn btn-sm btn-primary'> Detail</a></center></td>
                                      <td><center>
                                        
                                        <div class="skin skin-flat" id="check">
                                          <input type="hidden" name="cek[{{$nol}}]" value="n">
                                          <input type="checkbox" name="cek[{{$nol}}]" value="y">
                                          
                                        </div>
                                        <input type="hidden" name="id[]" value="{{$b->id}}">
                                        <input type="hidden" name="nd_surat[]" value="{{$b->nd_surat}}">
                                        <input type="hidden" name="status_anggaran[]" value="{{$b->status_anggaran}}">
                                        <input type="hidden" name="persetujuan[]" value="{{$b->persetujuan}}">
                                      </center></td>
                                      
                                    </tr>
                                    
                                    <?php $no++;
                                    $nol++;?>
                                    @endforeach
                                    @endif
                                  </tbody>
                                </table>
                                <br>
                                <div class="form-group" align="right">
                                  <span><a class="btn btn-outline-success" data-target="#terima" data-toggle="modal"><i class="fa fa-check"></i> Terima</a></span>
                                  <span><a class="btn btn-outline-danger" data-target="#tolak" data-toggle="modal"><i class="fa fa-times"></i> Tolak</a></span>
                                </div>
                                        <div class="modal fade" data-backdrop="static" id="terima" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <center><h4 class="modal-title text-primary" id="myModalLabel" ><i class="fa fa-send"></i> Dialog Konfirmasi</h4></center>
                                              </div>
                                              <div class="modal-body">
                                                <center><h4>Anda yakin ingin Menerima ?</h4></center>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="submit" name="terima" class="btn btn-success"><i class="fa fa-check"></i> Terima</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="modal fade" data-backdrop="static" id="tolak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <center><h4 class="modal-title text-primary" id="myModalLabel" ><i class="fa fa-send"></i> Dialog Konfirmasi</h4></center>
                                              </div>
                                              <div class="modal-body">
                                                <center><h4>Anda yakin ingin Menolak ?</h4></center>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="submit" name="tolak" class="btn btn-success"><i class="fa fa-check"></i> Tolak</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                              </div>
                              </form>
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
             
              <!-- BEGIN PAGE VENDOR JS-->
              <script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
              <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
              <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script>
              <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/griddata.js') }}" type="text/javascript"></script>
              <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}" type="text/javascript"></script>
              <!-- END PAGE VENDOR JS-->
              <!-- BEGIN PAGE LEVEL JS-->
              <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
              <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script>
              <script src="{{ asset('app-assets/js/scripts/forms/checkbox-radio.min.js') }}" type="text/javascript"></script>
               <script type="text/javascript">
                        
                $('.datatable-select-inputs').DataTable( {
                  scrollX: true,
                  "language": {
                    "paginate": {
                      "previous": "Sebelumnya",
                      "next": "Selanjutnya"
                    },

                    "emptyTable":  "Tidak Ada Data Tersimpan",
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

                $('input').iCheck({
                  checkboxClass: 'icheckbox_flat-green',
                    increaseArea: '20%' // optional
                  });

                $('input[name="check"]').on('ifClicked', function (event) {
                   checkAll(this) 
                });
                function checkAll(e) {
                  var id_1 = $(e).attr('id');
                  var id_2 = "check"
                  if(id_1 == id_2){
                    id_2 = "tolak_all";
                  }
                  if ($(e).is(':checked')) {
                    $('#' +id_1+ ' input').iCheck('uncheck')
                    // $('#' +id_2+ ' input').iCheck('check')
                    // $('#' +id_2).iCheck('check')
                  } else {
                    $('#' +id_1+ ' input').iCheck('check')
                    $('#' +id_2+ ' input').iCheck('uncheck')
                    $('#' +id_2).iCheck('uncheck')
                  }
                }
                
              </script>
              @endsection