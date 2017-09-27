                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <style type="text/css">
                  .hide {
                    display: none;
                  }
                </style>
                @endsection

                @section('content')
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">{{$title}}</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index-2.html">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{$title}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body"><!-- Basic scenario start -->
                    <section id="basic">
                      <div class="row">
                        <div class="card">
                          <form method="POST" action="{{url('anggaran/riwayat') }}" id="filterAnggaran" name="filterAnggaran" >
                            <div class="card-header">
                              <h4 class="card-title">Pencarian Riwayat Anggaran dan Kegiatan</h4>
                              <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                              <div class="card-block ">
                                <form method="POST" action="">
                                  <div class="row col-xs-12">
                                    {{ csrf_field() }}
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                          <label>Tahun</label>
                                          <select class="select2 form-control" name="cari_tahun" id="cari_tahun">
                                            <option value="0">Semua Tahun</option>
                                            <option value="2017">2017</option>
                                            <option value="2016">2016</option>
                                            <option value="2015">2015</option>
                                          </select>
                                        </div>
                                    </div>

                                    
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                          <label>Unit Kerja</label>
                                          <select class="select2 form-control " name="cari_unit_kerja" id="cari_unit_kerja" onchange="setNDSurat()">
                                            <option value="0">None</option>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                          <label>ND/Surat</label>
                                          <select class="select2 form-control" name="cari_nd_surat" id="cari_nd_surat">
                                           
                                          </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-3">
                                        <div class="form-group">
                                          <label>Kategori</label>
                                          <select class="select2 form-control" name="cari_kategori" id="cari_kategori">
                                            <option value="semua">Semua Kategori</option>
                                            <option value="jenis">Jenis</option>
                                            <option value="kelompk">Kelompok</option>
                                            <option value="pos_anggaran">Pos Anggaran</option>
                                            <option value="sub_pos">Sub Pos</option>
                                            <option value="mata_anggaran">Mata Anggaran</option>
                                          </select>
                                        </div>
                                    </div>
                                  </div>

                                  <div class="row col-xs-12">
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                          <label>Kata Kunci</label>
                                          <input id="cari_keyword" name="cari_keyword" class="form-control">
                                          
                                        </div>
                                    </div>
                                    <div class="col-xs-2" >
                                      <div class="form-group">
                                          <label style="visibility:hidden">Kata Kunci</label>
                                          <div onclick="cariRiwayat()" id="cari_button" name="cari_button" class="btn btn-primary"><i class="fa fa-search"></i> Cari</div>
                                      </div>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                      <div class="row">
                        <div class="card">
                            <div class="card-header">
                              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block">
                                  <div class="row">

                                    <div class="col-xs-12">
                                      {{ csrf_field() }}
                                      <div class="col-xs-2">
                                          <div class="form-group">
                                            <label>Tahun</label>
                                            <input id="tahun" name="tahun" class="form-control" value="" readonly>
                                            
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-group">
                                            <label>Unit Kerja</label>
                                            <input id="unit_kerja" name="unit_kerja" class="form-control" readonly>
                                              
                                          </div>
                                      </div>
                                    </div>
                                  <div class="col-xs-12">
                                    <input type="hidden" name="list_anggaran_values" id="list_anggaran_values">
                                    <div id="file_grid"></div>
                                      <!-- <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p> -->
                                    <div class="col-xs-12">
                                      <div id="basicScenario"></div>
                                    </div>
                                  </div>

                                  
                                  <div class="row col-xs-12" style="display:block">
                                    <br />
                                    <div class="pull-right">
                                      <div class="form-group">
                                        <a type="submit" class="btn btn-secondary"><i class="fa fa-download"></i> Unduh</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                            </div>
                        </div>
                      </div>
                    </section>
                    <!-- Basic scenario end -->
                </div>

                <div class="modal fade text-xs-left" id="modal_berkas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20"
                aria-hidden="true">
                  <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel20">Unduh Berkas</h4>
                      </div>
                      <div class="modal-body" id="confirmation-msg">
                        <div class="row">
                          <div class="col-md-12" id="list_file">

                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                       </div>
                    </div>
                  </div>
                </div>
                @endsection

                @section('customjs')
                <!-- BEGIN PAGE VENDOR JS-->
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
                <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/griddata.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                {{-- <script src="{{ asset('app-assets/js/scripts/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script> --}}
                <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE LEVEL JS-->
                <script type="text/javascript">
                  var list_berkas = [];
                  var count_file=0;
                  $(document).ready(function() {

                    $("#basicScenario").jsGrid( {
                      width: "100%",
               
                      sorting: true,
                      paging: true,
                      autoload: true,

                      editing: false,
                      inserting: false,
                      pageSize: 5,
                      pageButtonCount: 10,

                      controller: {
                        loadData: function(filter) {
                          return $.ajax({
                              type: "GET",
                              url:"{{ (checkActiveMenu('anggaran') == 'active' ? url('anggaran') : url('anggaran/get/filteredHistory/'.$filters['tahun'].'/'.$filters['nd_surat'].'/'.$filters['kategori'].'/'.urlencode(strtolower($filters['keyword'])) ) ) }}",
                              data: filter,
                              dataType: "JSON"
                          })
                        },
                      }, 
                      fields: [
                          {
                            name: "id",
                            css: "hide",
                            width: 0,

                          },
                          { name: "jenis", 
                            type: "text",
                            align: "left", 
                            title: "Jenis", 
                            width: 90
                          },
                          { name: "kelompok", 
                            type: "text",
                            align: "left", 
                            title: "Kelompok", 
                            width: 90
                          },
                          { name: "pos_anggaran", 
                            type: "text", 
                            align: "left",
                            title: "Pos Anggaran", 
                            width: 120
                          },
                          { name: "sub_pos", 
                            type: "text", 
                            align: "left",
                            title: "Sub Pos", 
                            width: 70
                          },
                          { name: "mata_anggaran", 
                            type: "text", 
                            align: "left",
                            title: "Mata Anggaran",
                            width: 130
                          },
                          { name: "input_anggaran", 
                            type: "number", 
                            align: "left",
                            title: "Input Anggaran dan kegiatan",
                            width: 220,
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              if(parseInt(value).toLocaleString() < 1){
                                display = "<span >---</span>";
                              }
                              return display;
                            }
                          },
                          { name: "clearing_house", 
                            type: "number", 
                            align: "left",
                            title: "Clearing House",
                            width: 130,
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              if(parseInt(value).toLocaleString() < 1){
                                display = "<span >---</span>";
                              }
                              return display;
                            }
                          },
                          { name: "naskah_rkap", 
                            type: "number", 
                            align: "left",
                            title: "Naskah RKAP",
                            width: 130,
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              if(parseInt(value).toLocaleString() < 1){
                                display = "<span >---</span>";
                              }
                              return display;
                            }
                          },
                          { name: "dewan_komisaris", 
                            type: "number", 
                            align: "left",
                            title: "Persetujuan Dewan Komisaris",
                            width: 220,
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              if(parseInt(value).toLocaleString() < 1){
                                display = "<span >---</span>";
                              }
                              return display;
                            }
                          },
                          { name: "rapat_teknis", 
                            type: "number", 
                            align: "left",
                            title: "Rapat Teknis",
                            width: 130,
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              if(parseInt(value).toLocaleString() < 1){
                                display = "<span >---</span>";
                              }
                              return display;
                            }
                          },
                          { name: "rups", 
                            type: "number", 
                            align: "left",
                            title: "RUPS",
                            width: 130,
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              if(parseInt(value).toLocaleString() < 1){
                                display = "<span >---</span>";
                              }
                              return display;
                            }
                          },
                          { name: "finalisasi_rups", 
                            type: "number", 
                            align: "left",
                            title: "Finalisasi RUPS",
                            width: 130,
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              if(parseInt(value).toLocaleString() < 1){
                                display = "<span >---</span>";
                              }
                              return display;
                            }
                          },
                          { name: "risalah_rups", 
                            type: "number", 
                            align: "left",
                            title: "Risalah RUPS",
                            width: 130,
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              if(parseInt(value).toLocaleString() < 1){
                                display = "<span >---</span>";
                              }
                              return display;
                            }
                          },
                          { name: "file", align:"center", title: "Berkas",  width: 150 ,

                            itemTemplate: function(value) {
                              // var index = count_file;
                              // list_berkas[index]=value;
                              // alert(value.length)
                              id_list=count_file;
                              for(i =0;i<value.length;i++){
                                id_list = value[i]['count'];
                                // alert(value[i]['count']);
                              }
                              list_berkas[id_list]=[];
                              list_berkas[id_list]=value;
                              var button = "<span class='btn btn-primary' onclick='setBerkas("+id_list+")' >Unduh Berkas</span>";
                              count_file++;
                              return button;
                              
                            }
                          }
                      ]
                    })
                    
                  });

                  function getData(type) {
                    var returned = function () {
                        var tmp = null;
                        $.ajax({
                            'async': false, 'type': "GET", 'dataType': 'JSON', 
                            'url': "{{ url('anggaran/get/attributes') }}/" +type+"/-1",
                            'success': function (data) {
                                tmp = data;
                            }
                        });
                        return tmp;
                    }();
                    return returned;
                  }
                  
                  function setUnitKerja(){

                    // $("select").select2({
                    //   tags: "true",
                    //   placeholder: "Selectn",
                    //   allowClear: true
                    // });
                    var tahun = '{{$filters["tahun"]}}';
                    if(tahun == '0'){
                      tahun = '2015 sampai 2017';
                    }
                    document.getElementById('tahun').value = tahun;
                    document.getElementById('unit_kerja').value = '{{$filters["unit_kerja"]}}';
                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/attributes/unitkerja/1') }}",
                        'success': function (data) {

                          unit_kerja = document.getElementById('cari_unit_kerja');

                         
                          for(i =0 ;i<data.length;i++){
                            var value = "";
                            var desc = data[i].DESCRIPTION;
                            value = data[i].DESCRIPTION;
                            unit_kerja.options[unit_kerja.options.length] = new Option(desc, value);
                          }
                             
                        }
                    });
                  }

                  
                  function setNDSurat(){

                     unit_kerja = document.getElementById('cari_unit_kerja').value;
                    // alert('<?php echo urlencode(strtolower('+unit_kerja+')) ?>');
                    // alert("{{ url('anggaran/get/attributes/nd_surat').'/'}}"+encodeURI(unit_kerja));
                    // unit_kerja = document.getElementById('cari_unit_kerja').value;

                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/attributes/nd_surat').'/'}}"+ encodeURI(unit_kerja),
                        'success': function (data) {

                          nd_surat = document.getElementById('cari_nd_surat');

                         
                          for(i =0 ;i<data.length;i++){
                            var value = "";
                            var desc = data[i].nd_surat;
                            value = data[i].nd_surat;
                            nd_surat.options[nd_surat.options.length] = new Option(desc, value);
                          }
                             
                        }
                    });
                  }

                  function setBerkas(index) {
                    $('#list_file').empty();
                    var name="";
                      for(i = 0; i<list_berkas[index].length; i++){
                        link = "{{url('anggaran/get/download')}}/"+list_berkas[index][i]['id'];
                        name += '<div class="col-xs-10"><a href="'+link+'" >'+list_berkas[index][i]['name']+'</div>';
                        name += '<div class="col-xs-2"><i class="fa fa-download "></i></div></a><br/><br/>';
                      }

                     $("#list_file").append(name);


                      $('#modal_berkas').modal('show');
                  };

                  function cariRiwayat(){
                    // if(document.getElementById("cari_keyword").value==""){
                    //   toastr.error("Silahkan Isi Kata Kunci Pencarian. Terima kasih.", "Kata Kunci Pencarian Kosong.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    // }else 
                    if(document.getElementById("cari_unit_kerja").value=="0"){
                      toastr.error("Silahkan Pilih Salah Satu Unit Kerja. Terima kasih.", "Unit Kerja Belum Dipilih.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    }else{
                      $('form[id="filterAnggaran"]').submit();
                    }
                    // alert(document.getElementById("cari_nd_surat").value);
                  }

                  window.setUnitKerja();
                  // window.setNDSurat();


                </script>
                @endsection