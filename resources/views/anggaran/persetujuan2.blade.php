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
                                @if(session('success'))
                                <div class="col-xs-12 alert alert-success">
                                    Anggaran dengan Nomer Surat {{$filters['nd_surat']}} berhasil disimpan<br>
                                </div>
                                @endif
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                              </div>
                              <div class="card-body collapse in">
                                  <div class="card-block card-dashboard ">
                                    <form method="POST" action="{{url('anggaran/submit/tambah') }}" id="insertAnggaran" name="insertAnggaran" enctype="multipart/form-data">
                                    <div class="row">
                                      {{ csrf_field() }}
                                      <div class="col-xs-3">
                                          <div class="form-group">
                                            <label>Tanggal</label>
                                            <input id="tanggal" name="tanggal" class="form-control" value="<?php echo  date("d/m/Y");?>" readonly>
                                            
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-grpup">
                                            <label>ND/Surat</label>
                                            <input id="nd_surat" name="nd_surat" class="form-control" readonly>
                                            
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-group">
                                            <label>Unit Kerja</label>
                                            <input id="unit_kerja" name="unit_kerja" class="form-control" readonly>
                                              
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-grpup">
                                            <label>Tipe Anggaran</label>
                                            <input id="tipe_anggaran" name="tipe_anggaran" class="form-control" readonly>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-xs-3">
                                          <div class="form-group">
                                            <label>Status Anggaran</label>
                                            <input name="stat_anggaran"  id="stat_anggaran" class="form-control" readonly>
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-grpup">
                                            <label>Persetujuan</label>
                                            <input id="persetujuan" name="persetujuan" class="form-control" readonly>
                                          </div>
                                      </div>
                                    </div>
                                    <input type="hidden" name="list_anggaran_values" id="list_anggaran_values">
                                    <div id="file_grid"></div>
                                      <!-- <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p> -->
                                    <div id="basicScenario"></div>
                                    <input type="hidden" name="setuju" id="setuju" >
                                    <br />
                                    <div class="row col-xs-12" id="grup_r" style="display:none">

                                      <div class="col-xs-6 ">
                                        <div class="col-xs-4 ">
                                          <div class="form-group">
                                            <!-- <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Disetujui</button> -->
                                            <div id="accept_r" name="accept_r" onclick="changeButton()" class="btn btn-success"><i class="fa fa-check"></i> Disetujui</div>
                                          
                                          </div>
                                        </div>
                                        <div class="col-xs-2 ">
                                          <div class="form-group">
                                            <!-- <button type="submit" class="btn btn-secondary"><i class="fa fa-download"></i> Unduh</button> -->
                                            <div id="download_r" name="download_r" class="btn btn-secondary"><i class="fa fa-download"></i> Unduh</div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-xs-6 " >

                                        <div class="col-xs-3 pull-right">
                                          <div class="form-group">
                                            <!-- <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Kirim</button> -->
                                            <div id="send_r" name="send_r" class="btn btn-success" style="display:none"><i class="fa fa-send"></i> Kirim</div>
                                          </div>
                                        </div>
                                        <div class="col-xs-3 pull-right">
                                          <div class="form-group">
                                            <!-- <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</button> -->
                                            <a href="{{url('anggaran/persetujuan/'.$filters['nd_surat'].'/3')}}" id="edit_r" name="edit_r"  class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
                                            <div style="display:none" onclick="saveAnggaran()" id="save_r" name="save_r"  class="btn btn-primary"><i class="fa fa-save"></i> Simpan</div>
                                          
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row col-xs-12" id="grup_m" style="display:none">

                                      <div class="col-xs-6 ">
                                        <div class="form-group">
                                          <!-- <button type="submit" class="btn btn-secondary"><i class="fa fa-download"></i> Unduh</button> -->
                                            <a href="" id="download_m" name="download_m" class="btn btn-secondary"><i class="fa fa-download"></i> Unduh</a>
                                        </div>
                                      </div>
                                      <div class="col-xs-6 " >

                                        <div class="col-xs-3 pull-right">
                                          <div class="form-group">
                                            <!-- <button type="submit" class="btn btn-danger"><i class="fa fa-send"></i> Ditolak</button> -->
                                            <div id="reject_m" name="reject_m" onclick="rejectAnggaran()" class="btn btn-danger"><i class="fa fa-close"></i> Ditolak</div>
                                          </div>
                                        </div>
                                        <div class="col-xs-3 pull-right">
                                          <div class="form-group">
                                            <!-- <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Disetujui</button> -->
                                            <div id="accept_m" name="accept_m" onclick="acceptAnggaran()" class="btn btn-success"><i class="fa fa-check"></i> Disetujui</div>
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
                  var inputs = upload_file = convert_file =[];
                  var database_file= [];
                  var editableStat = {{ $editable ? 1 : 0 }};
                  var jenis_field = kelompok_field = pos_field = sub_field = satuan_field = null;
                  var unitk_field = kuantitas_field = nilai_field = null;
                  var twi_field = twii_field = twiii_field = twiv_field = anggarant_field= null
                  var item =  null;
                  var tempIdCounter = totalRows  = jumlah_file= 0;
                  
                  $(document).ready(function() {

                    $("#basicScenario").jsGrid( {
                      width: "100%",
               
                      sorting: true,
                      paging: true,
                      autoload: true,

                      editing: editableStat == 1 ? true : false,
                      inserting: editableStat == 1 ? true : false,
                      deleteConfirm: "Apalakh anda yakin akan menghapus anggaran baris ini?",
               
                      pageSize: 5,
                      pageButtonCount: 10,

                      controller: {
                        loadData: function(filter) {
                          return $.ajax({
                              type: "GET",
                              url:"{{ (checkActiveMenu('anggaran') == 'active' ? url('anggaran') : url('anggaran/get/filtered/'.$filters['nd_surat'].'/list_anggaran') ) }}",
                              data: filter,
                              dataType: "JSON",
                              'success': function (data) {
                                inputs = data;
                              }
                          })
                        },
                        insertItem: function (item) {
                          item["isNew"] = true;
                          item["tempId"] = ++tempIdCounter;

                          item["files"] = [];
                          for(i = 0; i<upload_file.length;i++){
                            var index = i;
                            var newFile ={
                              'name' : upload_file[i]["name"],
                              'type' : upload_file[i]["type"],
                              'size' : upload_file[i]["size"]
                            }
                            item["files"][index] = newFile;
                          }
                                                      
                          inputs.push(item);
                          console.log(item);
                        },
                        updateItem: function(item) {
                          item["files"] = [];
                          for(i = 0; i<upload_file.length;i++){
                            var index = i;
                            var newFile ={
                              'name' : upload_file[i]["name"],
                              'type' : upload_file[i]["type"],
                              'size' : upload_file[i]["size"]
                            }
                            item["files"][index] = newFile;
                          }
                          if (item["isNew"]) {
                            inputs.splice(item["tempId"]-1, 1, item);  
                          } else {
                            inputs.push(item);
                          }
                          console.log(item);  
                        },
                      }, 
                      onRefreshed: function(args) {
                        var items = args.grid.option("data");
                        items.forEach(function(item) {
                          totalRows += 1;
                        });
                      },
                      fields: [
                          {
                            name: "id",
                            css: "hide",
                            width: 0,
                            readOnly: true

                          },
                          { type: "control",
                            width: 50,
                            css: editableStat == 1? "":"hide"
                          },
                          { name: "jenis", 
                            type: "text", 
                            title: "Jenis", 
                            width: 90,
                            readOnly:true,
                            insertTemplate: function() {
                              jenis_field = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              return jenis_field; 
                            },
                            editTemplate: function(value) {
                              jenis_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(jenis_field).val(value);
                              return jenis_field; 
                            } 
                          },
                          { name: "kelompok", 
                            type: "text", 
                            title: "Kelompok", 
                            width: 90,
                            readOnly:true,
                            insertTemplate: function() {
                              kelompok_field = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              return kelompok_field; 
                            },
                            editTemplate: function(value) {
                              kelompok_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(kelompok_field).val(value);
                              return kelompok_field; 
                            } 
                          },
                          { name: "pos_anggaran", 
                            type: "text", 
                            title: "Pos Anggaran", 
                            width: 120,
                            readOnly:true,
                            insertTemplate: function() {
                              pos_field = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              return pos_field; 
                            },
                            editTemplate: function(value) {
                              pos_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(pos_field).val(value);
                              return pos_field; 
                            } 
                          },
                          { name: "sub_pos", 
                            type: "text", 
                            title: "Sub Pos", 
                            width: 70,
                            readOnly:true,
                            insertTemplate: function() {
                              sub_pos = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              return sub_pos; 
                            },
                            editTemplate: function(value) {
                              sub_pos = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(sub_pos).val(value);
                              return sub_pos; 
                            } 
                          },
                          { name: "mata_anggaran", 
                            type: "select", 
                            title: "Mata Anggaran",
                            width: 130,
                            valueField: "DESCRIPTION", 
                            textField: "DESCRIPTION", 
                            items: getData('mataanggaran'),
                            insertTemplate: function() {
                              var result = jsGrid.fields.select.prototype.insertTemplate.call(this);
                              result.on("change", function() {
                                  changeData($(this).val());
                              });
                              return result; 
                            },
                            editTemplate: function(value) {
                              var result = jsGrid.fields.select.prototype.editTemplate.call(this);
                              $(result).val(value);
                              result.on("change", function() {
                                  changeData($(this).val());
                              });
                              return result; 
                            },
                            validate: {
                              message : "Pilih Mata Anggaran Terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value !== "00" ;
                              } 
                            }
                          },
                          { name: "kuantitas", 
                            type: "number", 
                            title: "Kuantitas", 
                            width: 90, 
                            insertTemplate: function() {
                              kuantitas_field = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              kuantitas_field.on("change", function() {
                                  changeAnggaranSetahun();
                                  $(kuantitas_field).val($(this).val());
                              });
                              return kuantitas_field; 
                            },
                            editTemplate: function(value) {
                              kuantitas_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(kuantitas_field).val(value);
                              kuantitas_field.on("change", function() {
                                  changeAnggaranSetahun();
                                  $(kuantitas_field).val($(this).val());
                              });
                              return kuantitas_field; 
                            },
                            validate: {
                              message : "Isi Kolom Kuantitas terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value > 0 ;
                              } 
                            }
                          },
                          { name: "satuan", 
                            type: "text", 
                            title: "Satuan", 
                            width: 80,
                            readOnly:true,
                            insertTemplate: function() {
                              satuan_field = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              return satuan_field; 
                            },
                            editTemplate: function(value) {
                              satuan_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(satuan_field).val(value);
                              return satuan_field; 
                            } 
                          },
                          { name: "nilai_persatuan", 
                            type: "number", 
                            title: "Nilai Per Satuan", 
                            width: 130, 
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              
                              return display;
                            },
                            insertTemplate: function() {
                              nilai_field = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              nilai_field.on("change", function() {
                                  changeAnggaranSetahun();
                                  $(nilai_field).val($(this).val());
                              });
                              return nilai_field; 
                            },
                            editTemplate: function(value) {
                              nilai_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(nilai_field).val(value);
                              nilai_field.on("change", function() {
                                  changeAnggaranSetahun();
                                  $(nilai_field).val($(this).val());
                              });
                              return nilai_field; 
                            },
                            validate: {
                                message : "Isi Kolom Nilai Per Satuan.",
                                validator :function(value, item) {
                                    return value > 0 ;
                                } 
                              }
                          },
                          { name: "terpusat", 
                            type: "select", 
                            title: "Terpusat", 
                            width: 80, items:[
                                { Name: "None", Id: 0 },
                                { Name: "Ya", Id: 1 },
                                { Name: "Tidak", Id: 2}
                            ],
                            valueField: "Id",
                            textField: "Name",
                            insertTemplate: function() {
                              var result = jsGrid.fields.select.prototype.insertTemplate.call(this);
                              result.on("change", function() {
                                  changeDataUnitKerjaLine($(this).val());
                              });
                              return result; 
                            },
                            editTemplate: function(value) {
                              var result = jsGrid.fields.select.prototype.editTemplate.call(this);
                              $(result).val(value);
                              result.on("change", function() {
                                  changeDataUnitKerjaLine($(this).val());
                              });
                              return result; 
                            },
                            validate: {
                              message : "Pilih Ya/Tidak Terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value > 0 ;
                              } 
                            }
                          },
                          { name: "unit_kerja", 
                            type: "text", 
                            title: "Unit Kerja", 
                            width: 100, 
                            readOnly:true,
                            insertTemplate: function() {
                              unitk_field = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              return unitk_field; 
                            },
                            editTemplate: function(value) {
                              unitk_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(unitk_field).val(value);
                              return unitk_field; 

                            } 
                          },
                          { name: "tw_i", 
                            type: "number", 
                            title: "TW I", 
                            width: 100,
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              
                              if(parseInt(value).toLocaleString() < 1){
                                display = "<span >---</span>";
                              }
                              return display;
                            },
                            insertTemplate: function() {
                              // var valField=this._grid.fields[12];
                              twi_field = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              twi_field.on("change", function(e) {
                                  $(twi_field).val($(this).val());
                                  changeAnggaranSetahun();
                              });
                              return twi_field; 
                            },
                            editTemplate: function(value) {
                              twi_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(twi_field).val(value);
                              twi_field.on("change", function() {
                                  changeAnggaranSetahun();
                                  $(twi_field).val($(this).val());
                              });
                              return twi_field; 
                            },
                            validate: {
                              message : "Isi minimal pada salah satu Kolom dari TWI, TWII, TWIII, TWIV.",
                              validator :function(value, item) {
                                  var twi_val = $(twi_field).val();
                                  var twii_val = $(twii_field).val();
                                  var twiii_val = $(twiii_field).val();
                                  var twiv_val = $(twiv_field).val();
                                  var sum = twi_val+twii_val+twiii_val+twiv_val;
                                  
                                  return sum > 0 ;
                              }
                            }
                          },
                          { name: "tw_ii", 
                            type: "number", 
                            title: "TW II", 
                            width: 100 ,
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              
                              if(parseInt(value).toLocaleString() < 1){
                                display = "<span>---</span>";
                              }
                              return display;
                            },
                            insertTemplate: function() {
                              twii_field = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              twii_field.on("change", function() {
                                  changeAnggaranSetahun();
                                  $(twii_field).val($(this).val());
                              });
                              return twii_field; 
                            },
                            editTemplate: function(value) {
                              twii_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(twii_field).val(value);
                              twii_field.on("change", function() {
                                  changeAnggaranSetahun();
                                  $(twii_field).val($(this).val());
                              });
                              return twii_field; 
                            }
                          },
                          { name: "tw_iii", 
                            type: "number", 
                            title: "TW III", 
                            width: 100 ,
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              
                              if(parseInt(value).toLocaleString() < 1){
                                display = "<span>---</span>";
                              }
                              return display;
                            },
                            insertTemplate: function() {
                              twiii_field = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              twiii_field.on("change", function() {
                                  changeAnggaranSetahun();
                                  $(twiii_field).val($(this).val());
                              });
                              return twiii_field; 
                            },
                            editTemplate: function(value) {
                              twiii_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(twiii_field).val(value);
                              twiii_field.on("change", function() {
                                  changeAnggaranSetahun();
                                  $(twiii_field).val($(this).val());
                              });
                              return twiii_field; 
                            }
                          },
                          { name: "tw_iv", 
                            type: "number", 
                            title: "TW IV",
                            width: 100,
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              
                              if(parseInt(value).toLocaleString() < 1){
                                display = "<span>---</span>";
                              }
                              return display;
                            },
                            insertTemplate: function() {
                              twiv_field = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              twiv_field.on("change", function() {
                                  changeAnggaranSetahun();
                                  $(twiv_field).val($(this).val());
                              });
                              return twiv_field; 
                            },
                            editTemplate: function(value) {
                              twiv_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(twiv_field).val(value);
                              twiv_field.on("change", function() {
                                  changeAnggaranSetahun();
                                  $(twiv_field).val($(this).val());
                              });
                              return twiv_field; 
                            }
                           },
                          { name: "anggarana_setahun", 
                            type: "number", 
                            title: "Anggaran Setahun", 
                            width: 150 ,
                            readOnly:true,
                            itemTemplate: function(value) {
                              var display ="<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                              
                              return display;
                            },
                            insertTemplate: function() {
                              anggarant_field = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              return anggarant_field; 
                            },
                            editTemplate: function(value) {
                              anggarant_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(anggarant_field).val(value);
                              return anggarant_field; 
                            },
                            validate: {
                              message :function(value, item) {
                                  var status1 = "lebih";
                                  var status2 = "kurang";
                                  var twi_val = $(twi_field).val() == "" ? 0:parseInt($(twi_field).val());
                                  var twii_val = $(twii_field).val() == "" ? 0:parseInt($(twii_field).val());
                                  var twiii_val = $(twiii_field).val() == "" ? 0:parseInt($(twiii_field).val());
                                  var twiv_val = $(twiv_field).val() == "" ? 0:parseInt($(twiv_field).val());
                                  var anggaran_val = parseInt($(anggarant_field).val());
                                  var sum = twi_val+twii_val+twiii_val+twiv_val;
                                  // return (twi_val+twii_val)+" dan "+ anggaran_val;
                                  return  "Jumlah Anggaran yang di minta di semua periode "+ (sum > anggaran_val ? status1: status2)+" dari Anggaran Setahun" ;
                              },
                              validator :function(value, item) {
                                  var twi_val = $(twi_field).val() == "" ? 0:parseInt($(twi_field).val());
                                  var twii_val = $(twii_field).val() == "" ? 0:parseInt($(twii_field).val());
                                  var twiii_val = $(twiii_field).val() == "" ? 0:parseInt($(twiii_field).val());
                                  var twiv_val = $(twiv_field).val() == "" ? 0:parseInt($(twiv_field).val());
                                  var anggaran_val = parseInt($(anggarant_field).val());
                                  var sum = twi_val+twii_val+twiii_val+twiv_val;
                                  
                                  return sum <= anggaran_val && sum >= anggaran_val ;
                              }
                            }
                          },
                          
                          { name: "file", align:"center", title: "Berkas",  width: 150 ,

                            itemTemplate: function(value) {
                              var name_file = "";
                              var id_list;
                              var status = false;

                              if(value.length > 0){


                                if(database_file.length >0 ){
                                  for(i = 0;i<database_file.length;i++){
                                    name_file+=(i+1)+". "+database_file[i]["name"]+"<br /> ";
                                  }
                                }
                                for(j = 0;j<value.length;j++){
                                  name_file+=(j+1)+". "+value[j]["name"]+"<br /> ";
                                  if(value[j]['id_list_anggaran']!=null){
                                    id_list = value[j]['id_list_anggaran'];
                                    status = true;
                                  }
                                }
                              }
                              if(status)
                                return "<span > <a href='{{url('anggaran/get/download')}}/"+id_list+"/{{$filters['nd_surat']}}' >Unduh Berkas</a>:<br />"+ name_file+" </span>";
                              else
                                return "<span > Unggah Berkas:<br />"+ name_file+" </span>";
                            },
                            insertTemplate: function() {
                                var insertControl = this.insertControl = $("<input>").prop("type", "file").attr("multiple", "multiple").attr("id", "file");
        
                                return  insertControl;
                            },
                            insertValue: function() {
                                upload_file = this.insertControl[0].files;
                                jumlah_file = upload_file.length;
                                for(i=1; i <= upload_file.length;i++){

                                  readerPrev(i);
                                  
                                }

                                return upload_file; 
                            },
                            editTemplate: function(value) {
                                var editControl = this.editControl = $("<input>").prop("type", "file").attr("multiple", "multiple");
                                
                                return editControl;
                            },
                            editValue: function() {

                                for(index=1;index<=upload_file.length;index++){
                                  var element = document.getElementById("file_grid");
                                  var child = document.getElementById("file_"+tempIdCounter+"_"+index);
                                  element.removeChild(child);
                                }

                                upload_file= this.editControl[0].files;
                                jumlah_file = upload_file.length; 
                                for(i=1; i <= upload_file.length;i++){

                                  readerPrev(i);
                                  
                                }
                                return upload_file; 
                            },
                            
                            validate: {
                              message : "Silahkan Upload File pendukung",
                              validator :function(value, item) {
                                  return jumlah_file > 0 ;
                              } 
                            }

                          }
                      ]
                    })
                    
                  });

                  function readerPrev(index){
                    var reader = new FileReader();
                    reader.readAsDataURL(upload_file[index-1]);
                    reader.onload = function () {
                      var hiddenInput = $('<input/>',{type:'hidden',id:('file_'+tempIdCounter+'_'+index),
                        name:('file_'+tempIdCounter+'_'+index),value:reader.result});
                      hiddenInput.appendTo("#file_grid");

                    };

                  }

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

                  function setUnitKerja(id_type,id_unit){
                    var type = "";
                    if(id_type == "00 "){
                      type = "divisi";
                    }else{
                      type = "cabang";
                    }
                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/attributes') }}/"+type+"/"+id_unit,
                        'success': function (data) {
                            document.getElementById("unit_kerja").value = data[0].DESCRIPTION;
                        }
                    });

                  }

                  function setDetailAnggaran(nd_surat){
                    if(nd_surat!=null)
                      $.ajax({
                          'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/filtered/') }}/"+nd_surat+"/anggaran",
                          'success': function (data) {
                              // alert(data[0].active);
                              if(data[0].active == 1){
                                var persetujuan = status_anggaran = "";
                                switch(data[0].persetujuan){
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
                                  case "89" : persetujuan="Disetujuai dan Ditandatangani";break;
                                }
                                switch(data[0].status_anggaran){
                                  case "1" : status_anggaran="Draft";break;
                                  case "2" : status_anggaran="Transfer";break;
                                  case "3" : status_anggaran="Complete";break;
                                }
                                var tgl = data[0].tanggal;
                                var tgl_split = tgl.split("-");
                                document.getElementById("nd_surat").value = nd_surat;
                                document.getElementById("stat_anggaran").value = status_anggaran;
                                document.getElementById("persetujuan").value = persetujuan;
                                document.getElementById("tipe_anggaran").value = data[0].tipe_anggaran;
                                document.getElementById("unit_kerja").value = data[0].unit_kerja;
                                document.getElementById("tanggal").value = tgl_split[2]+"/"+tgl_split[1]+"/"+tgl_split[0];
                                if(data[0].persetujuan == "9"||data[0].persetujuan == "-1"){
                                  document.getElementById("grup_m").style.display="none";
                                  document.getElementById("grup_r").style.display="none";
                                }else if(data[0].persetujuan =="1"){
                                  document.getElementById("grup_m").style.display="none";
                                  document.getElementById("grup_r").style.display="block";
                                }else{
                                  document.getElementById("grup_m").style.display="block";
                                  document.getElementById("grup_r").style.display="none";
                                }
                                if(editableStat){
                                  document.getElementById("accept_r").style.display="none";
                                  document.getElementById("download_r").style.display="none";
                                  document.getElementById("edit_r").style.display="none";
                                  document.getElementById("save_r").style.display="block";
                                  document.getElementById("send_r").style.display="block";
                                  // alert({{$reject}});
                                  var reject = {{$reject ? 1:0}};
                                  if(reject == 1)
                                    document.getElementById("send_r").setAttribute('onclick','rejectAnggaran();');
                                  else{
                                    document.getElementById("send_r").setAttribute('onclick','acceptAnggaran();');
                                  }
                                  
                                }
                              }
                              for(i=1;i<data.length;i++){
                                // alert(data[0].persetujuan+"???"+data[i].persetujuan);
                                if(parseInt(data[0].persetujuan) < parseInt(data[i].persetujuan)){

                                  changeButton();
                                  document.getElementById("send_r").style.display="none";
                                  document.getElementById("accept_r").style.display="none";
                                  break;
                                }
                              }
                          }
                      });

                  }

                  function changeDataUnitKerjaLine(type){

                    if(type == 1){
                      $(unitk_field).val();
                    }else{
                      $(unitk_field).val(document.getElementById("unit_kerja").value);
                    }
                          
                  }

                  function changeData(kegiatan){
                    var tmp = null;
                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/attributes') }}/mataanggaran/-1",
                        'success': function (data) {
                            tmp = data;

                            $(jenis_field).val("Contoh Jenis");
                            $(kelompok_field).val("Contoh Kelompok");
                            $(pos_field).val("Contoh Pos Anggaran");
                            $(sub_pos).val("Contoh Sub Pos");
                            $(satuan_field).val("Contoh Satuan");
                            // $(unitk_field).val("Contoh Unit Kerja");
                        }
                    });
                  }

                  function changeAnggaranSetahun(){
                    if($(kuantitas_field).val() !="" && $(nilai_field).val()!= ""){
                      var qty = $(kuantitas_field).val();
                      var nilai = $(nilai_field).val();
                      $(anggarant_field).val(qty*nilai);
                      // alert(qty*nilai);
                    }else{
                      // alert("masih kosong");
                    }
                  }

                  function saveAnggaran(){
                    // alert(inputs.length );
                    if(document.getElementById("nd_surat").value==""){
                      toastr.error("Silahkan Isi Form Nomor Surat Terlebih Dahulu. Terima kasih.", "Perhatian.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    } else if(inputs.length < 1){
                      toastr.error("Silahkan tambahkan minimal 1 daftar anggaran untuk melakukan penyimpanan. Terima kasih.", "Minimal satu anggaran yang diisi.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    }else{

                      document.getElementById("setuju").value = "Simpan";
                      $('input[name="list_anggaran_values"]').val(JSON.stringify(inputs));
                      // alert(JSON.stringify(inputs));
                      $('form[id="insertAnggaran"]').submit();
                    }
                  };

                  function rejectAnggaran(){
                    // alert(inputs.length );
                    if(document.getElementById("nd_surat").value==""){
                      toastr.error("Silahkan Isi Form Nomor Surat Terlebih Dahulu. Terima kasih.", "Perhatian.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    } else if(inputs.length < 1){
                      toastr.error("Silahkan tambahkan minimal 1 daftar anggaran untuk melakukan penyimpanan. Terima kasih.", "Minimal satu anggaran yang diisi.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    }else{

                      document.getElementById("setuju").value = "Tolak";
                      $('input[name="list_anggaran_values"]').val(JSON.stringify(inputs));
                      // alert(JSON.stringify(inputs));
                      $('form[id="insertAnggaran"]').submit();
                    }
                  };

                  function acceptAnggaran(){
                    // alert(inputs.length );
                    if(document.getElementById("nd_surat").value==""){
                      toastr.error("Silahkan Isi Form Nomor Surat Terlebih Dahulu. Terima kasih.", "Perhatian.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    } else if(inputs.length < 1){
                      toastr.error("Silahkan tambahkan minimal 1 daftar anggaran untuk melakukan penyimpanan. Terima kasih.", "Minimal satu anggaran yang diisi.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    }else{

                      document.getElementById("setuju").value = "Kirim";
                      $('input[name="list_anggaran_values"]').val(JSON.stringify(inputs));
                      // alert(JSON.stringify(inputs));
                      $('form[id="insertAnggaran"]').submit();
                    }
                  };

                  function changeButton(){
                    document.getElementById("send_r").addEventListener("click", function(event) {
                      acceptAnggaran();
                      event.preventDefault();
                    });
                    document.getElementById("accept_r").style.display="none";
                    document.getElementById("edit_r").style.display="block";
                    document.getElementById("send_r").style.display="block";
                    var edit_href = document.getElementById('edit_r'); //or grab it by tagname etc
                    edit_href.href = "{{url('anggaran/persetujuan/'.$filters['nd_surat'].'/2')}}"
                  }


                  
                  window.setUnitKerja({{$userCabang.",".$userDivisi}});
                  window.setDetailAnggaran({{$filters['nd_surat']}});
                  

                </script>
                @endsection