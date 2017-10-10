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
                        <h3 class="content-header-title mb-0">{{$sub_title==''?$title:$sub_title}}</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index-2.html">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">{{$title}}
                                    </li>
                                    @if($sub_title != "")
                                    <li class="breadcrumb-item active">{{$sub_title}}
                                    </li>
                                    @endif
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body"><!-- Basic scenario start -->
                    <section id="basic">
                      
                      <div class="row">
                        <div class="card">
                            <div class="card-body collapse in">
                                <div class="card-block">
                                  <form method="POST" action="{{url('pelaporan/submit/tambah') }}" id="insertLaporanAnggaran" name="insertLaporanAnggaran" enctype="multipart/form-data">
                                  <div class="row">
                                  <div class="col-xs-10">
                                    {{ csrf_field() }}
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                          <label>Tanggal</label>
                                          @if($setting['insert'])
                                          <input id="tanggal" name="tanggal" class="form-control" value="{{date('d/m/Y')}}"readOnly>
                                          @else
                                          <input id="tanggal" name="tanggal" class="form-control" readOnly>
                                          @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                      <div class="form-group">
                                        <label>TW</label>

                                        @if($setting['status']=="Edit"&& $type == "master")
                                        <select class="select2 form-control" name="tw_dari" id="tw_dari" onchange="changeTW(0)">
                                          <option value="0">None</option>
                                          <option value="1">I</option>
                                          <option value="2">II</option>
                                          <option value="3">III</option>
                                          <option value="4">IV</option>
                                        </select>
                                        @else
                                        <input id="tw_dari" name="tw_dari" class="form-control"readOnly>
                                        @endif
                                      </div>
                                    </div>
                                    <div class="col-xs-1">
                                      <div class="form-group">
                                        <div style="visibility:hidden">a</div>
                                        <div style="visibility:hidden">a</div>
                                        <label>s/d</label>
                                      </div>
                                    </div>
                                    <div class="col-xs-2">
                                      <div class="form-group">
                                        <label>TW</label>
                                         @if($setting['status']=="Edit"&& $type == "master")
                                        <select class="select2 form-control" name="tw_ke" id="tw_ke" onchange="changeTW(1)">
                                          <option value="0">None</option>
                                          <option value="1">I</option>
                                          <option value="2">II</option>
                                          <option value="3">III</option>
                                          <option value="4">IV</option>
                                        </select>
                                        @else
                                        <input id="tw_ke" name="tw_ke" class="form-control" readOnly>
                                        @endif
                                      </div>
                                    </div>
                                    
                                  </div>

                                  
                                  <div class="col-xs-10">
                                    @if($type=="master")
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                          <label>Tanggal Mulai</label>
                                          @if($setting['insert'])
                                          <input type="date" id="tanggal_mulai" name="tanggal_mulai" onchange="startDate()" class="form-control">
                                          @else
                                          <input id="tanggal_mulai" name="tanggal_mulai" class="form-control" readOnly>
                                          @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                          <label>Tanggal Selesai</label>
                                          @if($setting['insert'])
                                          <input type="date"  id="tanggal_selesai" name="tanggal_selesai" class="date form-control">
                                          @else
                                          <input id="tanggal_selesai" name="tanggal_selesai" class="form-control" readOnly>
                                          @endif
                                        </div>
                                    </div>
                                    @endif
                                    @if($type=="item")
                                    <div class="col-xs-3">
                                      <div class="form-group">
                                        <label >Batas Waktu Pengisian &nbsp; :</label>
                                        <input id="bts_hari" name="bts_hari" class="form-control" value="---" readonly>
                                      </div>
                                    </div>
                                    <div class="col-xs-3">
                                      <div class="form-group">
                                        <label>&nbsp;</label>
                                        <input id="bts_jam" name="bts_jam" class="form-control" value="---" readonly>
                                      </div>
                                    </div>
                                    <div class="col-xs-3">
                                      <div class="form-group">
                                        <label>&nbsp;</label>
                                        <input id="bts_menit" name="bts_menit" class="form-control" value="---" readonly>
                                      </div>
                                    </div>
                                    <div class="col-xs-3">
                                      <div class="form-group">
                                        <label>&nbsp;</label>
                                        <input id="bts_detik" name="bts_detik" class="form-control" value="---" readonly>
                                      </div>
                                    </div>
                                    @endif
                                  </div>
                                  <hr />
                                  <div class="col-xs-12">
                                    <input type="hidden" name="item_form_master" id="item_form_master">
                                    <input type="hidden" name="kategori" id="kategori" value="{{$setting['kategori']}}">
                                    <input type="hidden" name="status" id="status" value="{{$setting['status']}}">
                                    <input type="hidden" name="kondisi" id="kondisi" value="">
                                    <input type="hidden" name="id_form_master" id="id_form_master" value="{{$setting['id_form_master']}}">
                                    <input type="hidden" name="jenis_berkas" id="jenis_berkas" value="{{$setting['jenis_berkas']}}">
                                    @if($setting['table'])
                                    <div id="file_grid"></div>
                                      <!-- <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p> -->
                                    <div class="col-xs-12">
                                      <div id="basicScenario"></div>
                                    </div>
                                    @endif
                                  </div>
                                  {{$beda?1:0}}

                                  <div class="row col-xs-12">
                                    <div class="col-xs-12" style="display:block">
                                      <br />
                                      <div class="col-xs-3">
                                        <div class="form-group">
                                          <div onclick="download_post()" class="btn btn-secondary" target="_blank"><i class="fa fa-download"></i> Unduh</div>
                                        </div>
                                      </div>

                                      <div class="col-xs-7">
                                      </div>
                                      @if($setting['edit']&&$beda)
                                      <div class="col-xs-1 pull-right">
                                        <div class="form-group">
                                          <div class="btn btn-success" onclick="check('Kirim')"><i class="fa fa-send"></i> Kirim</div>
                                        </div>
                                      </div>
                                      <div class="col-xs-2 pull-right">
                                        <div class="form-group">
                                          <div class="btn btn-info" onclick="check('Simpan')"><i class="fa fa-save"></i> Simpan</div>
                                        </div>
                                      </div>
                                      @endif
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
                          <h4 class="modal-title" id="titleModal">Berkas Pendukung</h4>
                      </div>
                      <div class="modal-body" id="confirmation-msg">
                        <div class="row">
                          <div class="col-md-12" id="list_download">
                          </div>
                          <div class="col-md-12" id="list_file">
                          </div>
                          <br />
                          <br />
                          @if($beda)
                          <input type="file" id="files" name="files" multiple>
                          @endif
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                        @if($beda)
                        <div id="simpan_file" class="btn btn-outline-primary">Simpan</div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                @endsection

                <div class="modal fade text-xs-left" id="modal_pernyataan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20"
                aria-hidden="true">
                  <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="title_modal_pernyataan">Pernyataan Pengiriman Form Master Laporan Anggaran Kegiatan</h4>
                      </div>
                      <div class="modal-body" id="confirmation-msg">
                        <div class="row">
                          <div class="col-md-12" id="teks_pernyataan">
                            <p>Apakah anda yakin Akan Mengirim Form Master Laporan Anggaran Kegiatan Kepada Unit Kerja Renbang?</p>
                          </div>
                          
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Tidak, kembali</button>
                        <button type="button" id="button_peryataan" onclick="sumbit_post()" class="btn btn-outline-primary">Ya, kirim</button>
                      </div>
                    </div>
                  </div>
                </div>

                <form method="GET" action="{{url('pelaporan/reports/export')}}" id="downloadPelaporan" name="downloadPelaporan" enctype="multipart/form-data">
                    
                    <input type="hidden" name="kategori_download" id="kategori_download" value="{{$setting['kategori']}}">              
                    <input type="hidden" name="header_pelaporan_download" id="header_pelaporan_download">
                    <input type="hidden" name="list_pelaporan_download" id="list_pelaporan_download">
                </form> 

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
                  var inputs = [];
                  var upload_file = [];
                  var temp_file = [];
                  var hasil = [];
                  var count_file=0;
                  var tempIdCounter = 0;
                  var insertable = {{($setting['insert']&&$beda)?1:0}};
                  var editable = {{($setting['edit']&&$beda)?1:0}};
                  var unit_field_insert,unit_field_edit = null;
                  var click_berkas = true;
                  var statusTable = "";
                  var simpan_file = false;
                  $(document).ready(function() {

                    $("#basicScenario").jsGrid( {
                      width: "100%",
               
                      sorting: true,
                      paging: true,
                      autoload: true,

                      inserting: insertable == 1 ? true : false,
                      editing: editable == 1 ? true : false,
                      pageSize: 5,
                      pageButtonCount: 10,
                      noDataContent: "Data Belum Tersedia",
                      loadMessage: "Mohon, ditunggu...",
                      deleteConfirm: "Apakah anda yakin akan menghapus anggaran baris ini?",

                      controller: {
                        loadData: function(filter) {
                          return $.ajax({
                              type: "GET",
                              url:"{{ url('pelaporan/get/filtered/'.$type.'/'.$filters['id'].'/'.$setting['kategori']) }}",
                              data: filter,
                              dataType: "JSON"
                          })
                        },
                        insertItem: function (item) {
                          if(inputs.length >0){
                            item['file'] = inputs.length;
                          }else{
                            item['file'] = tempIdCounter;
                          }
                          
                          item["isNew"] = true;
                          item["tempId"] = tempIdCounter++;
                          item["id"] = -1;
                          item["id_before"] = 0;
                          item["delete"]="none";
                                                      
                          inputs.push(item);
                          click_berkas = true;
                          if(upload_file[item["tempId"]]!=null){
                            for(i = 0 ;i< upload_file[item["tempId"]].length;i++){
                              readerPrev(i,item["tempId"]);
                            }
                          } 
                          

                        },
                        updateItem: function(item) {
                          // alert(item["tempId"]);
                          item["delete"]="none";
                          if(item["isNew"]){
                            inputs.splice(item["tempId"], 1, item); 
                          }else{
                            if(inputs.length>0){
                              for(i=0;i<inputs.length;i++){
                                if(inputs[i]["id"]==item.id){
                                  item["tempId"]=inputs[i]["tempId"];
                                  if(inputs[i]["file"].length>0){
                                    for(j=0;j<inputs[i]["file"].length;j++){
                                      item["file"][j]["delete"]=inputs[i]["file"][j]["delete"];
                                    }
                                  }
                                  
                                  inputs[i] = item; 
                                }
                              }
                            }
                          }
                          click_berkas = true;

                        },
                      }, 

                      onItemEditing: function(args) {

                          // delete_temp = [];
                          if(statusTable=="edit"){
                            // console.log ("Cancel",     ); 
                            args.cancel =true;
                          }
                          statusTable = "edit";
                           window.setTimeout(function() {
                              $('.jsgrid-cancel-edit-button').one('click.avoidAuthorClickHandler', function() {
                                  statusTable = "null";

                                  click_berkas = true;
                                  
                              });
                           }, 200);
                      },
                      onItemDeleted:function(args){
                        for(i=0;i<inputs.length;i++){
                          if(inputs[i]['id']==args.item['id']){
                            if(args.item["id"]==-1){
                              if(inputs[i]['tempId']==args.item['tempId']){
                                inputs[i]["delete"]="delete";
                              }
                            }else{
                              inputs[i]["delete"]="delete";
                            }
                            
                            break;
                          }else{
                          }
                        }
                          statusTable = "null";

                      },
                      onItemUpdated: function(args) {
                          statusTable = "null";
                      },

                      onItemInserted:function(args){
                        statusTable = "null";
                      },
                      fields: [
                          {
                            name: "id",
                            css: "hide",
                            width: 0,

                          },
                          {
                            name: "tempId",
                            css: "hide",
                            width: 0,

                          },
                          {
                            name: "control",
                            type: "control",
                            css:editable == 1 ?"":"hide",
                            width: 50,
                            @if(($setting['status']=="Edit"&&$type=="master")&&$beda)
                              deleteButton: true,
                            @else
                              deleteButton: false,
                            @endif

                          },
                          { name: "unit_kerja", 
                            type: "select",
                            title: "Unit Kerja", 
                            width: 130,
                            align: "left",
                            readOnly:insertable == 1 ? false : true,
                            valueField: "DESCRIPTION", 
                            textField: "DESCRIPTION", 
                            items: getData('unitkerja'),
                            validate: {
                              message : "Pilih Unit Kerja Terlebih Dahulu." ,
                              validator :function(value, item) {
                                  return value != "None" ;
                              } 
                            }
                          },
                          @if($setting['kategori'] == "arahan_rups")
                          { name: "jenis_arahan", 
                            type: "select", 
                            title: "Jenis Arahan", 
                            width: 170,
                            readOnly:insertable == 1 ? false : true,
                            valueField: "arahan_rups", 
                            textField: "arahan_rups", 
                            items: getData('arahanrups'),
                            validate: {
                              message : "Pilih Jenis Arahan terlebih Dahulu." ,
                              validator :function(value, item) {
                                  return value != "None" ;
                              } 
                            }
                          },
                          { name: "arahan", 
                            type: "textarea", 
                            title: "Arahan", 
                            readOnly:insertable == 1 ? false : true,
                            width: 300,
                            validate: {
                              message : "Isi Arahan terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value != "" ;
                              } 
                            }
                          },
                          @if($type== "item")
                          { name: "progress_tindak_lanjut", 
                            type: "textarea", 
                            title: "Progres Tindak Lanjut", 
                            width: 300,
                            validate: {
                              message : "Isi Progres Tindak Lanjut terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value != "";
                              } 
                            }
                          },
                          @endif
                          @endif

                          @if($setting['kategori'] == "laporan_anggaran")
                          { name: "program_prioritas", 
                            type: "select", 
                            readOnly:insertable == 1 ? false : true,
                            title: "Program Prioritas", 
                            width: 170,
                            valueField: "program_prioritas", 
                            textField: "program_prioritas", 
                            items: getData('programprioritas'),
                            validate: {
                              message : "Pilih Program Prioritas terlebih Dahulu." ,
                              validator :function(value, item) {
                                  return value !="None" ;
                              } 
                            }
                          },
                          { name: "sasaran_dicapai", 
                            type: "textarea", 
                            title: "Sasaran Yang ingin Di Capai", 
                            readOnly:insertable == 1 ? false : true,
                            width: 300,
                            validate: {
                              message : "Isi Saran yang ingin di capai terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value != "" ;
                              } 
                            }
                          },

                          @if($type == "item")
                          { name: "uraian_progress", 
                            type: "textarea", 
                            title: "Uraian Progress", 
                            width: 300,
                            validate: {
                              message : "Isi Uraian Progress yang ingin di capai terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value!="";
                              } 
                            }
                          },
                          @endif
                          @endif
                          @if($setting['berkas'])
                          { name: "file", align:"center", title: "Berkas",  width: 150 ,

                            itemTemplate: function(value,item) {
                              // alert("null");
                              var id_list=0;
                              var count_berkas=0;
                              for(i=0;i<inputs.length;i++){
                                if(inputs[i]["id"]==item.id){
                                  id_list = inputs[i]["tempId"];
                                }
                              }

                              if(value.length>0){
                                for(i =0;i<value.length;i++){
                                  count_berkas++;
                                }
                              }
                              if(upload_file[id_list] != null){
                                for(i=0;i<upload_file[id_list].length;i++){
                                  if(upload_file[id_list][i]!=null){
                                    count_berkas++;
                                  }
                                }
                              }
                              
                              var title="";
                              // document.getElementById('button_'+index_modal).innerHTML = countFile+" Berkas";
                              if(count_berkas==0){
                                @if(!$beda)
                                title = "Berkas";
                                @else
                                title = "Unggah Berkas";
                                @endif
                                
                              }else{
                                title = count_berkas+" Berkas";
                              }
                              var button = "<span class='btn btn-sm btn-primary' id='button_"+id_list+"' onclick='setModalFile("+id_list+")' >"+title+"</span>";
                              return button;
                            },

                            insertTemplate: function() {
                              var id_list;
                              if(inputs.length>0){
                                id_list=inputs.length;
                              }else{
                                id_list=tempIdCounter;
                              }
                              var count_berkas=0;
                              if(upload_file[id_list] != null){
                                for(i=0;i<upload_file[id_list].length;i++){
                                  if(upload_file[id_list][i]!=null){
                                    count_berkas++;
                                  }
                                }
                              }
                              var title="";
                              if(count_berkas == 0){
                                @if(!$beda)
                                title = "Berkas";
                                @else
                                title = "Unggah Berkas";
                                @endif
                              }else{
                                title = count_berkas+" Berkas";
                              }
                              var button = "<span class='btn btn-sm btn-primary' id='button_"+id_list+"' onclick='setModalFile("+id_list+")' >"+title+"</span>";
                              return button;
                            },
                            
                            editTemplate: function(value,item) {
                              // alert("update");
                              var count_berkas=0;
                              var id_list=0;
                              for(i=0;i<inputs.length;i++){
                                if(inputs[i]["id"]==item.id){
                                  id_list = inputs[i]["tempId"];
                                }
                              }


                              // var count_berkas=0;
                              if(value.length>0){
                                for(i =0;i<value.length;i++){
                                  // id_list = value[i]['count'];
                                  count_berkas++;
                                }
                              }
                              if(upload_file[id_list] != null){
                                for(i=0;i<upload_file[id_list].length;i++){
                                  if(upload_file[id_list][i]!=null){
                                    count_berkas++;
                                  }
                                }
                              }
                              var title="";
                              if(count_berkas==0){
                                @if(!$beda)
                                title = "Berkas";
                                @else
                                title = "Unggah Berkas";
                                @endif
                              }else{
                                title = count_berkas+" Berkas";
                              }
                              var button = "<span class='btn btn-sm btn-primary' id='button_"+id_list+"' onclick='setModalFile("+id_list+")' >"+title+"</span>";
                              return button;
                            },
                          },
                          @endif
                          {
                            name: "control",
                            type: "control",
                            css:editable == 1 ?"":"hide",
                            width: 50,
                            @if(($setting['status']=="Edit"&&$type=="master")&&$beda)
                              deleteButton: true,
                            @else
                              deleteButton: false,
                            @endif

                          }
                      ]
                    })
                    
                  });

                  function getData(type) {
                    var returned = function () {
                        var tmp = null;
                        $.ajax({
                            'async': false, 'type': "GET", 'dataType': 'JSON', 
                            'url': "{{ url('pelaporan/get/attributes') }}/" +type+"/-1",
                            'success': function (data) {
                                tmp = data;
                            }
                        });
                        return tmp;
                    }();
                    return returned;
                  }

                  function changeUnitKerja(){
                    unit_kerja = document.getElementById('unit_kerja').value;
                    $(unit_field_edit).val(unit_kerja);
                    $(unit_field_insert).val(unit_kerja);
                  }

                  function setUnitKerja(){
                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/attributes/unitkerja/1') }}",
                        'success': function (data) {

                          cari_unit_kerja = document.getElementById('cari_unit_kerja');
                          for(i =0 ;i<data.length;i++){
                            var value = "";
                            var desc = data[i].DESCRIPTION;
                            value = data[i].DESCRIPTION;
                            cari_unit_kerja.options[cari_unit_kerja.options.length] = new Option(desc, value);
                          }
                             
                        }
                    });
                  }

                  function setDetailFormMaster(){
                    
                    // $('input[type="date"]').datepicker();
                    // alert('{{ url('pelaporan/get/filtered/'.$type.'/'.$filters['id'].'/form_master') }}');
                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('pelaporan/get/filtered/'.$type.'/'.$filters['id'].'/form_master') }}",
                        'success': function (data) {
                          // alert(JSON.stringify(data[0]['data'].length));
                          tanggal = document.getElementById('tanggal');
                          tw_dari = document.getElementById('tw_dari');
                          tw_ke = document.getElementById('tw_ke');
                          // alert(JSON.stringify(data));
                          if({{($type=='item'&&$status='Tambah')?1:0}}){
                            document.getElementById('id_form_master').value = data[0].id;
                          }
                          now = data[0]['created_at']['date'].split(' ')
                          tanggal.value = now[0];
                          tw_dari_val="";
                          tw_ke_val="";
                          // alert(data[0].tw_dari+data[0].tw_ke)
                          switch(data[0].tw_dari){
                            case "1" : tw_dari_val = "I";break;
                            case "2" : tw_dari_val = "II";break;
                            case "3" : tw_dari_val = "III";break;
                            case "4" : tw_dari_val = "IV";break;
                          }
                          switch(data[0].tw_ke){
                            case "1" : tw_ke_val = "I";break;
                            case "2" : tw_ke_val = "II";break;
                            case "3" : tw_ke_val = "III";break;
                            case "4" : tw_ke_val = "IV";break;
                          }
                          

                          // alert(tw_dari_val);

                          @if($type=="master")
                          tw_dari.value = data[0].tw_dari;
                          tw_ke.value = data[0].tw_ke;
                          tanggal_mulai = document.getElementById('tanggal_mulai');
                          tanggal_selesai = document.getElementById('tanggal_selesai');
                          tanggal_mulai.value = data[0].tanggal_mulai;
                          tanggal_selesai.value = data[0].tanggal_selesai;
                          id_form_master = document.getElementById('id_form_master');
                          id_form_master.value = data[0].id;
                          @endif

                          // alert(data[0].tanggal_selesai);

                          @if($type=="item")
                          tw_dari.value = tw_dari_val;
                          tw_ke.value = tw_ke_val;
                          var countDownDate = new Date(data[0].tanggal_selesai).getTime();

                          var disableCountDown = true;
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
                                // document.getElementById("bts").innerHTML = days + "d " + hours + "h "
                                // + minutes + "m " + seconds + "s ";
                                
                                // If the count down is over, write some text 
                                if (distance < 0) {
                                    alert ("Waktu Memasukkan data anggaran dan kegiatan telah usai");
                                    clearInterval(x);
                                    document.getElementById("bts_hari").value= "---";
                                    document.getElementById("bts_jam").value= "---";
                                    document.getElementById("bts_menit").value= "---";
                                    document.getElementById("bts_detik").value= "---";
                                    document.getElementById("bts").innerHTML = "EXPIRED";
                                }
                            }, 1000);
                          }
                          @endif
                             
                        }
                    });
                  }

                  function getListData() {
                    $.ajax({
                          'async': false, 'type': "GET", 'dataType': 'JSON', 
                          'url': "{{ url('pelaporan/get/filtered/'.$type.'/'.$filters['id'].'/'.$setting['kategori']) }}",
                          'success': function (data) {
                              inputs = data;
                              download="";
                              for(i=0;i<data.length;i++){

                                inputs[i]["delete"]="none";
                                inputs[i]["tempId"]= tempIdCounter++;
                                for(j=0;j<inputs[i]["file"].length;j++){
                                  inputs[i]["file"][j]["delete"]="none";
                                }
                                list_berkas[i] = {};
                                list_berkas[i] = data[i]["file"];
                                // alert(tempIdCounter);
                                // alert(JSON.stringify(inputs[i]));
                              }
                          }
                          
                      });
                  }
                  function check(type){
                    var pernyataan = false;
                    if({{$type == "master"?1:0}}){
                      if(document.getElementById("tanggal_mulai").value == ""){
                        toastr.error("Silahkan Isi Tanggal Mulai Untuk memulai {{$title=='Form Master'?$title." ".$sub_title:$title}}. Terima kasih.", "Perhatian.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                      }else if(document.getElementById("tanggal_selesai").value == ""){
                        toastr.error("Silahkan Isi Tanggal Selesai sebagai acuan berakhirnya {{$title=='Form Master'?$title." ".$sub_title:$title}}. Terima kasih.", "Perhatian.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                      }else if(document.getElementById("tw_dari").value == "0"){
                        toastr.error("Pilih TW {{$title=='Form Master'?$title." ".$sub_title:$title}}. Terima kasih.", "Perhatian.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                      }else if(inputs.length == 0&&{{$setting['kategori']!="usulan_program"?1:0}}){
                        toastr.error("Silahkan Isi Minimal Satu daftar {{$title=='Form Master'?$title." ".$sub_title:$title}}. Terima kasih.", "Perhatian.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                      }else{
                        pernyataan = true;
                      }
                    }else{
                      pernyataan = true;
                    }

                    if(pernyataan){
                      for(i=0;i<inputs.length;i++){
                        nameClass = $('.file_'+i);
                        if(nameClass.length!=0){
                          var countFile = $('<input/>',{type:'hidden',id:('count_file_'+i),
                          name:('count_file_'+i),value:nameClass.length});
                          countFile.appendTo("#file_grid");
                        }
                      }

                      if(statusTable!="null"){
                        tampilan="";
                        judul="";
                        if(statusTable == "edit"){
                          judul = "Terdapat {{$title=='Form Master'?$title." ".$sub_title:$title}} masih dalam perubahan";
                          tampilan= "Silahkan Rubah dengan menekan tombol centang terlebih tahulu atau Batalkan dengan menekan tombol silang. Terima kasih.";
                        }

                        toastr.error(tampilan, judul, { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                      }else{
                        document.getElementById("kondisi").value = type;
                        var title_modal="";
                        var pernyataan_modal="";
                        if(type=="Simpan"){
                          title_modal="Pernyimpanan {{$title=='Form Master'?$title." ".$sub_title:$title}}";
                          pernyataan_modal = "<p>Apakah anda yakin Akan Menyimpan {{$title=='Form Master'?$title." ".$sub_title:$title}} ini?</p>";
                        }else if(type=="Kirim"){
                          title_modal="Pengajuan {{$title=='Form Master'?$title." ".$sub_title:$title}}";
                          pernyataan_modal = "<p>Apakah anda yakin Akan Mengajukan {{$title=='Form Master'?$title." ".$sub_title:$title}}?</p>";
                        }

                        // alert(document.getElementById("teks_pernyataan").innerHTML);
                        document.getElementById("title_modal_pernyataan").innerHTML = title_modal;
                        document.getElementById("teks_pernyataan").innerHTML = pernyataan_modal;
                        document.getElementById("button_peryataan").innerHTML = "Ya, "+type;

                        $('#modal_pernyataan').modal({
                              backdrop: 'static'
                          });
                        
                      } 
                    }
                  }

                  function startDate(){
                    start_date = document.getElementById('tanggal_mulai').value;
                    
                    var now = start_date.split('-');
                    var day ="" ;
                    var next = parseInt(now[2])+1;
                    if (next < 10){
                      day = "0"+next;
                    }else{
                      day = next;
                    }
                    var month = now[1];
                    var year = now[0];
                    mulai = year+"-"+month+"-"+day;
                    // alert(mulai);
                    document.getElementById("tanggal_selesai").min = mulai;
                  }
                  function readerPrev(index, tempIdCount){
                    // tempIdCount++;
                    var reader = new FileReader();
                    // alert(tempIdCount+";"+index);
                    if(upload_file[tempIdCount][index]!=null){
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
                    }else{
                      if(document.getElementById('file_'+tempIdCount+'_'+index)!=null){
                         document.getElementById('file_'+tempIdCount+'_'+index).value = "null";
                          document.getElementById('file_name_'+tempIdCount+'_'+index).value = "null";
                          document.getElementById('file_type_'+tempIdCount+'_'+index).value = "null";
                          document.getElementById('file_size_'+tempIdCount+'_'+index).value = "null";
                      }
                    }
                    
                  }
                  function setModalFile(index) {
                    if(click_berkas){
                      $('#files').replaceWith($('#files').val('').clone(true));
                      $('#list_file').empty();
                      $('#list_download').empty();
                      banyak = 0;
                      hasil2 = [];
                      
                      if( list_berkas[index]!=null){
                        if( list_berkas[index].length>0){
                          for(i = 0; i< list_berkas[index].length; i++){
                            if( list_berkas[index][i]!=null){
                              if(list_berkas[index][i]["delete"]=="none"){
                                link = "{{url('pelaporan/get/download')}}/"+ list_berkas[index][i]['id'];
                                hasil2[i] = '<div id="db_file_'+i+'"><div class="col-xs-10"><a href="'+link+'" ><li>'+ list_berkas[index][i]['name']+'</li></div>';
                                // alert({{$type=="item"?1:0}});
                                if((list_berkas[index][i]['is_template']==1&&{{$type=="master"?1:0}})&&{{$setting['status']=="Edit"?1:0}}){
                                  hasil2[i] += '<div class="col-xs-1" ><i class="fa fa-download "></i></div></a>';
                                  hasil2[i] += '<div class="col-xs-1" onclick="deleteFileDB('+i+')"><i style="color:red" class="fa fa-close "></i></div><br/><br/></div>';
                                }else if((list_berkas[index][i]['is_template']==0&&{{$type=="item"?1:0}})&&{{($setting['status']=="Edit"&&$beda)?1:0}}){
                                  hasil2[i] += '<div class="col-xs-1" ><i class="fa fa-download "></i></div></a>';
                                  hasil2[i] += '<div class="col-xs-1" onclick="deleteFileDB('+i+')"><i style="color:red" class="fa fa-close "></i></div><br/><br/></div>';
                                }else{
                                  hasil2[i] += '<div class="col-xs-2"><i class="fa fa-download "></i></div></a><br/><br/></div>';
                                }
                              }
                            }
                          }
                          $("#list_download").append(hasil2);
                        }
                      }

                      if(upload_file[index]!=null){
                        var nameCon = "";
                        for(i = 0; i<upload_file[index].length; i++){
                          if(upload_file[index][i]!=null){
                            nameCon += '<div id="upload_'+i+'" ><div class="col-xs-10"> <li> '+upload_file[index][i]['name']+'</li></div>';
                            nameCon += '<div class="col-xs-2" onclick="deleteRowFile('+i+','+index+')"><i class="fa fa-close "></i></div><br/><br/></div>';
                            temp_file[i]=upload_file[index][i];
                          }
                        }
                        banyak+=upload_file[index].length;
                       $("#list_file").append(nameCon);
                      }

                      //;
                      index_modal = index;
                      if(document.getElementById('files') !=null ){
                        document.getElementById('files').onchange = function () {
                          value = this.files;
                          for(i = banyak; i<(banyak+value.length); i++){
                            hasil[i] = '<div id="upload_'+i+'" ><div class="col-xs-10"> <li> '+value[(i-banyak)]['name']+'</li></div>';
                            hasil[i] += '<div class="col-xs-2" onclick="deleteRowFile('+i+','+index+')"><i class="fa fa-close "></i></div><br/><br/></div>';
                            temp_file[i]=value[(i-banyak)];
                          }
                          
                          banyak+=value.length; 
                          $("#list_file").append(hasil);
                        };
                      }
                      $('#modal_berkas').modal({
                          backdrop: 'static'
                      })
                    }else{
                      alert("Silahkan simpan atau batalkan perubahan data untuk menambah atau menghapus berkas kembali");
                    
                    }
                  }
                  function deleteRowFile(i,index){
                      $("#upload_"+i).remove();
                      hasil[i] = "";
                      temp_file[i] = null;
                  }
                  function deleteFileDB(i){
                      $("#db_file_"+i).remove();
                      hasil2[i] = "";
                  }
                  $('#simpan_file').click(function() {
                    click_berkas = false;
                    simpan_file =true;
                    countFile=0;
                    hasil=[];
                    // temp_file=[];
                     upload_file[index_modal]=[];
                    for(i=0;i<temp_file.length;i++){

                        // readerPrev(i,index_modal);
                        upload_file[index_modal][i]=temp_file[i];
                        if(temp_file[i]!=null){
                          countFile++;
                        }
                    }

                    for(i=0;i<hasil2.length;i++){
                      if(hasil2[i] == ""){
                        list_berkas[index_modal][i]["delete"]="delete";
                      }else{
                        countFile++;
                      }
                    }
                    var title = "Unggah Berkas";
                    if(countFile>0){
                      title=countFile+" Berkas"
                    }
                    temp_file=[];
                    document.getElementById('button_'+index_modal).innerHTML = title;
                    $('#modal_berkas').modal('hide');
                  });

                  function sumbit_post(){
                    $('input[name="item_form_master"]').val(JSON.stringify(inputs));
                    // alert(JSON.stringify(inputs));
                    $('form[id="insertLaporanAnggaran"]').submit();
                  }

                  function download_post(){
                    header={};
                    header['tanggal'] = $('#tanggal').val();
                    header['tw_dari'] = $('#tw_dari').val();
                    header['tw_ke'] = $('#tw_ke').val();

                    array = new Array();
                    array.push(header);
                    $('input[name="header_pelaporan_download"]').val(JSON.stringify(array));
                    $('input[name="list_pelaporan_download"]').val(JSON.stringify(inputs));
                    // alert(JSON.stringify(header));
                    $('form[id="downloadPelaporan"]').submit();
                  }
                  $('#modal_berkas').on('hidden.bs.modal', function () {
                      if(!simpan_file){
                        hasil=[];
                        temp_file=[];
                      }
                      simpan_file = false;
                  });

                  function changeTW(type){
                    tw_dari = document.getElementById('tw_dari').value;
                    if(type == 0){
                      document.getElementById('tw_ke').selectedIndex = tw_dari;
                      document.getElementById('select2-tw_ke-container').innerHTML = document.getElementById('tw_ke').options.item(tw_dari).text;
                      document.getElementById('select2-tw_ke-container').title = document.getElementById('tw_ke').options.item(tw_dari).text;
                    }
                    tw_ke = document.getElementById('tw_ke').value;
                    tanggal_mulai = document.getElementById('tanggal_mulai');
                    tanggal_selesai = document.getElementById('tanggal_selesai');
                    if(tw_dari > 0){
                      var bulan_dari = 0 + ((tw_dari-1)*3) ;
                      var bulan_ke = 0 + ((tw_ke-1)*3);
                      now_year = new Date().getFullYear();
                      now_month = new Date().getMonth();

                      min_dari_date = new Date(now_year, bulan_dari, 1);
                      // max_dari_date = new Date(now_year, bulan_dari+3, 0);
                      // min_ke_date = new Date(now_year, bulan_ke, 1);
                      max_ke_date = new Date(now_year, bulan_ke+3, 0);

                      min_hari_dari = min_dari_date.getDate();
                      // max_hari_dari = max_dari_date.getDate();
                      // min_hari_ke = min_ke_date.getDate();
                      max_hari_ke = max_ke_date.getDate();

                      min_bulan_dari = min_dari_date.getMonth()+1;
                      // max_bulan_dari = max_dari_date.getMonth()+1;
                      // min_bulan_ke = min_ke_date.getMonth()+1;
                      max_bulan_ke = max_ke_date.getMonth()+1;

                      min_dari = now_year+"-"+(min_bulan_dari<9?"0":'')+min_bulan_dari+"-"+(min_hari_dari<9?"0":'')+min_hari_dari;
                      // max_dari = now_year+"-"+(max_bulan_dari<9?"0":'')+max_bulan_dari+"-"+(max_hari_dari<9?"0":'')+max_hari_dari;
                      // min_ke = now_year+"-"+(min_bulan_ke<9?"0":'')+min_bulan_ke+"-"+(min_hari_ke<9?"0":'')+min_hari_ke;
                      max_ke = now_year+"-"+(max_bulan_ke<9?"0":'')+max_bulan_ke+"-"+(max_hari_ke<9?"0":'')+max_hari_ke;
                      

                      tanggal_mulai.setAttribute("max",max_ke);
                      tanggal_mulai.setAttribute("min",min_dari);

                      tanggal_selesai.setAttribute("max",max_ke);
                      tanggal_selesai.setAttribute("min",min_dari);
                    }
                  }

                  function setTWFirst(){
                    var status = '{{$setting['status']}}';
                    var type = '{{$type}}';

                    if(status != "Tambah"||type!="item"){
                        tw_dari = document.getElementById('tw_dari');
                      tw_ke = document.getElementById('tw_ke');

                      now = new Date().getMonth();
                      tw = 0;
                      if(now >=0 && now <=2){
                        tw = 1;
                      }else if(now >=3 && now <=5){
                        tw = 2;
                      }else if(now >=6 && now <=8){
                        tw = 3;
                      }else if(now >=9 && now <=11){
                        tw = 4;
                      }

                      tw_dari.value = tw;
                      tw_ke.value = tw_dari.value;
                      document.getElementById('select2-tw_dari-container').innerHTML = tw_dari.options.item(tw).text;
                      document.getElementById('select2-tw_dari-container').title = tw_dari.options.item(tw).text;
                      document.getElementById('select2-tw_ke-container').innerHTML = tw_ke.options.item(tw).text;
                      document.getElementById('select2-tw_ke-container').title = tw_ke.options.item(tw).text;
                        
                      changeTW(0);
                    }
                  }

                  window.setDetailFormMaster();
                  @if($setting['status']=="Tambah"&&$type=="master")
                  window.setTWFirst();
                  @endif
                  window.getListData();
                  // window.startDate();


                </script>
                @endsection