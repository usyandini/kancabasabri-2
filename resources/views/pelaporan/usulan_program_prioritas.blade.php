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
                                    {{ csrf_field() }}
                                  <div class="col-xs-12">
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                          <label>Tanggal</label>
                                          <input id="tanggal" name="tanggal" class="form-control" readOnly>
                                          
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

                                  
                                  <div class="col-xs-12">
                                    
                                    <div class="col-xs-3">
                                      <div class="form-group">
                                        <label>Unit Kerja</label>
                                        <input id="unit_kerja" name="unit_kerja" class="form-control" readOnly>
                                      </div>
                                    </div>
                                    <div class="col-xs-3">
                                      <div class="form-group">
                                        @if($mulai)
                                        <label >Batas Waktu Mulai Pengisian &nbsp; :</label>
                                        @else
                                        <label >Batas Waktu Pengisian &nbsp; :</label>
                                        @endif
                                        <input id="bts_hari" name="bts_hari" class="form-control" value="---" readonly>
                                      </div>
                                    </div>
                                    <div class="col-xs-2">
                                      <div class="form-group">
                                        <label>&nbsp;</label>
                                        <input id="bts_jam" name="bts_jam" class="form-control" value="---" readonly>
                                      </div>
                                    </div>
                                    <div class="col-xs-2">
                                      <div class="form-group">
                                        <label>&nbsp;</label>
                                        <input id="bts_menit" name="bts_menit" class="form-control" value="---" readonly>
                                      </div>
                                    </div>
                                    <div class="col-xs-2">
                                      <div class="form-group">
                                        <label>&nbsp;</label>
                                        <input id="bts_detik" name="bts_detik" class="form-control" value="---" readonly>
                                      </div>
                                    </div>
                                  </div>
                                  <hr />
                                  <div class="col-xs-12">
                                    <input type="hidden" name="item_form_master" id="item_form_master">
                                    <input type="hidden" name="kategori" id="kategori" value="{{$setting['kategori']}}">
                                    <input type="hidden" name="status" id="status" value="{{$setting['status']}}">
                                    <input type="hidden" name="kondisi" id="kondisi" value="">
                                    <input type="hidden" name="id_form_master" id="id_form_master" value="{{$setting['id_form_master']}}">
                                    <input type="hidden" name="jenis_berkas" id="jenis_berkas" value="{{$setting['jenis_berkas']}}">
                                    <div class="col-xs-12">
                                      <div id="basicScenario"></div>
                                    </div>
                                    
                                  </div>

                                  <div class="row col-xs-12">
                                    <div class="col-xs-12" style="display:block">
                                      <br />
                                      @if($setting['status'] != "Tambah")
                                      <div class="col-xs-3">
                                        <div class="form-group">
                                          <div div onclick="download_post()" class="btn btn-secondary" target="_blank"><i class="fa fa-download"></i> Unduh</div>
                                        </div>
                                      </div>
                                      @endif

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
                  var inputs = [];
                  var tempIdCounter = 0;
                  var insertable = {{($setting['insert']&&$beda)?1:0}};
                  var editable = {{($setting['edit']&&$beda)?1:0}};
                  var unit_field_insert,unit_field_edit = null;
                  var statusTable = "null";
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
                              url:"{{ url('pelaporan/get/filtered/item/'.$setting['id_form_master'].'/usulan_program') }}",
                              data: filter,
                              dataType: "JSON"
                          })
                        },
                        insertItem: function (item) {
                          
                          item["isNew"] = true;
                          item["tempId"] = tempIdCounter++;
                          item["id"] = -1;
                          item["delete"]="none";
                                                      
                          inputs.push(item);
                          statusTable = "null";
                        },
                        updateItem: function(item) {
                          item["delete"]="none";
                          if(item["isNew"]){
                            inputs.splice(item["tempId"], 1, item); 
                          }else{
                            if(inputs.length>0){
                              for(i=0;i<inputs.length;i++){
                                if(inputs[i]["id"]==item.id){
                                  item["tempId"]=inputs[i]["tempId"];
                                  inputs[i] = item;
                                }
                              }
                            }
                          }
                          statusTable = "null";
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
                          }
                        }
                        statusTable = "null";

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

                  function setDetailFormMaster(){
                    // alert("{{ url('pelaporan/get/filteredMaster/usulan_program/0/'.$setting['id_form_master']) }}");
                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('pelaporan/get/filteredMaster/usulan_program/0/'.$setting['id_form_master']) }}",
                        'success': function (data) {

                          tanggal = document.getElementById('tanggal');
                          tw_dari = document.getElementById('tw_dari');
                          tw_ke = document.getElementById('tw_ke');
                          unit_kerja = document.getElementById('unit_kerja');
                          // alert(JSON.stringify(data));
                          if({{($type=='item'&&$setting['status']=='Tambah')?1:0}}){
                            document.getElementById('id_form_master').value = data[0].id;
                            // alert(data[0].id);
                          }
                          now = data[0].created_at.split(' ')
                          tanggal.value = now[0];
                          unit_kerja.value = data[0].unit_kerja;
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

                          @if($type=="item")
                            @if($mulai)
                            var countDownDate = new Date(data[0].tanggal_mulai).getTime();
                            @else
                            var countDownDate = new Date(data[0].tanggal_selesai).getTime();
                            @endif
                          var disableCountDown = true;
                          if(disableCountDown){
                            var x = setInterval(function() {

                                // Get todays date and time
                                var now = new Date().getTime();
                                
                                // Find the distance between now an the count down date
                                @if($mulai)
                                // Find the distance between now an the count down date
                                var distance = now - countDownDate;
                                @else
                                // Find the distance between now an the count down date
                                var distance = countDownDate - now;
                                @endif
                                
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
                                    @if($mulai)
                                    alert ("Waktu Memasukkan data anggaran dan kegiatan telah dimulai");
                                    @else
                                    alert ("Waktu Memasukkan data anggaran dan kegiatan telah usai");
                                    @endif
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
                          'url': "{{url('pelaporan/get/filtered/item/'.$setting['id_form_master'].'/usulan_program')}}",
                          'success': function (data) {
                              inputs = data;
                              download="";
                              for(i=0;i<data.length;i++){

                                inputs[i]["delete"]="none";
                                inputs[i]["tempId"]= tempIdCounter++;
                                
                              }
                          }
                          
                      });
                  }

                  function check(type){
                    var pernyataan = false;
                    if(inputs.length == 0){
                      toastr.error("Silahkan Isi Minimal Satu daftar Usulan Program Prioritas. Terima kasih.", "Perhatian.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    }else{
                      pernyataan =true;
                    }


                    if(pernyataan){

                      if(statusTable!="null"){
                        tampilan="";
                        judul="";
                        if(statusTable == "edit"){
                          judul = "Terdapat Usulan Program Prioritas masih dalam perubahan";
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
                    header['unit_kerja'] = $('#unit_kerja').val();

                    array = new Array();
                    array.push(header);
                    $('input[name="header_pelaporan_download"]').val(JSON.stringify(array));
                    $('input[name="list_pelaporan_download"]').val(JSON.stringify(inputs));
                    //alert(JSON.stringify(header));
                    $('form[id="downloadPelaporan"]').submit();
                  }

                  window.setDetailFormMaster();
                  window.getListData();
                </script>
                @endsection