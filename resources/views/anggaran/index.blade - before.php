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
                        <div class="row" style="display:{{$display['search']}}">
                            <div class="card">
                                <div class="card-header">
                                  <h4 class="card-title">Pencarian Anggaran dan Kegiatan</h4>
                                  <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                                </div>
                                <div class="card-body collapse in">
                                  <div class="card-block ">
                                    <form method="POST" action="">
                                      <div class="row col-xs-12">
                                        {{ csrf_field() }}
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                              <label>ND/Surat</label>
                                              <input id="cari_nd_surat" name="cari_nd_surat" class="form-control">
                                              
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                              <label>Tipe Anggaran</label>
                                              <select class="select2 form-control" name="cari_tipe_anggaran" id="cari_tipe_anggaran">
                                                <option value="0">Tipe Anggaran</option>
                                                <option value="1">Kirim</option>
                                                <option value="2">Persetujuan Kanit Kerja</option>
                                                <option value="3">Persetujuan Renbang</option>
                                                <option value="4">Persetujuan Direksi</option>
                                                <option value="5">Persetujuan Dekom</option>
                                                <option value="6">Persetujuan Ratek</option>
                                                <option value="7">Persetujuan RUPS</option>
                                                <option value="8">Persetujuan Finalisasi RUPS</option>
                                                <option value="9">Persetujuan Risalah RUPS</option>
                                              </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                              <label>Status Anggaran</label>
                                              <select class="select2 form-control" name="cari_stat_anggaran" id="cari_stat_anggaran">
                                                <option value="0">None</option>
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
                                                <option value="0">None</option>
                                              </select>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="row col-xs-12">
                                          <div class="col-xs-9 ">
                                          </div>
                                          <div class="col-xs-1">
                                              <a href="{{ url('anggaran/edit/333/1') }}" class="btn btn-primary"><i class="fa fa-search"></i> Cari</a>                                            
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
                        <div class="row">
                          
                          <div class="card">

                              <div class="card-header">
                                @if(session('success'))
                                <div class="col-xs-12 alert alert-success">
                                    Anggaran dengan Nomer Surat {{$nd_surat}} berhasil disimpan<br>
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

                                            @if($status=='tambah')
                                               <input id="nd_surat" name="nd_surat" class="form-control">
                                            @else
                                                <input id="nd_surat" name="nd_surat" class="form-control" readonly>
                                            @endif
                                           
                                            
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
                                            @if($status=='tambah')
                                              <select class="select2 form-control" id="tipe_anggaran" name="tipe_anggaran">
                                                <option value="Tipe Anggaran">Tipe Anggaran</option>
                                              </select>
                                            @else
                                                <input id="tipe_anggaran" name="tipe_anggaran" class="form-control" readonly>
                                            @endif
                                            
                                          </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-xs-3">
                                          <div class="form-group">
                                            <label>Status Anggaran</label>
                                            <input name="stat_anggaran"  id="stat_anggaran" class="form-control" value="Draft" readonly>
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-grpup">
                                            <label>Persetujuan</label>
                                            <input id="persetujuan" name="persetujuan" class="form-control" readonly>
                                          </div>
                                      </div>
                                      <div class="col-xs-6">
                                        <div class="row">
                                            <div class="col-xs-6">
                                              <label>Batas Waktu Pengisian &nbsp; :</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-xs-3">
                                            <div id="bts" style="display:none">Coba</div>
                                            <div class="form-grpup">
                                              <input id="bts_hari" name="bts_hari" class="form-control" value="---" readonly>
                                            </div>
                                          </div>
                                          <div class="col-xs-3">
                                            <div class="form-grpup">
                                              <input id="bts_jam" name="bts_jam" class="form-control" value="---" readonly>
                                            </div>
                                          </div>
                                           <div class="col-xs-3">
                                            <div class="form-grpup">
                                              <input id="bts_menit" name="bts_menit" class="form-control" value="---" readonly>
                                            </div>
                                          </div>
                                           <div class="col-xs-3">
                                            <div class="form-grpup">
                                              <input id="bts_detik" name="bts_detik" class="form-control" value="---" readonly>
                                            </div>
                                          </div>
                                        </div>

                                           
                                      </div>
                                    </div>
                                    <input type="hidden" name="list_anggaran_values" id="list_anggaran_values">
                                    <div id="file_grid"></div>
                                    <input type="hidden" name="status" id="status" value="{{$status}}">
                                    <input type="hidden" name="setuju" id="setuju" >
                                      <!-- <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p> -->
                                    <div id="basicScenario"></div>

                                    <br />
                                    <div class="row col-xs-12">

                                      <div class="col-xs-3 ">
                                      </div>
                                      <div class="col-xs-2 ">
                                        <div class="form-group" id="save_button" style="display:{{$display['save']}}">
                                          <div id="save" name="save" onclick="saveAnggaran()"class="btn btn-primary"><i class="fa fa-save"></i> Simpan</div>
                                        </div>
                                      </div>
                                      <div class="col-xs-3 ">
                                      </div>
                                      <div class="col-xs-2" style="horizontal-align:center">
                                        <div class="form-group" id="send_button" style="display:{{$display['send']}}">
                                          <div id="send" name="send" onclick="sendAnggaran()" class="btn btn-success"><i class="fa fa-send"></i> Kirim</div>
                                        </div>
                                      </div>
                                      <div class="col-xs-2 ">
                                        <div class="form-group" id="edit_button" style="display:{{$display['edit']}}">
                                          <a href="{{ url('anggaran/edit/'.$filters['nd_surat'].'/1') }}" id="edit" name="edit" class="btn btn-primary"><i class="fa fa-edit"></i> Ubah</a>
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

                <div class="modal fade text-xs-left" id="modal_berkas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20"
                aria-hidden="true">
                  <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="titleModal">Unggah Berkas</h4>
                      </div>
                      <div class="modal-body" id="confirmation-msg">
                        <div class="row">
                          <div class="col-md-12" id="list_download">
                          </div>
                          <div class="col-md-12" id="list_file">
                          </div>
                          <br />
                          <br />
                          @if($editable)
                          <input type="file" id="files" name="files" multiple>
                          @endif
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                        @if($editable)
                        <button id="simpan_file" class="btn btn-outline-primary">Simpan</button>
                        @endif
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
                // Set the date we're counting down to
                  var countDownDate = new Date("Aug 30, 2017 00:00:00").getTime();

                  var disableCountDown = false;
                  if(disableCountDown){
                    var x = setInterval(function() {

                        // Get todays date and time
                        var now = new Date().getTime();
                        
                        // Find the distance between now an the count down date
                        var distance = countDownDate - now;
                        
                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        
                        // Output the result in an element with id="demo"
                        document.getElementById("bts_hari").value= days +" Hari";
                        document.getElementById("bts_jam").value= hours +" Jam";
                        document.getElementById("bts_menit").value= minutes + " Menit";
                        document.getElementById("bts_detik").value= seconds + " Detik";
                        document.getElementById("bts").innerHTML = days + "d " + hours + "h "
                        + minutes + "m " + seconds + "s ";
                        
                        // If the count down is over, write some text 
                        if (distance < 0) {
                            alert ("Waktu Memasukkan data anggaran dan kegiatan telah usai");
                            clearInterval(x);
                            document.getElementById("bts_hari").value= "---";
                            document.getElementById("bts_jam").value= "---";
                            document.getElementById("bts_menit").value= "---";
                            document.getElementById("bts_detik").value= "---";
                            document.getElementById("bts").innerHTML = "EXPIRED";
                            document.getElementById("nd_surat").disabled  = true;
                            document.getElementById("unit_kerja").disabled  = true;
                            document.getElementById("tipe_anggaran").disabled  = true;
                            document.getElementById("stat_anggaran").disabled  = true;
                            document.getElementById("save").style.display = "none";
                            document.getElementById("send").style.display = "none";
                        }
                    }, 1000);
                  window.setUnitKerja();

                  }
                </script>
                <script type="text/javascript">
                  var inputs = [];
                  var hasil=[];
                  var upload_file = []
                  var convert_file =[];
                  var database_file= []
                  var list_berkas=[];
                  var editableStat = {{ $editable ? 1 : 0 }};
                  var insertableStat = {{ $status=='edit' ? 1 : 0 }};
                  var jenis_field = kelompok_field = pos_field = sub_field = satuan_field = null;
                  var unitk_field = kuantitas_field = nilai_field = null;
                  var twi_field = twii_field = twiii_field = twiv_field = anggarant_field= null
                  var item =  null;
                  var tempIdCounter = totalRows  = jumlah_file=0
                  var simpan_file =false;
                  var index_modal = -1;
                  var isInput = false;
                  var statusTable = "null";
                  $('#modal_berkas').on('hidden.bs.modal', function () {
                      if(!simpan_file){
                        hasil=[];
                        for(i = 0; i < upload_file.length ; i++){
                          for(j = 0; j < upload_file[i].length ; j++){
                            if(convert_file[i]==null){
                              if(convert_file[i][j]==null){
                                // alert("null");
                                upload_file[i][j]==null
                                document.getElementById('file_'+i+'_'+j).value="null";
                                document.getElementById('file_name_'+i+'_'+j).value = "null";
                                document.getElementById('file_type_'+i+'_'+j).value = "null";
                                document.getElementById('file_size_'+i+'_'+j).value = "null";
                              }else{

                                // alert(convert_file[i][j].name);
                              }
                            }
                          }
                        }
                        
                      }
                      simpan_file = false;
                      // alert("close");
                  })

                  
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
                              dataType: "JSON"
                          })
                        },
                        insertItem: function (item) {
                          item["isNew"] = true;
                          item["tempId"] = ++tempIdCounter;
                                                      
                          inputs.push(item);
                          console.log(item);
                        },
                        updateItem: function(item) {
                          // alert("update");
                          item["files"] = [];
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
                      onItemEditing: function(args) {
                          statusTable = "edit";
                          // alert("editing");
                           window.setTimeout(function() {
                              $('.jsgrid-cancel-edit-button').one('click.avoidAuthorClickHandler', function() {
                                  // alert("cancel");

                                  statusTable = "null";
                              });
                           }, 200);
                          
                      },
                      onItemUpdated: function(args) {
                          // alert("updated");
                          statusTable = "null";
                      },
                      fields: [
                          {
                            name: "id",
                            css: "hide",
                            width: 0,
                            readOnly: true

                          },
                          {
                            name: "id_first",
                            css: "hide",
                            width: 0,
                            type: "number",
                            readOnly: true

                          },
                          { type: "control",
                            width: 90,
                            css: editableStat == 1? "":"hide",
                            headerTemplate: function() {
                                var control_field = jsGrid.fields.control.prototype.headerTemplate.call(this);
                                // alert("add");
                                window.setTimeout(function() {
                                    $('.jsgrid-insert-mode-button').on('click', function() {
                                        if($('.jsgrid-mode-on-button').length==0){
                                          // statusTable = "insert";
                                          statusTable = "null";
                                          // alert("null");
                                        }else{
                                          // alert("insert");
                                          statusTable = "insert";
                                          // statusTable = "null";
                                        }
                                    });
                                 }, 100);
                                return control_field;
                            }
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
                                  $(kuantitas_field).val($(this).val());
                                  changeAnggaranSetahun();
                              });
                              return kuantitas_field; 
                            },
                            editTemplate: function(value) {
                              kuantitas_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(kuantitas_field).val(value);
                              kuantitas_field.on("change", function() {
                                  $(kuantitas_field).val($(this).val());
                                  changeAnggaranSetahun();
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
                                  $(nilai_field).val($(this).val());
                                  changeAnggaranSetahun();
                              });
                              return nilai_field; 
                            },
                            editTemplate: function(value) {
                              nilai_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(nilai_field).val(value);
                              nilai_field.on("change", function() {
                                  $(nilai_field).val($(this).val());
                                  changeAnggaranSetahun();
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
                                  $(twi_field).val($(this).val());
                                  changeAnggaranSetahun();
                              });
                              return twi_field; 
                            },
                            validate: {
                              message : "Isi minimal pada salah satu Kolom dari TWI, TWII, TWIII, TWIV.",
                              validator :function(value, item) {
                                  var twi_val = $(twi_field).val() == "" ? 0:parseInt($(twi_field).val())
                                  var twii_val = $(twii_field).val() == "" ? 0:parseInt($(twii_field).val())
                                  var twiii_val = $(twiii_field).val() == "" ? 0:parseInt($(twiii_field).val())
                                  var twiv_val = $(twiv_field).val() == "" ? 0:parseInt($(twiv_field).val())
                                  var sum = twi_val+twii_val+twiii_val+twiv_val;
                                  // alert(twi_val+","+twii_val+","+twiii_val+","+twiv_val+"="+sum);
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
                                  $(twii_field).val($(this).val());
                                  changeAnggaranSetahun();
                              });
                              return twii_field; 
                            },
                            editTemplate: function(value) {
                              twii_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(twii_field).val(value);
                              twii_field.on("change", function() {
                                  $(twii_field).val($(this).val());
                                  changeAnggaranSetahun();
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
                                  $(twiii_field).val($(this).val());
                                  changeAnggaranSetahun();
                              });
                              return twiii_field; 
                            },
                            editTemplate: function(value) {
                              twiii_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(twiii_field).val(value);
                              twiii_field.on("change", function() {
                                  $(twiii_field).val($(this).val());
                                  changeAnggaranSetahun();
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
                                  $(twiv_field).val($(this).val());
                                  changeAnggaranSetahun();
                              });
                              return twiv_field; 
                            },
                            editTemplate: function(value) {
                              twiv_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(twiv_field).val(value);
                              twiv_field.on("change", function() {
                                  $(twiv_field).val($(this).val());
                                  changeAnggaranSetahun();
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

                              id_list=tempIdCounter-1;
                              if(value.length>0){
                                for(i =0;i<value.length;i++){
                                  id_list = value[i]['count'];
                                }
                              }
                              // var button = "<span class='btn btn-primary' onclick='setModalFile("+id_list+")' >Unggah Berkas</span>";
                              // return button;
                              var button = "<span class='btn btn-primary' onclick='setModalFile("+id_list+")' >Unggah Berkas</span>";
                              return button;
                            },
                            editTemplate: function(value) {
                              id_list=tempIdCounter-1;
                              for(i =0;i<value.length;i++){
                                id_list = value[i]['count'];
                              }
                              var button = "<span class='btn btn-primary' onclick='setModalFile("+id_list+")' >Unggah Berkas</span>";
                              return button;
                            },
                          },
                          { type: "control",
                            width: 50,
                            css: editableStat == 1? "":"hide"
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

                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/attributes/unitkerja/1') }}",
                        'success': function (data) {

                          daySelect = document.getElementById('cari_unit_kerja');

                         
                          for(i =0 ;i<data.length;i++){
                            var value = "";
                            var desc = data[i].DESCRIPTION;
                            if(desc.split("Cabang").length > 0 ){
                              value = data[i].VALUE+"00";
                            }else{
                              value = "00"+data[i].VALUE;
                            }
                            daySelect.options[daySelect.options.length] = new Option(desc, value);
                          }
                             
                        }
                    });
                  }
                  function setDetailAnggaran(nd_surat){
                    if(nd_surat!=null)
                      $.ajax({
                          'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/filtered/') }}/"+nd_surat+"/anggaran",
                          'success': function (data) {
                              // alert(document.getElementById("stat_anggaran").value);
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
                                document.getElementById("tanggal").value = tgl_split[2]+"/"+tgl_split[1]+"/"+tgl_split[0];
                                if(data[0].status_anggaran != "1"&&data[0].persetujuan !="2"){
                                  document.getElementById("edit_button").style.display = "none";
                                  document.getElementById("save_button").style.display = "none";
                                  document.getElementById("send_button").style.display = "none";
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
                  function getListData() {
                    $.ajax({
                          'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/filtered/'.$filters['nd_surat'].'/list_anggaran') }}",
                          'success': function (data) {
                              inputs = data;
                              download="";
                              for(i=0;i<data.length;i++){
                                list_berkas[i] = [];
                                list_berkas[i] = data[i]["file"];
                                for(j=0;j<list_berkas[i].length;j++){
                                  download+=list_berkas[i][j]["id"]+":db-";
                                }
                                // alert(JSON.stringify(data[i]["file"]));
                              }
                              var downloadHidden = $('<input/>',{type:'hidden',id:('db_file'),
                              name:('db_file'),value:download});
                              downloadHidden.appendTo("#file_grid");
                          }
                      });
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
                    if(document.getElementById("nd_surat").value==""){
                      toastr.error("Silahkan Isi Form Nomor Surat Terlebih Dahulu. Terima kasih.", "Perhatian.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    } else if(inputs.length < 1){
                      toastr.error("Silahkan tambahkan minimal 1 daftar anggaran untuk melakukan penyimpanan. Terima kasih.", "Minimal satu anggaran yang diisi.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    }else{
                      var stop = false;

                      status = {{ $status=='edit' ? 1 : 0 }};
                      for(i=0;i<inputs.length;i++){
                        nameClass = $('.file_'+i);
                        if(nameClass.length == 0){
                          // alert("kosong")
                          // toastr.error("Silahkan tambahkan berkas minimal 1 pada anggaran baris ke-"+(i+1)+" untuk melakukan penyimpanan. Terima kasih.", "Minimal satu berkas yang diunggah.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                          stop = true;
                          break;
                        }else{
                          count=0;
                          for(j=0;j<inputs.length;j++){
                            file = document.getElementById("file_name_"+i+"_"+j).value;
                            if(file=="null"){
                              count++;
                            }
                          }
                          if(count==nameClass.length){
                            // alert("null semua");
                            // toastr.error("Silahkan tambahkan berkas minimal 1 pada anggaran baris ke-"+(i+1)+" untuk melakukan penyimpanan. Terima kasih.", "Minimal satu berkas yang diunggah.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                            stop=true;
                          }
                        }
                        if(!stop){
                          var countFile = $('<input/>',{type:'hidden',id:('count_file_'+i),
                          name:('count_file_'+i),value:nameClass.length});
                          countFile.appendTo("#file_grid");
                        }
                      }
                      // alert(status==1);
                      if(status == 1){
                        stop = false;
                      }

                      if(stop){
                        toastr.error("Silahkan tambahkan berkas minimal 1 pada anggaran untuk melakukan penyimpanan. Terima kasih.", "Minimal satu berkas yang diunggah.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                      }else{
                        if(statusTable!="null"){
                          tampilan="";
                          judul="";
                          if(statusTable == "edit"){
                            judul = "Terdapat Anggaran masih dalam perubahan";
                            tampilan= "Silahkan Rubah dengan menekan tombol centang terlebih tahulu atau Batalkan dengan menekan tombol silang. Terima kasih.";
                          }else if("insert"){
                            judul = "Terdapat form masukan anggaran yang aktif";
                            tampilan= "Silahkan isi pada form masukkan anggaran dan tekan tombol tambah pada baris anggaran atau Batalkan dengan menekan tombol tambah di kepala tabel anggaran. Terima kasih.";
                          }

                          toastr.error(tampilan, judul, { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                        }else{
                          document.getElementById("setuju").value = "Simpan";
                          $('input[name="list_anggaran_values"]').val(JSON.stringify(inputs));
                          // alert(JSON.stringify(inputs));

                          $('form[id="insertAnggaran"]').submit();
                        } 
                      }
                    }
                  }
                  function sendAnggaran(){
                    // alert(inputs.length );
                    if(document.getElementById("nd_surat").value==""){
                      toastr.error("Silahkan Isi Form Nomor Surat Terlebih Dahulu. Terima kasih.", "Perhatian.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    } else if(inputs.length < 1){
                      toastr.error("Silahkan tambahkan minimal 1 daftar anggaran untuk melakukan penyimpanan. Terima kasih.", "Minimal satu anggaran yang diisi.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    }else{
                      status = {{ $status=='edit' ? 1 : 0 }};
                      var stop = false;
                      for(i=0;i<inputs.length;i++){
                        nameClass = $('.file_'+i);
                        if(nameClass.length == 0){
                          // toastr.error("Silahkan tambahkan berkas minimal 1 pada anggaran baris ke-"+(i+1)+" untuk melakukan penyimpanan. Terima kasih.", "Minimal satu berkas yang diunggah.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                          stop = true;
                          break;
                        }else{
                          count=0;
                          for(j=0;j<inputs.length;j++){
                            file = document.getElementById("file_name_"+i+"_"+j).value;
                            if(file=="null"){
                              count++;
                            }
                          }
                          if(count==nameClass.length){
                            // toastr.error("Silahkan tambahkan berkas minimal 1 pada anggaran baris ke-"+(i+1)+" untuk melakukan penyimpanan. Terima kasih.", "Minimal satu berkas yang diunggah.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                            stop=true;
                          }
                        }
                        if(!stop){
                          var countFile = $('<input/>',{type:'hidden',id:('count_file_'+i),
                          name:('count_file_'+i),value:nameClass.length});
                          countFile.appendTo("#file_grid");
                        }
                      }

                      if(status == 1){
                        stop = false;
                      }

                      if(stop){
                        toastr.error("Silahkan tambahkan berkas minimal 1 pada anggaran untuk melakukan penyimpanan. Terima kasih.", "Minimal satu berkas yang diunggah.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                      }else{
                        if(statusTable!="null"){
                          tampilan="";
                          judul="";
                          if(statusTable == "edit"){
                            judul = "Terdapat Anggaran masih dalam perubahan";
                            tampilan= "Silahkan Rubah dengan menekan tombol centang terlebih tahulu atau Batalkan dengan menekan tombol silang. Terima kasih.";
                          }else if("insert"){
                            judul = "Terdapat form masukan anggaran yang aktif";
                            tampilan= "Silahkan isi pada form masukkan anggaran dan tekan tombol tambah pada baris anggaran atau Batalkan dengan menekan tombol tambah di kepala tabel anggaran. Terima kasih.";
                          }

                          toastr.error(tampilan, judul, { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                        }else{
                          document.getElementById("setuju").value = "Kirim";
                          // $('input[name="list_anggaran_values"]').val(JSON.stringify(inputs));
                          alert(JSON.stringify(inputs));
                          // $('form[id="insertAnggaran"]').submit();
                        }
                      }
                    }
                  }
                  function readerPrev(index, tempIdCount){
                    // tempIdCount++;
                    var reader = new FileReader();
                    // alert(tempIdCount+";"+index);
                    reader.readAsDataURL(upload_file[tempIdCount][index]);
                    reader.onload = function () {
                      if(document.getElementById('file_'+tempIdCount+'_'+index)==null){
                        var hiddenInput = $('<input/>',{type:'hidden',id:('file_'+tempIdCount+'_'+index),
                        name:('file_'+tempIdCount+'_'+index),value:reader.result});
                        var hiddenInput2 = $('<input/>',{type:'hidden',id:('file_name_'+tempIdCount+'_'+index),
                        name:('file_name_'+tempIdCount+'_'+index),value:upload_file[tempIdCount][index]["name"]}).addClass("file_"+tempIdCount);;
                        var hiddenInput3 = $('<input/>',{type:'hidden',id:('file_type_'+tempIdCount+'_'+index),
                        name:('file_type_'+tempIdCount+'_'+index),value:upload_file[tempIdCount][index]["type"]});
                        var hiddenInput4 = $('<input/>',{type:'hidden',id:('file_size_'+tempIdCount+'_'+index),
                        name:('file_size_'+tempIdCount+'_'+index),value:upload_file[tempIdCount][index]["size"]});
                        hiddenInput.appendTo("#file_grid");
                        hiddenInput2.appendTo("#file_grid");
                        hiddenInput3.appendTo("#file_grid");
                        hiddenInput4.appendTo("#file_grid");
                      }else{
                        document.getElementById('file_'+tempIdCount+'_'+index).value = reader.result;
                        document.getElementById('file_name_'+tempIdCount+'_'+index).value = upload_file[tempIdCount][index]["name"];
                        document.getElementById('file_type_'+tempIdCount+'_'+index).value = upload_file[tempIdCount][index]["type"];
                        document.getElementById('file_size_'+tempIdCount+'_'+index).value = upload_file[tempIdCount][index]["size"];
                      }
                      

                    };
                  }
                  function setModalFile(index) {
                    $('#files').replaceWith($('#files').val('').clone(true));
                    $('#list_file').empty();
                    $('#list_download').empty();
                    banyak = 0;
                    hasil2 = []
                    if(list_berkas.length>0){
                      for(i = 0; i<list_berkas[index].length; i++){
                        link = "{{url('anggaran/get/download')}}/"+list_berkas[index][i]['id'];
                        hasil2[i] = '<div class="col-xs-10"><a href="'+link+'" ><li>'+list_berkas[index][i]['name']+'</li></div>';
                        hasil2[i] += '<div class="col-xs-1"><i class="fa fa-download "></i></div></a><br/><br/>';
                        // hasil2[i] += '<div class="col-xs-1" onclick="deleteRowFile('+i+','+index+')"><i class="fa fa-close " style="color:red"></i></div><br/><br/>';
                      }
                      $("#list_download").append(hasil2);
                    }
                    if(convert_file[index]!=null){
                      var nameCon = "";
                      for(i = 0; i<convert_file[index].length; i++){
                        if(convert_file[index][i]!=null){
                          nameCon += '<div id="upload_'+i+'" ><div class="col-xs-10"> <li> '+convert_file[index][i]['name']+'</li></div>';
                          nameCon += '<div class="col-xs-2" onclick="deleteRowFile('+i+','+index+')"><i class="fa fa-close "></i></div><br/><br/></div>';
                          
                        }
                      }
                     $("#list_file").append(nameCon);
                    }
                    index_modal = index;
                    if(document.getElementById('files') !=null ){
                      document.getElementById('files').onchange = function () {;
                        // hasil=[];
                        $('#list_file').empty();
                        value = this.files;
                        upload_file[index]=[];
                        for(i = banyak; i<(banyak+value.length); i++){
                          hasil[i] = '<div id="upload_'+i+'" ><div class="col-xs-10"> <li> '+value[(i-banyak)]['name']+'</li></div>';
                          hasil[i] += '<div class="col-xs-2" onclick="deleteRowFile('+i+','+index+')"><i class="fa fa-close "></i></div><br/><br/></div>';
                          upload_file[index][i]=value[(i-banyak)];
                          readerPrev(i,index);
                        }
                        
                        banyak+=value.length; 
                        $("#list_file").append(hasil);
                      };
                    }
                      
                    $('#modal_berkas').modal({
                        backdrop: 'static'
                    })
                  }
                  function deleteRowFile(i,index){
                      $("#upload_"+i).remove();
                      hasil[i] = "";
                      upload_file[index][i] = null;
                      // alert(upload_file[0].length);
                      document.getElementById('file_'+index+'_'+i).value="null";
                      document.getElementById('file_name_'+tempIdCount+'_'+index).value = "null";
                      document.getElementById('file_type_'+tempIdCount+'_'+index).value = "null";
                      document.getElementById('file_size_'+tempIdCount+'_'+index).value = "null";
                  }
                  $('#simpan_file').click(function() {
                    simpan_file =true;
                    convert_file[index_modal]=[];
                    convert_file[index_modal]=upload_file[index_modal];
                    $('#modal_berkas').modal('hide');
                  });
                  window.setUnitKerja({{$userCabang.",".$userDivisi}});
                  window.setDetailAnggaran('{{$filters['nd_surat']}}');
                  window.getListData();
                </script>
                @endsection