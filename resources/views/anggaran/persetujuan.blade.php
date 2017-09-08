                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                @endsection

                @section('content')
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Persetujuan Kegiatan dan Anggaran</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index-2.html">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Persetujuan Kegiatan dan Anggaran
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
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                              </div>
                              <div class="card-body collapse in">
                                  <div class="card-block card-dashboard ">
                                    <form method="POST" action="" >
                                    <div class="row">
                                      {{ csrf_field() }}
                                      <div class="col-xs-3">
                                          <div class="form-group">
                                            <label>Tanggal</label>
                                            <input id="tanggal" name="tanggal" class="form-control" value="<?php echo  date("d/m/Y");?>" disabled>
                                            
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-grpup">
                                            <label>ND/Surat</label>
                                            <input id="nd-surat" name="nd-surat" class="form-control" disabled>
                                            
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-group">
                                            <label>Unit Kerja</label>
                                            <input id="unit-kerja" name="unit-kerja" class="form-control" disabled>                                                    
                                          </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-xs-3">
                                          <div class="form-group">
                                            <label>Tipe Anggaran</label>
                                            <input id="tipe-anggaran" name="tipe-anggaran" class="form-control" disabled>                                                    
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-group">
                                            <label>Status Anggaran</label>
                                            <input id="stat-anggaran" name="stat-anggaran" class="form-control" disabled>                                                    
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-grpup">
                                            <label>Persetujuan</label>
                                            <input id="persetujuan" name="persetujuan" class="form-control" disabled>
                                            
                                          </div>
                                      </div>
                                    </div>
                                    <!-- <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p> -->
                                    <div id="basicScenario"></div>
                                    <br />

                                    <div class="row col-xs-12" style="display:block">

                                      <div class="col-xs-6 ">
                                        <div class="col-xs-4 ">
                                          <div class="form-group">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Disetujui</button>
                                          </div>
                                        </div>
                                        <div class="col-xs-2 ">
                                          <div class="form-group">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-download"></i> Unduh</button>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-xs-6 " >

                                        <div class="col-xs-3 pull-right">
                                          <div class="form-group">
                                            <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Kirim</button>
                                          </div>
                                        </div>
                                        <div class="col-xs-3 pull-right">
                                          <div class="form-group">
                                            <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</button>
                                          </div>
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
                  var editableStat = {{ $editable ? 1 : 0 }};
                  $(document).ready(function() {
                    $("#basicScenario").jsGrid( {
                      width: "100%",
               
                      sorting: true,
                      paging: true,
                      autoload: true,

                      editing: editableStat == 1 ? true : false, 
                      inserting: false,
               
                      pageSize: 5,
                      pageButtonCount: 10,
                      
                      controller: {
                        loadData: function(filter) {
                          return $.ajax({
                              type: "GET",
                              url:"",
                              data: filter,
                              dataType: "JSON"
                          })
                        }
                      }, 
                      fields: [
                          { type: "control"},
                          { name: "jenis", 
                            type: "text", 
                            title: "Jenis", 
                            width: 90,
                            readOnly:true,
                            css: editableStat == 1 ? '' : "hide"
                            validate: {
                                validator : "required",
                                message : "Pilih Mata Anggaran Terlebih dahulu."  
                              }
                          },
                          { name: "kelompok", type: "text", title: "Kelompok", width: 90,readOnly:true
                          },
                          { name: "pos_anggaran", type: "text", title: "Pos Anggaran", width: 120,readOnly:true 
                          },                         
                          { name: "sub_pos", type: "text", title: "Sub Pos", width: 100 ,readOnly:true, 
                          },
                          { name: "mata_anggaran", type: "select", title: "Mata Anggaran", width: 130 },
                          { name: "kuantitas", type: "number", title: "Kuantitas", width: 100, validate: {
                                validator : "required",
                                message : "Isi Kolom Kuantitas terlebih dahulu."  
                              }
                          },
                          { name: "satuan", type: "select", title: "Satuan", width: 100 },
                          { name: "nilai_persatuan", type: "number", title: "Nilai Per Satuan", width: 130, validate: {
                                validator : "required",
                                message : "Isi Kolom Nilai Per Satuan."  
                              }
                          },
                          { name: "terpusat", type: "select", title: "Terpusat", width: 100 },
                          { name: "unit_kerja", type: "select", title: "Unit Kerja", width: 100, readOnly:true},
                          { name: "tw_i", type: "number", title: "TW I", width: 100,validate: {
                                validator : "required",
                                message : "Isi Kolom Nilai Per SatuanTWI."  
                              }
                          },
                          { name: "tw_ii", type: "number", title: "TW II", width: 100 ,validate: {
                                validator : "required",
                                message : "Isi Kolom Nilai Per SatuanTWI."  
                              }
                          },
                          { name: "tw_iii", type: "number", title: "TW III", width: 100 ,validate: {
                                validator : "required",
                                message : "Isi Kolom Nilai Per SatuanTWI."  
                              }
                          },
                          { name: "tw_iv", type: "number", title: "TW IV", width: 100,validate: {
                                validator : "required",
                                message : "Isi Kolom Nilai Per SatuanTWI."  
                              }
                           },
                          { name: "anggarana_setahun", type: "number", title: "Anggaran Setahun", width: 150 ,readOnly:true},
                          /*{ name: "stat", type: "text", title: "Status Posting", 
                            itemTemplate:function(e) {
                              var content = e == '1' ? "Sesuai" : (e == '0' ? "Tidak sesuai" : 'Belum posting');
                              var tag = e == '1' ? "tag-success" : (e == '0' ? "tag-default" : 'tag-info');
                              return "<span class='tag "+tag+"'>"+content+"</span>" ;
                            } 
                          },*/
                          
                          { name: "file", align:"center", title: "File",  width: 150 ,
                            itemTemplate:function(e) {
                              return "<input type='file' multiple>";
                            }
                          }
                      ]
                    })
                  });
                </script>
                @endsection