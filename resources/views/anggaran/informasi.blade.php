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
                        <div>
                            <div class="card">
                                <div class="card-header">
                                  <h4 class="card-title">Pencarian Anggaran dan Kegiatan</h4>
                                  <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                                </div>
                                <div class="card-body collapse in">
                                  <div class="card-block ">
                                    <form method="POST" action="{{url('anggaran/cari') }}" id="filterAnggaran" name="filterAnggaran" >
                                      <div class="row">
                                        {{ csrf_field() }}
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                              <label>ND/Surat</label>
                                               <select class="select2 form-control " name="cari_nd_surat" id="cari_nd_surat">
                                              </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                              <label>Status Anggaran</label>
                                              <select class="select2 form-control" name="cari_stat_anggaran" id="cari_stat_anggaran">
                                                <option value="0">Semua</option>
                                                <option value="1">Draft</option>
                                                <option value="2">Transfer</option>
                                                <option value="3">Complate</option>
                                              </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                              <label>Unit Kerja</label>
                                              <select class="select2 form-control " name="cari_unit_kerja" id="cari_unit_kerja">
                                                <option value="0">none</option>
                                              </select>
                                            </div>
                                        </div>
                                      </div>
                                      <div>
                                          <div class="col-xs-1">
                                              <div class="btn btn-primary" onclick="cariAnggaran()"><i class="fa fa-search"></i> Cari</div>                                            
                                          </div>
                                          <div class="col-xs-2" >
                                              <a href="{{ url('anggaran/tambah') }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>                                   
                                          </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header"></div>
                            <div class="card-body collapse in">
                              <div class="card-block ">
                                <div id="basicScenario"></div>
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
               
                      pageSize: 5,
                      pageButtonCount: 10,

                      controller: {
                        loadData: function(filter) {
                          return $.ajax({
                              type: "GET",
                              url:"{{ (checkActiveMenu('anggaran') == 'active' ? url('anggaran') : url('anggaran/get/filteredAnggaran/'.$filters['nd_surat'].'/'.$filters['status_anggaran'].'/'.urlencode(strtolower($filters['unit_kerja']))) ) }}",
                              data: filter,
                              dataType: "JSON"
                          })
                        },
                      }, 
                      onRefreshed: function(args) {
                        var items = args.grid.option("data");
                        items.forEach(function(item) {
                          // totalRows += 1;

                        });
                      },
                      fields: [
                          {
                            name: "id",
                            css: "hide",
                            type: "number", 
                            width: 0
                          },
                          { name: "tanggal", 
                            type: "text", 
                            align: "left",
                            title: "Tanggal", 
                            width: 90
                          },
                          { name: "nd_surat", 
                            type: "text", 
                            align: "left",
                            title: "ND/Surat", 
                            width: 90
                          },
                          { name: "unit_kerja", 
                            type: "text", 
                            align: "left",
                            title: "Unit Kerja", 
                            width: 100
                          },
                          { name: "tipe_anggaran", 
                            type: "text", 
                            align: "left",
                            title: "Tipe Anggaran", 
                            width: 100
                          },
                          { name: "status_anggaran", 
                            type: "text", 
                            align: "left",
                            title: "Status Anggaran", 
                            width: 100,
                            itemTemplate:function(value){
                              var status_anggaran = "";
                              switch(value){
                                case "1" : status_anggaran="Draft";break;
                                case "2" : status_anggaran="Transfer";break;
                                case "3" : status_anggaran="Complete";break;
                              }
                              return status_anggaran;
                            }
                          },
                          { name: "persetujuan", 
                            type: "text", 
                            align: "left",
                            title: "Persetujuan", 
                            width: 100,
                            itemTemplate:function(value){
                              var persetujuan = "";
                              switch(value){
                                  case "-1" : persetujuan="";break;
                                  case "0" : persetujuan="Kirim";break;
                                  case "1" : persetujuan="Persetujuan Kanit Kerja";break;
                                  case "2" : persetujuan="Persetujuan Renbang";break;
                                  case "3" : persetujuan="Persetujuan Direksi";break;
                                  case "4" : persetujuan="Persetujuan Dekom";break;
                                  case "5" : persetujuan="Persetujuan Ratek";break;
                                  case "6" : persetujuan="Persetujuan RUPS";break;
                                  case "7" : persetujuan="Persetujuan FinRUPS";break;
                                  case "8" : persetujuan="Persetujuan Risalah RUPS";break;
                                  case "9" : persetujuan="Disetujuai dan Ditandatangani";break;
                                }
                              return persetujuan;
                            }
                          },
                          { name: "nd_surat", align:"center", title: "Detail",  width: 150 ,

                            itemTemplate: function(value) {
                              
                              var button = "<a href='{{ url('anggaran/edit/')}}/"+value+"/0'   class='btn btn-primary'> Detail</a>";
                              return button;
                            }
                          }
                      ]
                    })
                    
                  });
                  function setUnitKerja(id_type,id_unit){
                    var type = "";
                    if(id_type == "00 "){
                      type = "divisi";
                    }else{
                      type = "cabang";
                    }
                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/attributes/unitkerja/1') }}",
                        'success': function (data) {

                          daySelect = document.getElementById('cari_unit_kerja');

                         
                          for(i =0 ;i<data.length;i++){
                            var value = data[i].DESCRIPTION;
                            var desc = data[i].DESCRIPTION;
                            // if(desc.split("Cabang").length > 0 ){
                            //   value = data[i].VALUE+"00";
                            // }else{
                            //   value = "00"+data[i].VALUE;
                            // }
                            daySelect.options[daySelect.options.length] = new Option(desc, value);
                          }
                             
                        }
                    });
                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/attributes/nd_surat/1') }}",
                        'success': function (data) {

                          daySelect = document.getElementById('cari_nd_surat');

                         
                          for(i =0 ;i<data.length;i++){
                            var value = data[i].nd_surat;
                            var desc = data[i].nd_surat;
                            // if(desc.split("Cabang").length > 0 ){
                            //   value = data[i].VALUE+"00";
                            // }else{
                            //   value = "00"+data[i].VALUE;
                            // }
                            daySelect.options[daySelect.options.length] = new Option(desc, value);
                          }
                             
                        }
                    });

                  }
                  function cariAnggaran(){
                    // if(document.getElementById("cari_keyword").value==""){
                    //   toastr.error("Silahkan Isi Kata Kunci Pencarian. Terima kasih.", "Kata Kunci Pencarian Kosong.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    // }else 
                    if(document.getElementById("cari_unit_kerja").value=="0"){
                      toastr.error("Silahkan Pilih Salah Satu Unit Kerja. Terima kasih.", "Unit Kerja Belum Dipilih.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    }else{
                      $('form[id="filterAnggaran"]').submit();
                    }
                    // alert(JSON.stringify(inputs));
                  }
                  window.setUnitKerja({{$userCabang.",".$userDivisi}});
                </script>
                @endsection