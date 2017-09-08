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
                                            <option value="1">2017</option>
                                          </select>
                                        </div>
                                    </div>

                                    
                                    <div class="col-xs-5">
                                        <div class="form-group">
                                          <label>Unit Kerja</label>
                                          <select class="select2 form-control " name="cari_unit_kerja" id="cari_unit_kerja">
                                            <option value="0">None</option>
                                          </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-5">
                                        <div class="form-group">
                                          <label>Kategori</label>
                                          <select class="select2 form-control" name="cari_kategori" id="cari_kategori">
                                            <option value="Semua">Semua Kategori</option>
                                          </select>
                                        </div>
                                    </div>
                                  </div>

                                  <div class="row col-xs-12">
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                          <label>Kata Kunci</label>
                                          <input id="cari_query" name="cari_query" class="form-control">
                                          
                                        </div>
                                    </div>
                                    <div class="col-xs-2" >
                                      <div class="form-group">
                                          <label style="visibility:hidden">Kata Kunci</label>
                                          <a href="{{ url('anggaran/edit/123/1') }}" class="btn btn-primary"><i class="fa fa-search"></i> Cari</a>                                            
                                      </div>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="card">
                            <div class="card-header">
                              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block">
                                  <form method="POST" action="{{url('anggaran/submit/tambah') }}" id="insertAnggaran" name="insertAnggaran" enctype="multipart/form-data">
                                  <div class="row">

                                    <div class="col-xs-12">
                                      {{ csrf_field() }}
                                      <div class="col-xs-2">
                                          <div class="form-group">
                                            <label>Tahun</label>
                                            <input id="tanggal" name="tanggal" class="form-control" value="<?php echo  date("Y");?>" readonly>
                                            
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
                                        <button type="submit" class="btn btn-secondary"><i class="fa fa-download"></i> Unduh</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                </form>
                            </div>
                        </div>
                      </div>
                    </section>
                    <!-- Basic scenario end -->
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
                              url:"{{ (checkActiveMenu('anggaran') == 'active' ? url('anggaran') : url('anggaran/get/filteredHistory') ) }}",
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
                            title: "Jenis", 
                            width: 90
                          },
                          { name: "kelompok", 
                            type: "text", 
                            title: "Kelompok", 
                            width: 90
                          },
                          { name: "pos_anggaran", 
                            type: "text", 
                            title: "Pos Anggaran", 
                            width: 120
                          },
                          { name: "sub_pos", 
                            type: "text", 
                            title: "Sub Pos", 
                            width: 70
                          },
                          { name: "mata_anggaran", 
                            type: "text", 
                            title: "Mata Anggaran",
                            width: 130
                          },
                          { name: "input_anggaran", 
                            type: "number", 
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
                              var name_file = "";
                              var id_list;
                              var status = false;

                              if(value.length > 0){

                                for(j = 0;j<value.length;j++){
                                  name_file+=(j+1)+". "+value[j]["name"]+"<br /> ";
                                  if(value[j]['id_list_anggaran']!=null){
                                    id_list = value[j]['id_list_anggaran'];
                                  }
                                }
                              }
                              // if(status)
                              return "<span > <a class='btn btn-primary' href='{{url('anggaran/get/download')}}/"+id_list+"' >Unduh Berkas</a>:<br /> </span>";
                              
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
                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/attributes/unitkerja/1') }}",
                        'success': function (data) {

                          unit_kerja = document.getElementById('cari_unit_kerja');

                         
                          for(i =0 ;i<data.length;i++){
                            var value = "";
                            var desc = data[i].DESCRIPTION;
                            if(desc.split("Cabang").length > 0 ){
                              value = data[i].VALUE+"00";
                            }else{
                              value = "00"+data[i].VALUE;
                            }
                            unit_kerja.options[unit_kerja.options.length] = new Option(desc, value);
                          }
                             
                        }
                    });
                  }

                  window.setUnitKerja();


                </script>
                @endsection