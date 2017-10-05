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
                                        <input id="tw_dari" name="tw_dari" class="form-control"readOnly>
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
                                        
                                        <input id="tw_ke" name="tw_ke" class="form-control" readOnly>
                                        
                                      </div>
                                    </div>
                                    
                                  </div>

                                  
                                  <div class="col-xs-10">
                                    
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
                                    <input type="hidden" name="id_form_master" id="id_form_master" value="{{$setting['id_form_master']}}">
                                    @if($setting['table'])
                                    <div id="file_grid"></div>
                                      <!-- <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p> -->
                                    <div class="col-xs-12">
                                      <div id="basicScenario"></div>
                                    </div>
                                    @endif
                                  </div>

                                  @if($setting['edit'])
                                  <div class="row col-xs-12" style="display:block">
                                    <br />
                                    <div class="pull-right">
                                      <div class="form-group">
                                        <div class="btn btn-success" onclick="check()"><i class="fa fa-send"></i> Kirim</div>
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                                </div>
                                
                                </form>
                            </div>
                        </div>
                      </div>
                    </section>
                    <!-- Basic scenario end -->
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
                  var inputs = [];
                  var tempIdCounter = 0;
                  var insertable = {{$setting['insert']?1:0}};
                  var editable = {{$setting['edit']?1:0}};
                  var unit_field_insert,unit_field_edit = null;
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
                      deleteConfirm: "Apakah anda yakin akan menghapus anggaran baris ini?",

                      controller: {
                        loadData: function(filter) {
                          return $.ajax({
                              type: "GET",
                              url:"",
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
                          
                          

                        },
                        updateItem: function(item) {
                          item["delete"]="none";
                          inputs.splice(item["tempId"]-1, 1, item);  
                          
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
                                  
                              });
                           }, 200);
                      },
                      fields: [
                          {
                            name: "id",
                            css: "hide",
                            width: 0,

                          },
                          {
                            name: "control",
                            type: "control",
                            css:editable == 1 ?"":"hide",
                            width: 50,

                          },
                          
                          { name: "nama_program", 
                            type: "text", 
                            title: "Nama Program", 
                            width: 170,
                            validate: {
                              message : "Isi nama program terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value!="";
                              } 
                            }
                          },

                          { name: "latar_belakang", 
                            type: "textarea", 
                            title: "Latar Belakang Alasan", 
                            width: 300,
                            validate: {
                              message : "Isi Latar Belakang Alasan terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value!="";
                              } 
                            }
                          },
                          { name: "dampak_positif", 
                            type: "textarea", 
                            title: "Dampak(+) Pelakasanaan bagi Perusahaan", 
                            width: 500,
                            validate: {
                              message : "Isi Dampak Positif terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value!="";
                              } 
                            }
                          },
                          { name: "dampak_negatif", 
                            type: "textarea", 
                            title: "Dampak(-) Tidak Dilaksanakan", 
                            width: 500,
                            validate: {
                              message : "Isi Dampak Negatif terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value!="";
                              } 
                            }
                          },

                          {
                            name: "control",
                            type: "control",
                            css:editable == 1 ?"":"hide",
                            width: 50,

                          }
                      ]
                    })
                    
                  });

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
                    // alert('{{ url('pelaporan/get/filtered/'.$filters['id'].'/form_master') }}');
                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('pelaporan/get/filteredMaster/usulan_program/0') }}",
                        'success': function (data) {

                          tanggal = document.getElementById('tanggal');
                          tw_dari = document.getElementById('tw_dari');
                          tw_ke = document.getElementById('tw_ke');
                          // alert(JSON.stringify(data));

                          now = data[0].created_at.split(' ')
                          tanggal.value = now[0];
                          tw_dari_val="";
                          tw_ke_val="";
                          // alert(data[0].tw_dari+data[0].tw_ke);
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
                          tw_dari.value = tw_dari_val;
                          tw_ke.value = tw_ke_val;

                          @if($type=="master")
                          tanggal_mulai = document.getElementById('tanggal_mulai');
                          tanggal_selesai = document.getElementById('tanggal_selesai');
                          tanggal_mulai.value = data[0].tanggal_mulai;
                          tanggal_selesai.value = data[0].tanggal_selesai;
                          id_form_master = document.getElementById('id_form_master');
                          id_form_master.value = data[0].id;
                          @endif

                          // alert(data[0].tanggal_selesai);

                          @if($type=="item")
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
                                    document.getElementById("nd_surat").disabled  = true;
                                    document.getElementById("unit_kerja").disabled  = true;
                                    document.getElementById("tipe_anggaran").disabled  = true;
                                    document.getElementById("stat_anggaran").disabled  = true;
                                    document.getElementById("save").style.display = "none";
                                    document.getElementById("send").style.display = "none";
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
                          'url': "{{ ($type == 'item' ? url('pelaporan/get/filteredMaster/usulan_program/1') : url('pelaporan/get/filtered/'.$filters['id'].'/'.$setting['kategori'])) }}",
                          'success': function (data) {
                              inputs = data;
                              download="";
                              for(i=0;i<data.length;i++){

                                inputs[i]["delete"]="none";
                                inputs[i]["tempId"]= tempIdCounter++;
                                @if($setting['kategori'] == "laporan_anggaran")
                                inputs[i]['uraian_progress']="";
                                @endif
                                @if($setting['kategori'] == "arahan_rups")
                                inputs[i]['progres_tindak_lanjut']="";
                                @endif
                                for(j=0;j<inputs[i]["file"].length;j++){
                                  inputs[i]["file"][j]["delete"]="none";
                                }
                              }
                          }
                          
                      });
                  }

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
                      max_dari_date = new Date(now_year, bulan_dari+3, 0);
                      min_ke_date = new Date(now_year, bulan_ke, 1);
                      max_ke_date = new Date(now_year, bulan_ke+3, 0);

                      min_hari_dari = min_dari_date.getDate();
                      max_hari_dari = max_dari_date.getDate();
                      min_hari_ke = min_ke_date.getDate();
                      max_hari_ke = max_ke_date.getDate();

                      min_bulan_dari = min_dari_date.getMonth()+1;
                      max_bulan_dari = max_dari_date.getMonth()+1;
                      min_bulan_ke = min_ke_date.getMonth()+1;
                      max_bulan_ke = max_ke_date.getMonth()+1;

                      min_dari = now_year+"-"+(min_bulan_dari<9?"0":'')+min_bulan_dari+"-"+(min_hari_dari<9?"0":'')+min_hari_dari;
                      max_dari = now_year+"-"+(max_bulan_dari<9?"0":'')+max_bulan_dari+"-"+(max_hari_dari<9?"0":'')+max_hari_dari;
                      min_ke = now_year+"-"+(min_bulan_ke<9?"0":'')+min_bulan_ke+"-"+(min_hari_ke<9?"0":'')+min_hari_ke;
                      max_ke = now_year+"-"+(max_bulan_ke<9?"0":'')+max_bulan_ke+"-"+(max_hari_ke<9?"0":'')+max_hari_ke;
                      // tanggal_mulai.setAttribute("min", '2013-12-9');

                      tanggal_mulai.setAttribute("max",max_dari);
                      tanggal_mulai.setAttribute("min",min_dari);

                      tanggal_selesai.setAttribute("max",max_ke);
                      tanggal_selesai.setAttribute("min",min_ke);
                      // alert(min_dari+":"+max_ke);
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

                  window.setUnitKerja();
                  @if($setting['status']=='Lihat'||$setting['status']=="Tambah")
                  window.setDetailFormMaster();
                  @endif
                  @if($setting['status']=="Tambah"&&$type=="master")
                  window.setTWFirst();
                  @endif


                </script>
                @endsection