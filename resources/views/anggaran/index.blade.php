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
                                    <li class="breadcrumb-item"><a href="{{url('/anggaran')}}">Anggaran dan Kegiatan</a>
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
                                            <label>Tanggal Pengajuan</label>
                                            @if($status=='tambah')
                                            <input type="date" id="tanggal" name="tanggal" class="form-control">
                                            @else
                                            <input id="tanggal" name="tanggal" class="form-control" readonly>
                                            @endif
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-grpup">
                                            <label>Nomor ND/Surat</label>

                                            @if($status=='tambah')
                                               <input id="nd_surat" name="nd_surat" class="form-control">
                                            @else
                                                <input id="nd_surat" name="nd_surat" class="form-control" readonly>
                                            @endif

                                            <input id="id_anggaran" name="id_anggaran" type="hidden"/>
                                           
                                            
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-group">
                                            <label>Unit Kerja</label>
                                            <input id="unit_kerja" name="unit_kerja" class="form-control" readonly>
                                            <input id="view_unit_kerja" name="view_unit_kerja" class="form-control" type="hidden">
                                              
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-grpup">
                                            <label>Tipe Anggaran</label>
                                            @if($status=='tambah')
                                              <input id="tipe_anggaran" name="tipe_anggaran" class="form-control" readonly value="Original Budget">
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
                                      @if($status!="setuju")
                                      <div class="col-xs-6">
                                        <div class="row">
                                            <div class="col-xs-6">
                                              @if($mulai)
                                              <label>Batas Waktu Mulai Pengisian &nbsp; :</label>
                                              @else
                                              <label>Batas Waktu Pengisian &nbsp; :</label>
                                              @endif
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
                                      @endif
                                    </div>
                                    <input type="hidden" name="list_anggaran_values" id="list_anggaran_values">
                                    <input type="hidden" name="list_delete_anggaran" id="list_delete_anggaran">
                                    <div id="file_grid"></div>
                                    <input type="hidden" name="status" id="status" value="{{$status}}">
                                    <input type="hidden" name="setuju" id="setuju" >
                                      <!-- <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p> -->
                                    <div id="basicScenario"></div>

                                    <br />
                                    <div class="row col-xs-12" id="grup_uk">

                                      <div class="col-xs-3 ">
                                      </div>
                                      <div class="col-xs-2 ">
                                        @if($beda)
                                        <div class="form-group" id="save_button" style="display:{{$display['save']}}">
                                          <div id="save" name="save" onclick="check('Simpan')"class="btn btn-primary"><i class="fa fa-save"></i> Simpan</div>
                                        </div>
                                        @endif
                                      </div>
                                      <div class="col-xs-3 ">
                                      </div>
                                      <div class="col-xs-2" style="horizontal-align:center">
                                        @if($beda && Gate::check('kirim_a'))
                                        <div class="form-group" id="send_button" style="display:{{$display['send']}}">
                                          <div id="send" name="send" onclick="check('Kirim')" class="btn btn-success"><i class="fa fa-send"></i> Kirim</div>
                                        </div>
                                        @endif
                                      </div>
                                      <div class="col-xs-2 ">
                                        @if($beda)
                                        <div class="form-group" id="edit_button" style="display:{{$display['edit']}}">
                                          <a href="{{ url('anggaran/edit/'.$filters['nd_surat'].'/1') }}" id="edit" name="edit" class="btn btn-primary"><i class="fa fa-edit"></i> Ubah</a>
                                        </div>
                                        @endif
                                      </div>
                                    </div>

                                    <div class="row col-xs-12" id="grup_r" style="display:none">

                                      <div class="col-xs-2 ">
                                        <div class="form-group">
                                          <!-- <button type="submit" class="btn btn-secondary"><i class="fa fa-download"></i> Unduh</button> -->
                                          <div onclick="download_post()" id="download_r" name="download_r" class="btn btn-secondary" target="_blank"><i class="fa fa-download"></i> Unduh</div>
                                        </div>
                                      </div>
                                      <div class="col-xs-6 ">
                                      </div>
                                      <div id="grup_r_p" class="col-xs-4">
                                        <div class="col-xs-6">
                                          <div class="form-group">
                                            <!-- <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</button> -->
                                            <a href="{{url('anggaran/persetujuan/'.$filters['nd_surat'].'/3')}}" id="edit_r" name="edit_r"  class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
                                            <div onclick="check('Simpan')" id="save_r" name="save_r"  class="btn btn-primary" style="display:none"><i class="fa fa-save"></i> Simpan</div>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 ">
                                          <div class="form-group">
                                            <!-- <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Kirim</button> -->
                                            <div id="accept_r" name="accept_r" class="btn btn-success"  onclick="changeButton()"><i class="fa fa-check"></i> Disetujui</div>
                                            <div id="send_r" name="send_r" class="btn btn-success" style="display:none"><i class="fa fa-send"></i> Kirim</div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row col-xs-12" id="grup_m" style="display:none">

                                      <div class="col-xs-6 ">
                                        <div class="form-group">
                                          <!-- <button type="submit" class="btn btn-secondary"><i class="fa fa-download"></i> Unduh</button> -->
                                            <div onclick="download_post()" id="download_m" name="download_m" class="btn btn-secondary" target="_blank"><i class="fa fa-download"></i> Unduh</div>
                                        </div>
                                      </div>
                                      <div id="grup_m_p">
                                        <div class="col-xs-6 " >

                                          <div class="col-xs-3 pull-right">
                                            <div class="form-group">
                                              <!-- <button type="submit" class="btn btn-danger"><i class="fa fa-send"></i> Ditolak</button> -->
                                              <div id="reject_m" name="reject_m" onclick="check('Tolak')" class="btn btn-danger"><i class="fa fa-close"></i> Ditolak</div>
                                            </div>
                                          </div>
                                          <div class="col-xs-3 pull-right">
                                            <div class="form-group">
                                              <!-- <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Disetujui</button> -->
                                              <div id="accept_m" name="accept_m" onclick="check('Setuju')" class="btn btn-success"><i class="fa fa-check"></i> Disetujui</div>
                                            </div>
                                          </div>
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
                          @if(((Gate::check('tambah_item_a')||Gate::check('ubah_item_a')||Gate::check('hapus_item_a'))&& $beda)||(Gate::check('tambah_a')&&$status == "tambah"))
                          <h4 class="modal-title" id="titleModal">Unggah Berkas</h4>
                          @else
                          <h4 class="modal-title" id="titleModal">Unduh Berkas</h4>
                          @endif
                      </div>
                      <div class="modal-body" id="confirmation-msg">
                        <div class="row">
                          <div class="col-md-12" id="list_download">
                          </div>
                          <div class="col-md-12" id="list_file">
                          </div>
                          <br />
                          <br />
                          @if(((Gate::check('tambah_item_a')||Gate::check('ubah_item_a')||Gate::check('hapus_item_a'))&& $beda)||(Gate::check('tambah_a')&&$status == "tambah"))
                          <input type="file" id="files" name="files" multiple>
                          @endif
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button id="kembali" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                        @if(((Gate::check('tambah_item_a')||Gate::check('ubah_item_a')||Gate::check('hapus_item_a'))&& $beda)||(Gate::check('tambah_a')&&$status == "tambah"))
                        <div id="simpan_file" class="btn btn-outline-primary">Simpan</div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

                <div class="modal fade text-xs-left" id="modal_pernyataan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20"
                aria-hidden="true">
                  <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="title_modal_pernyataan">Pernyataan Anggaran Kegiatan</h4>
                      </div>
                      <div class="modal-body" id="confirmation-msg">
                        <div class="row">
                          <div class="col-md-12" id="teks_pernyataan">
                            <p>Apakah anda yakin Akan Mengajukan Anggaran Kegiatan dengan Nomor Dinas/Surat {{$filters['nd_surat']}}?</p>
                          </div>
                          <div class="col-md-12" id="form_penolakan">
                            <textarea rows="4" value="" style="float: left" class="col-md-12" id="alasan_penolakan" name="alasan_penolakan">
                            </textarea>
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
                </form>

                <form method="GET" action="{{ url('anggaran/reports/export') }}" id="downloadAnggaran" name="downloadAnggaran" enctype="multipart/form-data">
                    <input type="hidden" name="header_anggaran_download" id="header_anggaran_download">
                    <input type="hidden" name="list_anggaran_download" id="list_anggaran_download">
                </form>                  
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
                  var countDownDate = new Date("{{$batas}}").getTime();

                  @if($status!="setuju")
                  var disableCountDown = true;
                  @else
                  var disableCountDown = false;
                  @endif
                  if(disableCountDown){
                    var x = setInterval(function() {

                        // Get todays date and time
                        var now = new Date().getTime();

                        @if($mulai)
                          var distance = now - countDownDate;
                        @else
                          var distance = countDownDate - now;
                        @endif
                        // Find the distance between now an the count down date
                        
                        
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
                            document.getElementById("nd_surat").disabled  = true;
                            document.getElementById("unit_kerja").disabled  = true;
                            document.getElementById("tipe_anggaran").disabled  = true;
                            document.getElementById("stat_anggaran").disabled  = true;
                            document.getElementById("save").style.display = "none";
                            document.getElementById("send").style.display = "none";
                        }
                    }, 1000);
                
                  }
                </script>
                <script type="text/javascript">
                
                  var inputs = [];
                  var hasil=[];
                  var upload_file = [];
                  var temp_file = [];
                  var list_berkas=[];
                  var insertableStat = {{ $status=='edit' ? 1 : 0 }};
                  var id_field_item = id_field_edit = null;
                  var jenis = kelompok = pos = sub = mata_anggaran = null;
                  var satuan_field_insert = satuan_field_edit = null;
                  var unitk_field_insert = kuantitas_field_insert = nilai_field_insert = null;
                  var unitk_field_edit = kuantitas_field_edit = nilai_field_edit= null;
                  var twi_field_insert = twii_field_insert = twiii_field_insert = twiv_field_insert = anggarant_field_insert = null
                  var twi_field_edit = twii_field_edit = twiii_field_edit = twiv_field_edit = anggarant_field_edit = null
                  var item =  null;
                  var tempIdCounter = totalRows  = jumlah_file=0
                  var simpan_file =false;
                  var index_modal = -1;
                  var click_berkas = true;
                  var statusTable = "null";
                  var countFile = 0;
                  
                  $(document).ready(function() {
                    // alert("{{ $beda?1:0}}")
                    $("#basicScenario").jsGrid( {
                      width: "100%",
               
                      sorting: true,
                      paging: true,
                      autoload: true,

                      
                      @if((Gate::check('ubah_item_a')||(Gate::check('tambah_a')&&$status=="tambah"))&& $beda)
                        editing: true,
                      @else
                        editing: false,
                      @endif
                      @if((Gate::check('tambah_item_a')||(Gate::check('tambah_a')&&$status=="tambah"))&& $beda)
                        inserting: true,
                      @else
                        inserting: false,
                      @endif
                      deleteConfirm: "Apakah anda yakin akan menghapus anggaran baris ini?",
               
                      pageSize: 5,
                      pageButtonCount: 10,
                      noDataContent: "Data Belum Tersedia",
                      loadMessage: "Mohon, ditunggu...",


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
                          item["tempId"] = tempIdCounter++;
                          item["id"] = -1;
                          item["nilai_persatuan"]= validDigits(item.nilai_persatuan);
                          item["tw_i"]= validDigits(item.tw_i);
                          item["tw_ii"]= validDigits(item.tw_ii);
                          item["tw_iii"]= validDigits(item.tw_iii);
                          item["tw_iv"]= validDigits(item.tw_iv);
                          item["anggarana_setahun"]= validDigits(item.anggarana_setahun);
                          item["delete"]="none";
                          item["file"]=[];

                          click_berkas =true;
                                                      
                          inputs.push(item);
                          console.log('insert','onItemInsert');

                        },
                        updateItem: function(item) {

                          item["nilai_persatuan"]= validDigits(item.nilai_persatuan);
                          item["tw_i"]= validDigits(item.tw_i);
                          item["tw_ii"]= validDigits(item.tw_ii);
                          item["tw_iii"]= validDigits(item.tw_iii);
                          item["tw_iv"]= validDigits(item.tw_iv);
                          item["anggarana_setahun"]= validDigits(item.anggarana_setahun);

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

                          console.log('update','onItemUpdate');
                        },
                      }, 
                      onRefreshed: function(args) {
                        var items = args.grid.option("data");
                        items.forEach(function(item) {
                          totalRows += 1;
                        });
                      },
                      onItemInserted:function(args){
                        statusTable = "null";
                        var count_berkas = 0;

                        // console.log('temp',temp_file);
                        if(temp_file != null){
                          upload_file[index_modal]=[];
                          for(i=0;i<temp_file.length;i++){
                            upload_file[index_modal][i]=temp_file[i];
                            console.log((index_modal)+':'+i,upload_file[index_modal][i]);
                            if(upload_file[index_modal][i]!=null){
                              count_berkas++;
                              readerPrev(i,index_modal);
                            }
                          }
                        }
                        temp_file=[];
                        console.log('insert','onItemInserted');
                        // var title = "Unggah Berkas";
                        // if(countFile>0){
                        //   title=countFile+" Berkas"
                        // }
                        // temp_file=[];
                        // document.getElementById('button_'+index_modal).innerHTML = title;
                      },
                      onItemInserting:function(args){
                        console.log('insert','onItemInserting');
                      },
                      onItemEditing: function(args) {

                          if(statusTable=="edit"){
                            args.cancel =true;
                          }
                          statusTable = "edit";
                           window.setTimeout(function() {
                              $('.jsgrid-cancel-edit-button').one('click.avoidAuthorClickHandler', function() {
                                  statusTable = "null";

                                  list_berkas[index_modal] = inputs[index_modal]["file"];
                                  click_berkas = true;
                                  temp_file=[];
                                  console.log('update','onItemCancel');
                                  // alert("Cancel : "+JSON.stringify(inputs[index_modal]["file"]));
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
                          console.log('update','onItemDeleted');

                      },
                      onItemUpdating:function(args){

                          console.log('update','onItemUpdating');
                        
                      },
                      onItemUpdated: function(args) {
                          statusTable = "null";
                          var count_berkas = 0;
                          // console.log('temp',temp_file);
                          console.log('status',simpan_file);
                          if(simpan_file){
                            if(temp_file != null){
                              upload_file[index_modal]=[];
                              for(i=0;i<temp_file.length;i++){
                                upload_file[index_modal][i]=temp_file[i];
                                console.log(index_modal+':'+i,upload_file[index_modal][i]);
                                if(upload_file[index_modal][i]!=null){
                                  count_berkas++;
                                  readerPrev(i,index_modal);
                                }
                              }
                            }
                          }

                          temp_file=[];
                          console.log('update','onItemUpdated');
                          var title = "Unggah Berkas";
                          if(countFile>0){
                            title=countFile+" Berkas"
                            document.getElementById('button_'+index_modal).innerHTML = title;
                          }
                          // temp_file=[];
                          // alert(index_modal);
                          // alert(statusTable);
                      },
                      fields: [
                          { name: "id",
                            css: "hide",
                            type: "number", 
                            width: 0,
                            readOnly: true
                          },
                          {name: "id_first",
                            css: "hide",
                            width: 0,
                            type: "number",
                            readOnly: true
                          },
                          { type: "control",
                            width: 90,
                            @if(((Gate::check('tambah_item_a')||Gate::check('ubah_item_a')||Gate::check('hapus_item_a'))&& $beda)||(Gate::check('tambah_a')&&$status == "tambah"))
                              css: "",
                            @else
                              css: "hide",
                            @endif
                            @if(Gate::check('hapus_item_a'))
                              deleteButton: true,
                            @else
                              deleteButton: false,
                            @endif
                            // css: editableStat == 1? "":"hide",
                            headerTemplate: function() {
                                var control_field = jsGrid.fields.control.prototype.headerTemplate.call(this);
                                // alert("add");
                                window.setTimeout(function() {
                                    $('.jsgrid-insert-mode-button').on('click', function() {
                                        if($('.jsgrid-mode-on-button').length==0){
                                          statusTable = "null";
                                        }else{
                                          statusTable = "insert";
                                        }
                                    });
                                 }, 10);
                                return control_field;
                            }
                          },
                          { name: "jenis", 
                            type: "select", 
                            title: "Jenis", 
                            width: 130,
                            align: "left",
                            valueField: "name", 
                            textField: "name", 
                            insertcss: "jenis_select",
                            items: getData('jenis'),
                            itemTemplate:function(value){
                              changeDataSelect('kelompok',value,"");
                              return value;
                            },
                            insertTemplate: function() {
                              var result = jsGrid.fields.select.prototype.insertTemplate.call(this);
                              result.on("change", function() {
                                  changeDataSelect('kelompok',$(this).val(),"");
                              });
                              return result;
                            },
                            editTemplate: function(value) {
                              var result = jsGrid.fields.select.prototype.editTemplate.call(this);
                              $(result).val(value);
                              changeDataSelect('kelompok',$(this).val(),"");
                              result.on("change", function() {
                                  changeDataSelect('kelompok',$(this).val(),"");
                              });
                              return result; 
                            },
                            validate: {
                              message :function(value) {
                                status = "Pilih Jenis Terlebih dahulu";
                                // console.log("nilai",value);
                                if(value=="Belanja Modal"){
                                  status="Jika Jenisnya Belanja Modal, Nilai Persatuan Harus Lebih Besar dari Rp. 5.000.000";
                                  // console.log("nilai",status);
                                }
                                if(value=="Biaya Kantor"){
                                  status="Mohon cek kembali kolom Nilai Per Satuan";
                                  // console.log("nilai",status);
                                }
                                return status;
                              },
                              validator :function(value, item) {
                                if(value=="None"){
                                // console.log('nilaiNone',parseInt(validDigits(item.nilai_persatuan)) );
                                  return false;
                                }
                                else if(value=="Belanja Modal"&&parseInt(validDigits(item.nilai_persatuan)) < 5000001){
                                // console.log('nilaiBelanja',parseInt(validDigits(item.nilai_persatuan)) );
                                  return false;
                                }
                                else if(value=="Biaya Kantor"&&parseInt(validDigits(item.nilai_persatuan)) > 5000001){
                                // console.log('nilaiBelanja',parseInt(validDigits(item.nilai_persatuan)) );
                                  var r=confirm("Peringatan, Jenis Biaya Kantor yang diajukan lebih dari Rp. 5.000.000, anda yakin ingin mengajukan anggaran?");
                                  if (r == true){
                                    return true;
                                  }
                                  else {
                                    return false;
                                  }
                                }else{
                                // console.log('nilai',parseInt(validDigits(item.nilai_persatuan)) );
                                  return true;
                                }
                              } 
                            }
                          },
                          { name: "kelompok", 
                            type: "select", 
                            title: "Kelompok", 
                            width: 130,
                            align: "left",
                            valueField: "name", 
                            textField: "name", 
                            insertcss: "kelompok_select",
                            // items: getData('kelompok'),
                            items:[
                                { name: "Silahkan Pilih Jenis" }
                            ],
                            itemTemplate:function(value){
                              changeDataSelect('posanggaran',value,"");
                              return value;
                            },
                            insertTemplate: function() {
                              kelompok = this._grid.fields[4];
                              var result = jsGrid.fields.select.prototype.insertTemplate.call(this);
                              result.on("change", function() {
                                  changeDataSelect('posanggaran',$(this).val(),"");
                              });
                              return result;
                            },
                            editTemplate: function(value) {
                              kelompok = this._grid.fields[4];
                              var result = jsGrid.fields.select.prototype.editTemplate.call(this);
                              $(result).val(value);
                              changeDataSelect('posanggaran',$(this).val(),"");
                              result.on("change", function() {
                                  changeDataSelect('posanggaran',$(this).val(),"");
                              });
                              return result; 
                            },
                            validate: {
                              message : "Pilih Kelompok Terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value !== "None" && value !== "Silahkan Pilih Jenis";
                              } 
                            }
                          },
                          { name: "pos_anggaran", 
                            type: "select", 
                            title: "Pos Anggaran", 
                            width: 130,
                            align: "left",
                            valueField: "name", 
                            textField: "name", 
                            insertcss: "pos_select",
                            // items: getData('posanggaran'),
                            items:[
                                { name: "Silahkan Pilih Kelompok" },
                            ],
                            itemTemplate:function(value){
                              changeDataSelect('subpos',value,"");
                              return value;
                            },
                            insertTemplate: function() {
                              pos = this._grid.fields[5];
                              var result = jsGrid.fields.select.prototype.insertTemplate.call(this);
                              result.on("change", function() {
                                  changeDataSelect('subpos',$(this).val(),"");
                              });
                              return result;
                            },
                            editTemplate: function(value) {
                              pos = this._grid.fields[5];
                              var result = jsGrid.fields.select.prototype.editTemplate.call(this);
                              $(result).val(value);
                              changeDataSelect('subpos',$(this).val(),"");
                              result.on("change", function() {
                                  changeDataSelect('subpos',$(this).val(),"");
                              });
                              return result; 
                            },
                            validate: {
                              message : "Pilih Pos Anggaran Terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value !== "None" && value !== "Silahkan Pilih Kelompok";
                              } 
                            }
                          },
                          { name: "sub_pos", 
                            type: "select", 
                            title: "Sub Pos", 
                            width: 130,
                            align: "left",
                            valueField: "DESCRIPTION", 
                            textField: "DESCRIPTION", 
                            insertcss: "sub_select",
                            // items: getData('subpos'),
                            items:[
                                { DESCRIPTION: "Silahkan Pilih Pos Anggaran" },
                            ],
                            itemTemplate:function(value){
                              changeDataSelect('mataanggaran',value,"");
                              return value;
                            },
                            insertTemplate: function() {
                              sub = this._grid.fields[6];
                              var result = jsGrid.fields.select.prototype.insertTemplate.call(this);
                              result.on("change", function() {
                                  changeDataSelect('mataanggaran',$(this).val(),"");
                              });
                              return result;
                            },
                            editTemplate: function(value) {
                              sub = this._grid.fields[6];
                              var result = jsGrid.fields.select.prototype.editTemplate.call(this);
                              $(result).val(value);
                              changeDataSelect('mataanggaran',$(this).val(),"");
                              result.on("change", function() {
                                  changeDataSelect('mataanggaran',$(this).val(),"");
                              });
                              return result; 
                            },
                            validate: {
                              message : "Pilih Sub Pos Terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value !== "None" && value !== "Silahkan Pilih Pos Anggaran";
                              } 
                            }
                          },
                          { name: "mata_anggaran", 
                            type: "select", 
                            title: "Mata Anggaran", 
                            width: 130,
                            align: "left",
                            valueField: "DESCRIPTION", 
                            textField: "DESCRIPTION", 
                            insertcss: "mata_select",
                            // items: getData('mataanggaran'),

                            items:[
                                { DESCRIPTION: "Silahkan Pilih Sup Pos" },
                            ],
                            insertTemplate: function() {
                              mata_anggaran = this._grid.fields[7];
                              var result = jsGrid.fields.select.prototype.insertTemplate.call(this);
                              result.on("change", function() {
                                  changeDataSelect('satuan',$(this).val(),"Insert");
                              });
                              return result;
                            },
                            editTemplate: function(value) {
                              mata_anggaran = this._grid.fields[7];
                              var result = jsGrid.fields.select.prototype.editTemplate.call(this);
                              $(result).val(value);
                              changeDataSelect('satuan',$(this).val(),"Edit");
                              result.on("change", function() {
                                  changeDataSelect('satuan',$(this).val(),"Edit");
                              });
                              return result; 
                            },
                            validate: {
                              message : "Pilih Mata Anggaran Terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value !== "None" && value !== "Silahkan Pilih Sup Pos";
                              } 
                            }
                          },
                          { name: "kuantitas", 
                            type: "number",
                            _createTextBox:function(){
                              var $input = jsGrid.fields.number.prototype._createTextBox.call(this);
                              return $input.attr("min",0);
                            }, 
                            align: "left",
                            title: "Kuantitas", 
                            width: 90, 
                            insertTemplate: function() {
                              kuantitas_field_insert = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              kuantitas_field_insert.on("change", function() {
                                  $(kuantitas_field_insert).val($(this).val());
                                  var qty = $(this).val();
                                  var persatuan = validDigits($(nilai_field_insert).val());

                                  var nilai = persatuan*qty;
                                  var val = addCommas(nilai);
                                  $(anggarant_field_insert).val(val);

                              });
                              return kuantitas_field_insert; 
                            },
                            editTemplate: function(value) {
                              kuantitas_field_edit = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(kuantitas_field_edit).val(value);
                              kuantitas_field_edit.on("change", function() {
                                  $(kuantitas_field_edit).val($(this).val());
                                  var qty = $(this).val();
                                  var persatuan = validDigits($(nilai_field_edit).val());
                                  
                                  var nilai = persatuan*qty;
                                  var val = addCommas(nilai);
                                  $(anggarant_field_edit).val(val);
                              });
                              return kuantitas_field_edit; 
                            },
                            validate: {
                              message : "Isi Kolom Kuantitas terlebih dahulu." ,
                              validator :function(value, item) {
                                  

                                  @if($persetujuan == 1)
                                    return value > 0 ;
                                  @else
                                    if(item.terpusat == '1'){
                                      return true;
                                    }else{
                                      return value > 0 ;
                                    }
                                  @endif
                              } 
                            }
                          },
                          { name: "satuan", 
                            type: "select", 
                            align: "left",
                            title: "Satuan", 
                            valueField: "name", 
                            textField: "name", 
                            width: 100,
                            items: getData('satuan'),
                            validate: {
                              message : "Pilih Satuan Terlebih dahulu." ,
                              validator :function(value, item) {
                                  return value != "None" ;
                              } 
                            }
                          },
                          { name: "nilai_persatuan", 
                            type: "text", 
                            align: "right",
                            title: "Nilai Per Satuan", 
                            width: 130, 
                            itemTemplate: function(value) {
                              var display ="<span><b>Rp. " + addCommas(value) + "</b></span>";
                              
                              return display;
                            },
                            insertTemplate: function() {
                              nilai_field_insert= jsGrid.fields.text.prototype.insertTemplate.call(this);
                              nilai_field_insert.on("change", function() {
                                $(nilai_field_insert).val($(this).val());
                                var persatuan = validDigits($(this).val());
                                var qty= $(kuantitas_field_insert).val();

                                var nilai = persatuan*qty;
                                var val = addCommas(nilai);
                                $(anggarant_field_insert).val(val);
                              });

                              nilai_field_insert.on("keyup", function() {
                                  var nilai = validDigits($(this).val());
                                  var val = addCommas(nilai);
                                  $(nilai_field_insert).val(val);
                              });
                              return nilai_field_insert; 
                            },
                            editTemplate: function(value,item) {
                              nilai_field_edit= jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(nilai_field_edit).val(addCommas(value));
                              nilai_field_edit.on("change", function() {
                                $(nilai_field_edit).val($(this).val());
                                var persatuan = validDigits($(this).val());
                                var qty= $(kuantitas_field_edit).val();
                                var nilai = persatuan*qty;
                                var val = addCommas(nilai);
                                $(anggarant_field_edit).val(val);
                              });

                              nilai_field_edit.on("keyup", function() {
                                  var nilai = validDigits($(this).val());
                                  var val = addCommas(nilai);
                                  $(nilai_field_edit).val(val);
                              });


                              return nilai_field_edit; 
                            }, 
                            // itemInsert()
                            validate: {
                                message : "Isi Kolom Nilai Per Satuan.",
                                validator :function(value, item) {

                                    var val = validDigits(value);

                                    @if($persetujuan == 1)
                                      return val > 0 ;
                                    @else
                                      if(item.terpusat == '1'){
                                        return true;
                                      }else{
                                        return val > 0 ;
                                      }
                                    @endif
                                } 
                              }
                          },
                          { name: "terpusat", 
                            type: "select", 
                            align: "left",
                            title: "Terpusat", 
                            width: 80,
                            items:[
                                { Name: "None", Id: '0' },
                                { Name: "Ya", Id: '1' },
                                { Name: "Tidak", Id: '2'}
                            ],
                            valueField: "Id",
                            textField: "Name",
                            insertTemplate: function() {
                              var result = jsGrid.fields.select.prototype.insertTemplate.call(this);
                              result.on("change", function() {
                                  // if({{$persetujuan}}!=1)
                                    changeDataUnitKerjaLine($(this).val(),"insert");
                              });
                              return result; 
                            },
                            editTemplate: function(value) {
                              var result = jsGrid.fields.select.prototype.editTemplate.call(this);
                              $(result).val(value);
                              
                              result.on("change", function() {
                                  // if({{$persetujuan}}!=1)
                                    changeDataUnitKerjaLine($(this).val(),"edit");
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
                            align: "left",
                            title: "Unit Kerja", 
                            width: 200, 
                            readOnly:true,
                            insertTemplate: function() {
                              unitk_field_insert = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              return unitk_field_insert; 
                            },
                            editTemplate: function(value) {
                              unitk_field_edit = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(unitk_field_edit).val(value);
                              return unitk_field_edit; 

                            } 
                          },
                          { name: "tw_i", 
                            type: "text", 
                            align: "right",
                            title: "TW I", 
                            width: 200,
                            itemTemplate: function(value) {
                              var display ="<span><b>Rp. " + addCommas(value) + "</b></span>";
                              
                              if(parseInt(value).toLocaleString() < 1||value == ""){
                                display = "<span >---</span>";
                              }

                              // alert(parseInt(value).toLocaleString());
                              return display;
                            },
                            insertTemplate: function() {
                              // var valField=this._grid.fields[12];
                              twi_field_insert = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              twi_field_insert.on("keyup", function() {
                                  var nilai = validDigits($(this).val());
                                  var val = addCommas(nilai);
                                  $(twi_field_insert).val(val);
                              });
                              return twi_field_insert; 
                            },
                            editTemplate: function(value,item) {
                              twi_field_edit = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(twi_field_edit).val(addCommas(value));
                              twi_field_edit.on("keyup", function() {
                                  var nilai = validDigits($(this).val());
                                  var val = addCommas(nilai);
                                  $(twi_field_edit).val(val);
                              });
                              return twi_field_edit; 
                            },
                            validate: {
                              message : "Isi minimal pada salah satu Kolom dari TWI, TWII, TWIII, TWIV.",
                              validator :function(value, item) {
                                // alert(item.terpusat);
                                  // alert("sebelum");
                                  var twi_val = item.tw_i == "" ? 0:parseInt(validDigits(item.tw_i ));
                                  var twii_val = item.tw_ii == "" ? 0:parseInt(validDigits(item.tw_ii));
                                  var twiii_val = item.tw_iii == "" ? 0:parseInt(validDigits(item.tw_iii));
                                  var twiv_val = item.tw_iv == "" ? 0:parseInt(validDigits(item.tw_iv));
                                  // alert("sebelum tw");
                                  var anggaran_val = parseInt(validDigits(item.anggarana_setahun));
                                  // alert("anggarant");
                                  var sum = twi_val+twii_val+twiii_val+twiv_val;
                                  
                                  // alert(twi_val+"+"+twii_val+"+"+twiii_val+"+"+twiv_val);
                                  @if($persetujuan == 1)
                                    return (sum <= anggaran_val && sum >= anggaran_val) ;
                                  @else
                                    if(item.terpusat == '1'){
                                      return true;
                                    }else{
                                      return (sum <= anggaran_val && sum >= anggaran_val) ;
                                    }
                                  @endif
                              }
                            }
                          },
                          { name: "tw_ii", 
                            type: "text", 
                            align: "right",
                            title: "TW II", 
                            width: 200 ,
                            itemTemplate: function(value) {
                              var display ="<span><b>Rp. " + addCommas(value) + "</b></span>";
                              
                              if(parseInt(value).toLocaleString() < 1||value == ""){
                                display = "<span >---</span>";
                              }
                              return display;
                            },
                            insertTemplate: function() {
                              twii_field_insert = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              twii_field_insert.on("keyup", function() {
                                  var nilai = validDigits($(this).val());
                                  var val = addCommas(nilai);
                                  $(twii_field_insert).val(val);
                              });
                              return twii_field_insert; 
                            },
                            editTemplate: function(value) {
                              twii_field_edit = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(twii_field_edit).val(addCommas(value));
                              twii_field_edit.on("keyup", function() {
                                  var nilai = validDigits($(this).val());
                                  var val = addCommas(nilai);
                                  $(twii_field_edit).val(val);
                              });
                              return twii_field_edit; 
                            }
                          },
                          { name: "tw_iii", 
                            type: "text", 
                            align: "right",
                            title: "TW III", 
                            width: 200 ,
                            itemTemplate: function(value) {
                              var display ="<span><b>Rp. " + addCommas(value) + "</b></span>";
                              
                              if(parseInt(value).toLocaleString() < 1||value == ""){
                                display = "<span >---</span>";
                              }
                              return display;
                            },
                            insertTemplate: function() {
                              twiii_field_insert = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              twiii_field_insert.on("keyup", function() {
                                  var nilai = validDigits($(this).val());
                                  var val = addCommas(nilai);
                                  $(twiii_field_insert).val(val);
                              });
                              return twiii_field_insert; 
                            },
                            editTemplate: function(value) {
                              twiii_field_edit= jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(twiii_field_edit).val(addCommas(value));
                              twiii_field_edit.on("keyup", function() {
                                  var nilai = validDigits($(this).val());
                                  var val = addCommas(nilai);
                                  $(twiii_field_edit).val(val);
                              });
                              return twiii_field_edit; 
                            }
                          },
                          { name: "tw_iv", 
                            type: "text", 
                            align: "right",
                            title: "TW IV",
                            width: 200,
                            itemTemplate: function(value) {
                              var display ="<span><b>Rp. " + addCommas(value) + "</b></span>";
                              
                              if(parseInt(value).toLocaleString() < 1||value == ""){
                                display = "<span >---</span>";
                              }
                              return display;
                            },
                            insertTemplate: function() {
                              twiv_field_insert = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              twiv_field_insert.on("keyup", function() {
                                  var nilai = validDigits($(this).val());
                                  var val = addCommas(nilai);
                                  $(twiv_field_insert).val(val);
                              });
                              return twiv_field_insert; 
                            },
                            editTemplate: function(value) {
                              twiv_field_edit = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(twiv_field_edit).val(addCommas(value));
                              twiv_field_edit.on("keyup", function() {
                                  var nilai = validDigits($(this).val());
                                  var val = addCommas(nilai);

                                  $(twiv_field_edit).val(val);
                              });
                              return twiv_field_edit; 
                            }
                           },
                          { name: "anggarana_setahun", 
                            type: "text", 
                            align: "right",
                            title: "Anggaran Setahun", 
                            width: 200 ,
                            readOnly:true,
                            itemTemplate: function(value) {var val=0
                              var display ="<span><b>Rp. " + addCommas(value) + "</b></span>";
                              
                              if(parseInt(value).toLocaleString() < 1||value == ""){
                                display = "<span>---</span>";
                              }
                              return display;
                            },
                            insertTemplate: function() {
                              anggarant_field_insert = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              return anggarant_field_insert; 
                            },
                            editTemplate: function(value) {
                              anggarant_field_edit = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(anggarant_field_edit).val(addCommas(value));
                              return anggarant_field_edit; 
                            },
                            validate: {
                              message :function(value, item) {
                                  var status1 = "lebih";
                                  var status2 = "kurang";
                                  var twi_val = item.tw_i == "" ? 0:parseInt(validDigits(item.tw_i ));
                                  var twii_val = item.tw_ii == "" ? 0:parseInt(validDigits(item.tw_ii));
                                  var twiii_val = item.tw_iii == "" ? 0:parseInt(validDigits(item.tw_iii));
                                  var twiv_val = item.tw_iv == "" ? 0:parseInt(validDigits(item.tw_iv));
                                  // alert("sebelum tw");
                                  var anggaran_val = parseInt(validDigits(item.anggarana_setahun));
                                  // alert("anggarant");
                                  var sum = twi_val+twii_val+twiii_val+twiv_val;

                                  return  "Jumlah Anggaran yang di minta di semua periode "+ (sum> anggaran_val ? status1: status2)+" dari Anggaran Setahun" ;
                              },
                              validator :function(value, item) {
                                  var twi_val = item.tw_i == "" ? 0:parseInt(validDigits(item.tw_i ));
                                  var twii_val = item.tw_ii == "" ? 0:parseInt(validDigits(item.tw_ii));
                                  var twiii_val = item.tw_iii == "" ? 0:parseInt(validDigits(item.tw_iii));
                                  var twiv_val = item.tw_iv == "" ? 0:parseInt(validDigits(item.tw_iv));
                                  // alert("sebelum tw");
                                  var anggaran_val = parseInt(validDigits(item.anggarana_setahun));
                                  // alert("anggarant");
                                  var sum = twi_val+twii_val+twiii_val+twiv_val;
                                  // alert(sum);

                                  @if($persetujuan == 1)
                                    return (sum <= anggaran_val && sum >= anggaran_val) ;
                                  @else
                                    if(item.terpusat == '1'){
                                      return true;
                                    }else{
                                      return (sum <= anggaran_val && sum >= anggaran_val) ;
                                    }
                                  @endif
                              }
                            }
                          },
                          //qwqwqwqwqwqwqw
                          { name: "file", align:"center", title: "Berkas",  width: 150 ,
                            
                            itemTemplate: function(value,item) {
                              // alert("null");

                              // alert(item.tempId);
                              var id_list=0;
                              var count_berkas=0;
                              if(value.length>0){
                                for(i =0;i<value.length;i++){
                                  id_list = value[i]['count'];
                                  // alert(JSON.stringify(inputs[id_list]["file"][i]));
                                  if(inputs[id_list]["file"][i]["delete"]=="none")
                                    count_berkas++;
                                }
                              }else{
                                id_list=value
                              }
                              for(i=0;i<inputs.length;i++){
                                if(inputs[i]["id"]==item.id){
                                  id_list = inputs[i]["tempId"];
                                }
                              }

                              if(upload_file[id_list] != null){
                                // alert(upload_file[id_list].length);
                                for(i=0;i<upload_file[id_list].length;i++){
                                  if(upload_file[id_list][i]!=null){
                                    count_berkas++;
                                  }
                                }
                              }

                              // alert(JSON.stringify(upload_file[id_list]));
                              
                              var title="";
                              // document.getElementById('button_'+index_modal).innerHTML = countFile+" Berkas";
                              if(count_berkas==0){
                                title = "Unggah Berkas";
                                
                              }else{
                                title = count_berkas+" Berkas";
                              }
                              var button = "<span class='btn btn-sm btn-primary' id='button_"+id_list+"' onclick='setModalFile("+id_list+")' >"+title+"</span>";
                              return button;
                            },

                            insertTemplate: function() {
                              var id_list=0;
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
                                title = "Unggah Berkas";
                              }else{
                                title = count_berkas+" Berkas";
                              }
                              var button = "<span class='btn btn-sm btn-primary' id='button_"+id_list+"' onclick='setModalFile("+id_list+")' >"+title+"</span>";
                              return button;
                            },
                            
                            editTemplate: function(value,item) {
                              // alert("update");
                              var id_list=0;
                              var count_berkas=0;
                              if(value.length>0){
                                for(i =0;i<value.length;i++){
                                  id_list = value[i]['count'];
                                  if(inputs[id_list]["file"][i]["delete"]=="none")
                                    count_berkas++;
                                }
                              }else{
                                id_list=value
                              }
                              for(i=0;i<inputs.length;i++){
                                if(inputs[i]["id"]==item.id){
                                  id_list = inputs[i]["tempId"];
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
                                title = "Unggah Berkas";
                                for(i=0;i<inputs.length;i++){
                                  if(inputs[i]["id"]==item.id){
                                    id_list = inputs[i]["tempId"];
                                  }
                                }

                              // alert(item.tempId);
                              }else{
                                title = count_berkas+" Berkas";
                              }
                              var button = "<span class='btn btn-sm btn-primary' id='button_"+id_list+"' onclick='setModalFile("+id_list+")' >"+title+"</span>";
                              return button;
                            },
                            // validate: {
                            //   message :function(value) {
                            //     status = "Pilih Berkas Terlebih Dahulu";
                            //     return status;
                            //   },
                            //   validator :function(value, item) {
                            //     if(count_berkas=0){
                            //       return false;
                            //     }else{
                            //       return true;
                            //     }
                            //   } 
                            // }
                            // validate: {
                            //   message :"Minimal 1 berkas di unggah", 
                            //   validator :function(value, item) {
                            //     var id_list=0;
                            //     var count_berkas=0;
                            //     if(value.length>0){
                            //       for(i =0;i<value.length;i++){
                            //         if(inputs[id_list]["file"][i]["delete"]=="none")
                            //           count_berkas++;
                            //       }
                            //     }else{
                            //       id_list=value
                            //     }
                            //     for(i=0;i<inputs.length;i++){
                            //       if(inputs[i]["id"]==item.id){
                            //         id_list = inputs[i]["tempId"];
                            //       }
                            //     }
                                
                            //     if(upload_file[id_list] != null){
                            //       for(i=0;i<upload_file[id_list].length;i++){
                            //         if(upload_file[id_list][i]!=null){
                            //           count_berkas++;
                            //         }
                            //       }
                            //     }

                            //     return count_berkas > 0 ;
                            //   }
                            // }
                          },
                          { type: "control",
                            width: 50,
                            @if(((Gate::check('tambah_item_a')||Gate::check('ubah_item_a')||Gate::check('hapus_item_a'))&& $beda)||(Gate::check('tambah_a')&&$status == "tambah"))
                             css: "",
                            @else
                              css: "hide",
                            @endif
                            @if(Gate::check('hapus_item_a'))
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
                            'url': "{{ url('anggaran/get/attributes') }}/" +type+"/-1",
                            'success': function (data) {
                                // tmp = data;
                                tmp = []
                                for(i=0;i<=data.length;i++){
                                  tmp[i]={};
                                  if(type == 'jenis'||type == 'kelompok'||type == 'posanggaran'||type == "satuan"){
                                    if(i == 0){
                                      tmp[0]["name"] = "None";
                                    }else{
                                      tmp[i]["name"] = data[i-1]["name"];
                                    }
                                  }else{
                                    if(i == 0){
                                      tmp[0]["DESCRIPTION"] = "None";
                                    }else{
                                      tmp[i]["DESCRIPTION"] = data[i-1]["DESCRIPTION"];
                                    }
                                  }
                                  
                                }
                                // alert(JSON.stringify(data));
                            }
                        });
                        return tmp;
                    }();
                    return returned;
                  }
                  function changeDataSelect(type,value,jenis){


                    decode = encodeURI(value);
                    split = decode.split("/");
                    if(split.length>1){
                      decode = split[0]+"->"+split[1];
                    }
                    // alert("{{ url('anggaran/get/attributes') }}/" +type+"/"+decode);
                    if(value!="None"){
                      $.ajax({
                          'async': false, 'type': "GET", 'dataType': 'JSON', 
                          'url': "{{ url('anggaran/get/attributes') }}/" +type+"/"+decode,
                          'success': function (data) {
                              tmp = []
                              if(type != "satuan"){
                                for(i=0;i<=data.length;i++){
                                  tmp[i]={};
                                  if(type == 'jenis'||type == 'kelompok'||type == 'posanggaran'){
                                    if(i == 0){
                                      tmp[0]["name"] = "None";
                                    }else{
                                      tmp[i]["name"] = data[i-1]["name"];
                                    }
                                  }else{
                                    if(i == 0){
                                      tmp[0]["DESCRIPTION"] = "None";
                                    }else{
                                      tmp[i]["DESCRIPTION"] = data[i-1]["DESCRIPTION"];
                                    }
                                  }
                                }
                                if(type == "kelompok"){
                                  kelompok.items = tmp;
                                  $(".kelompok_select").empty().append(kelompok.insertTemplate());
                                }else if(type == "posanggaran"){
                                  pos.items = tmp;
                                  $(".pos_select").empty().append(pos.insertTemplate());
                                }else if(type == "subpos"){
                                  sub.items = tmp;
                                  $(".sub_select").empty().append(sub.insertTemplate());
                                }else if(type == "mataanggaran"){
                                  mata_anggaran.items = tmp;
                                  $(".mata_select").empty().append(mata_anggaran.insertTemplate());
                                }

                                if(type == "kelompok"){
                                  data[0]["name"] = "Silahkan Pilih Kelompok";
                                  pos.items = data;
                                  $(".pos_select").empty().append(pos.insertTemplate());
                                }
                                if(type == "kelompok"||type == "posanggaran"){
                                  data[0]["DESCRIPTION"] = "Silahkan Pilih Pos Anggaran";
                                  sub.items = data;
                                  $(".sub_select").empty().append(sub.insertTemplate());
                                }
                                if(type == "kelompok"||type == "posanggaran"||type == "subpos"){
                                  data[0]["DESCRIPTION"] = "Silahkan Pilih Sub Pos";
                                  mata_anggaran.items = data;
                                  $(".mata_select").empty().append(mata_anggaran.insertTemplate());
                                }
                              }else{
                                if(jenis == "Insert"){
                                  $(satuan_field_insert).val(data[0].name);}
                                else{
                                  $(satuan_field_edit).val(data[0].name);
                                }
                              }
                          }
                      });
                    }else{
                      data = [];
                      data[0] = {};     
                      if(type == "kelompok"){
                        data[0]["name"] = "Silahkan Pilih Jenis";
                        kelompok.items = data;
                        $(".kelompok_select").empty().append(kelompok.insertTemplate());
                      }
                      if(type == "kelompok"||type == "posanggaran"){
                        data[0]["name"] = "Silahkan Pilih Kelompok";
                        pos.items = data;
                        $(".pos_select").empty().append(pos.insertTemplate());
                      }
                      if(type == "kelompok"||type == "posanggaran"||type == "subpos"){
                        data[0]["DESCRIPTION"] = "Silahkan Pilih Pos Anggaran";
                        sub.items = data;
                        $(".sub_select").empty().append(sub.insertTemplate());
                      }
                      if(type == "kelompok"||type == "posanggaran"||type == "subpos"||type == "mataanggaran"){
                        data[0]["DESCRIPTION"] = "Silahkan Pilih Sub Pos";
                        mata_anggaran.items = data;
                        $(".mata_select").empty().append(mata_anggaran.insertTemplate());
                      }
                    }
                  }
                  function setUnitKerja(id_type,id_unit){
                    var type = "";
                    var unit = "";
                    if(id_type == "00"){
                      type = "divisi";
                      unit = id_unit;
                    }else{
                      type = "cabang";
                      unit = id_type;
                    }

                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/attributes') }}/"+type+"/"+unit,
                        'success': function (data) {
                            @if($status=='tambah'?1:0)
                            document.getElementById("unit_kerja").value = data[0].DESCRIPTION;
                            @endif
                            document.getElementById("view_unit_kerja").value = data[0].DESCRIPTION;
                        }
                    });
                  }
                  function setDetailAnggaran(nd_surat){
                    if(nd_surat!=null&&tanggal!=null)
                      $.ajax({
                          'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/filtered/') }}/"+nd_surat+"/anggaran",
                          'success': function (data) {
                                var persetujuan = status_anggaran = "";
                                switch(data[0].persetujuan){
                                  case "-1" : persetujuan="";break;
                                  case "0" : persetujuan="Kirim";break;
                                  case "1" : persetujuan="Persetujuan Ka Unit Kerja";break;
                                  case "2" : persetujuan="Persetujuan Kadiv Renbang";break;
                                  case "3" : persetujuan="Persetujuan Direksi";break;
                                  case "4" : persetujuan="Persetujuan Dekom";break;
                                  case "5" : persetujuan="Persetujuan Ratek";break;
                                  case "6" : persetujuan="Persetujuan RUPS";break;
                                  case "7" : persetujuan="Persetujuan FinRUPS";break;
                                  case "8" : persetujuan="Persetujuan Risalah RUPS";break;
                                  // case "9" : persetujuan="Disetujuai dan Ditandatangani";break;
                                }
                                switch(data[0].status_anggaran){
                                  case "1" : status_anggaran="Draft";break;
                                  case "2" : status_anggaran="Transfer";break;
                                  case "3" : status_anggaran="Complete";break;
                                }
                                var tgl = data[0].tanggal;
                                var tgl_split = tgl.split("-");

                                if(document.getElementById("view_unit_kerja").value == data[0].unit_kerja){
                                 
                                  $("#basicScenario").jsGrid( {
                               
                                      editing: true,
                                      inserting: true,
                                    });
                                   // alert("sama");
                                }else{
                                  $("#basicScenario").jsGrid( {
                               
                                      editing: false,
                                      inserting: false,
                                    });
                                }
                                   // alert('{{$beda?1:0}}');
                                document.getElementById("nd_surat").value = nd_surat;
                                document.getElementById("id_anggaran").value = data[0].id;
                                document.getElementById("stat_anggaran").value = status_anggaran;
                                document.getElementById("unit_kerja").value = data[0].unit_kerja;
                                document.getElementById("persetujuan").value = persetujuan;
                                document.getElementById("tipe_anggaran").value = data[0].tipe_anggaran;
                                document.getElementById("tanggal").value = tgl_split[2]+"-"+tgl_split[1]+"-"+tgl_split[0];
                                // alert(data[0].persetujuan);
                                if(data[0].persetujuan == "-1"){
                                  document.getElementById("grup_m").style.display="none";
                                  document.getElementById("grup_r").style.display="none";
                                  document.getElementById("grup_uk").style.display="block";
                                }else if(data[0].persetujuan == "8"){
                                  document.getElementById("grup_m_p").style.display="none";
                                  document.getElementById("grup_m").style.display="block";
                                  document.getElementById("grup_r").style.display="none";
                                  document.getElementById("grup_uk").style.display="none";
                                }else if(data[0].persetujuan =="1"){
                                  document.getElementById("grup_m").style.display="none";
                                  // alert("{{$status}}")
                                  @if($status=='setuju'||($status=='edit'&&Gate::check('setuju_iia')))
                                    document.getElementById("grup_r").style.display="block";
                                  @else
                                    document.getElementById("grup_r").style.display="block";
                                    document.getElementById("grup_r_p").style.display="none";
                                  @endif
                                  document.getElementById("grup_uk").style.display="none";
                                }else{
                                  @if($status=='setuju'&&$beda)
                                    document.getElementById("grup_m").style.display="block";
                                  @else
                                    document.getElementById("grup_m").style.display="block";
                                    document.getElementById("grup_m_p").style.display="none";
                                  @endif
                                  document.getElementById("grup_r").style.display="none";
                                  document.getElementById("grup_uk").style.display="none";
                                }
                                if(data[0].persetujuan =="1"&&{{Gate::check('setuju_iia')?1:0}}){
                                  @if($beda)
                                    document.getElementById("accept_r").style.display="none";
                                    document.getElementById("download_r").style.display="none";
                                    document.getElementById("edit_r").style.display="none";
                                    document.getElementById("save_r").style.display="block";
                                    document.getElementById("send_r").style.display="block";
                                    var reject = {{$reject ? 1:0}};
                                    if(reject == 1)
                                      document.getElementById("send_r").setAttribute('onclick','check("Tolak");');
                                    else{
                                      document.getElementById("send_r").setAttribute('onclick','check("Setuju");');
                                    }
                                  @else
                                    for(i=1;i<data.length;i++){
                                      if(parseInt(data[0].persetujuan) < parseInt(data[i].persetujuan)){

                                        changeButton();
                                        document.getElementById("send_r").style.display="block";
                                        document.getElementById("accept_r").style.display="none";
                                        break;
                                      }
                                    }
                                  @endif
                                }
                          }
                      });
                  }
                  function changeDataUnitKerjaLine(type,type2){
                    if(type2 == "insert"){
                      if({{$persetujuan}}!=1){
                        if(type == '1'){
                          $(kuantitas_field_insert).val("");
                          $(kuantitas_field_insert).attr("readOnly", true);
                          $(nilai_field_insert).val("");
                          $(nilai_field_insert).attr("readOnly", true);
                          $(twi_field_insert).val("");
                          $(twi_field_insert).attr("readOnly", true);
                          $(twii_field_insert).val("");
                          $(twii_field_insert).attr("readOnly", true);
                          $(twiii_field_insert).val("");
                          $(twiii_field_insert).attr("readOnly", true);
                          $(twiv_field_insert).val("");
                          $(twiv_field_insert).attr("readOnly", true);
                        }else{
                          // $(kuantitas_field_insert).val("");
                          $(kuantitas_field_insert).attr("readOnly", false);
                          // $(nilai_field_insert).val("");
                          $(nilai_field_insert).attr("readOnly", false);
                          $(twi_field_insert).val("");
                          $(twi_field_insert).attr("readOnly", false);
                          $(twii_field_insert).val("");
                          $(twii_field_insert).attr("readOnly", false);
                          $(twiii_field_insert).val("");
                          $(twiii_field_insert).attr("readOnly", false);
                          $(twiv_field_insert).val("");
                          $(twiv_field_insert).attr("readOnly", false);
                        } 
                      }

                      if(type == '1'){
                        $(unitk_field_insert).val("");
                      }else{
                        $(unitk_field_insert).val(document.getElementById("unit_kerja").value);
                      }
                      
                      
                    }else if(type2 == "edit"){
                      if({{$persetujuan}}!=1){
                        if(type == '1'){
                          $(kuantitas_field_edit).val("");
                          $(kuantitas_field_edit).attr("readOnly", true);
                          $(nilai_field_edit).val("");
                          $(nilai_field_edit).attr("readOnly", true);
                          $(twi_field_edit).val("");
                          $(twi_field_edit).attr("readOnly", true);
                          $(twii_field_edit).val("");
                          $(twii_field_edit).attr("readOnly", true);
                          $(twiii_field_edit).val("");
                          $(twiii_field_edit).attr("readOnly", true);
                          $(twiv_field_edit).val("");
                          $(twiv_field_edit).attr("readOnly", true);
                        }else{
                          // $(kuantitas_field_edit).val("");
                          $(kuantitas_field_edit).attr("readOnly", false);
                          // $(nilai_field_edit).val("");
                          $(nilai_field_edit).attr("readOnly", false);
                          $(twi_field_edit).val("");
                          $(twi_field_edit).attr("readOnly", false);
                          $(twii_field_edit).val("");
                          $(twii_field_edit).attr("readOnly", false);
                          $(twiii_field_edit).val("");
                          $(twiii_field_edit).attr("readOnly", false);
                          $(twiv_field_edit).val("");
                          $(twiv_field_edit).attr("readOnly", false);
                        } 
                      }

                      if(type == '1'){
                        $(unitk_field_edit).val("");
                      }else{
                        $(unitk_field_edit).val(document.getElementById("unit_kerja").value);
                      }
                      
                    }        
                  }
                  function addCommas(n){
                    var rx=  /(\d+)(\d{3})/;
                    return String(n).replace(/^\d+/, function(w){
                      while(rx.test(w)){
                        w= w.replace(rx, '$1.$2');
                      }
                      return w;
                    });
                  }
                  function validDigits(n, dec){
                    n= n.replace(/[^\d]+/g, '');
                    var ax1= n.indexOf('.'), ax2= -1;
                    if(ax1!= -1){
                      ++ax1;
                      ax2= n.indexOf('.', ax1);
                      if(ax2> ax1) n= n.substring(0, ax2);
                      if(typeof dec=== 'number') n= n.substring(0, ax1+dec);
                    }
                    return n;
                  }
                  function getListData() {
                    $.ajax({
                          'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/filtered/'.$filters['nd_surat'].'/list_anggaran') }}",
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
                                
                                // alert(JSON.stringify(inputs[i]));
                              }
                          }
                          
                      });
                  }
                  function changeData(kegiatan,type){
                    var tmp = null;
                    $.ajax({
                        'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/attributes') }}/mataanggaran/"+encodeURI(kegiatan),
                        'success': function (data) {
                            tmp = data;
                            // alert(data[0]['jenis']);
                            if(type == "edit"){
                              $(jenis_field_edit).val(data[0]['jenis']);
                              $(kelompok_field_edit).val(data[0]['kelompok']);
                              $(pos_field_edit).val(data[0]['pos_anggaran']);
                              $(sub_field_edit).val(data[0]['sub_pos']);
                              $(mata_anggaran_edit).val(data[0]['mata_anggaran']);
                              $(satuan_field_edit).val("Contoh Satuan");
                            }else if(type == "insert"){
                              $(jenis_field_insert).val(data[0]['jenis']);
                              $(kelompok_field_insert).val(data[0]['kelompok']);
                              $(pos_field_insert).val(data[0]['pos_anggaran']);
                              $(sub_field_insert).val(data[0]['sub_pos']);
                              $(mata_anggaran_insert).val(data[0]['mata_anggaran']);
                              $(satuan_field_insert).val("Contoh Satuan");
                            }
                        }
                    });
                  }
                  function check(type){
                    if(document.getElementById("tanggal").value==""){
                      toastr.error("Silahkan Isi Tanggal Terlebih Dahulu. Terima kasih.", "Perhatian.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    } else if(document.getElementById("nd_surat").value==""){
                      toastr.error("Silahkan Isi Form Nomor Surat Terlebih Dahulu. Terima kasih.", "Perhatian.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    } else if(inputs.length < 1){
                      toastr.error("Silahkan tambahkan minimal 1 daftar anggaran untuk melakukan penyimpanan. Terima kasih.", "Minimal satu anggaran yang diisi.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    } else {
                      var terpusat = false;
                      for(i=0;i<inputs.length;i++){
                        
                        if(inputs[i]["terpusat"] == '1'){
                          if(inputs[i]["anggarana_setahun"] == 0){
                            terpusat = true;
                            break;
                          }
                        }
                        

                      }
                      if({{$persetujuan}} == 1&&terpusat){
                        toastr.error("Silahkan isi terlebih dahulu data anggaran yang terpusat untuk menyimpan perubahan atau melanjutkan verifikasi . Terima kasih.", "Terdapat data anggaran kegiatan terpusat.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                      }else{

                        var stop = false;

                        status = {{ $status=='edit' ? 1 : 0 }};
                        for(i=0;i<inputs.length;i++){
                          nameClass = $('.file_'+i);
                          // alert(nameClass.length);
                          if(nameClass.length > 0){
                            count=0;
                            for(j=0;j<nameClass.length;j++){
                              if(document.getElementById("file_name_"+i+"_"+j) != null){
                                file = document.getElementById("file_name_"+i+"_"+j).value;
                                if(file=="null"){
                                  count++;
                                }
                              }
                            }
                            if(count==nameClass.length){
                              stop=true;
                            }
                          }else{
                            stop=true;
                            if(list_berkas.length>0){
                              if(list_berkas[i].length>0){
                                stop = false;
                              }
                            }
                          }
                          if(!stop){
                            if(nameClass.length!=0){
                              var countFile = $('<input/>',{type:'hidden',id:('count_file_'+i),
                              name:('count_file_'+i),value:nameClass.length});
                              countFile.appendTo("#file_grid");
                            }
                            
                          }
                        }
                        // if(status == 1){
                        //   stop = false;
                        // }else{
                        //   stop = false;
                        // }

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
                            document.getElementById("setuju").value = type;
                            var title_modal="";
                            var pernyataan_modal="";
                            var form_penolakan="none";
                            var nd_surat = document.getElementById("nd_surat").value;
                            if(type=="Simpan"){
                              title_modal="Pernyimpanan Anggaran dan Kegiatan";
                              pernyataan_modal = "<p>Apakah anda yakin Akan Menyimpan Anggaran dan Kegiatan dengan Nomor Dinas/Surat "+nd_surat+"?</p>";
                            }else if(type=="Kirim"){
                              title_modal="Pengajuan Anggaran dan Kegiatan";
                              pernyataan_modal = "<p>Apakah anda yakin Akan Mengajukan Anggaran dan Kegiatan dengan Nomor Dinas/Surat "+nd_surat+"?</p>";
                            }else if(type=="Setuju"){
                              title_modal="Persetujuan Anggaran dan Kegiatan";
                              pernyataan_modal = "<p>Apakah anda yakin Akan Menyetujui Pengajuan dan Anggaran Kegiatan dengan Nomor Dinas/Surat "+nd_surat+"?</p>";
                            }else if(type=="Tolak"){
                              title_modal="Penolakkan Anggaran dan Kegiatan";
                              pernyataan_modal = "<p>Apakah anda yakin Akan Menolak Pengajuan Anggaran dan Kegiatan dengan Nomor Dinas/Surat "+nd_surat+"?</p>";
                              pernyataan_modal += "<p>Silahkan Isi Alasan Penolakan DIbawah ini : </p>";
                              form_penolakan = "block";
                            }
                            document.getElementById("title_modal_pernyataan").innerHTML = title_modal;
                            document.getElementById("teks_pernyataan").value = pernyataan_modal;
                            document.getElementById("form_penolakan").style.display = form_penolakan;
                            document.getElementById("button_peryataan").innerHTML = "Ya, "+type;

                            if(type == "Tolak"&&document.getElementById("alasan_penolakan".value="")){
                              toastr.error("Silahkan Isi Alasan Penolakan Anda. Terima kasih.", "Alasan Penolakan Kosong.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                            }else{
                              $('#modal_pernyataan').modal({
                                  backdrop: 'static'
                              });
                            }
                            
                          } 
                        }
                      }
                    }
                  }
                  function sumbit_post(){
                    $('input[name="list_anggaran_values"]').val(JSON.stringify(inputs));
                    // alert(JSON.stringify(inputs));
                    $('form[id="insertAnggaran"]').submit();
                  }
                  function download_post(){
                    header={};
                    header['tanggal'] = $('#tanggal').val();
                    header['nd_surat'] = $('#nd_surat').val();
                    header['unit_kerja'] = $('#unit_kerja').val();
                    header['tipe_anggaran'] = $('#tipe_anggaran').val();
                    header['stat_anggaran'] = $('#stat_anggaran').val();
                    header['persetujuan'] = $('#persetujuan').val();

                    array = new Array();
                    array.push(header);
                    $('input[name="header_anggaran_download"]').val(JSON.stringify(array));
                    $('input[name="list_anggaran_download"]').val(JSON.stringify(inputs));
                    //alert(JSON.stringify(header));
                    $('form[id="downloadAnggaran"]').submit();
                  }

                  function changeButton(){
                    document.getElementById("send_r").addEventListener("click", function(event) {
                      check('Setuju');
                      event.preventDefault();
                    });
                    document.getElementById("accept_r").style.display="none";
                    document.getElementById("edit_r").style.display="block";
                    // document.getElementById("send_r").style.display="block";
                    var edit_href = document.getElementById('edit_r'); //or grab it by tagname etc
                    edit_href.href = "{{url('anggaran/persetujuan/'.$filters['nd_surat'].'/2')}}"
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
                                link = "{{url('anggaran/get/download')}}/"+ list_berkas[index][i]['id'];
                                hasil2[i] = '<div id="db_file_'+i+'"><div class="col-xs-10"><a href="'+link+'" ><li>'+ list_berkas[index][i]['name']+'</li></div>';
                                @if(Gate::check('ubah_item_a')&&$beda)
                                  hasil2[i] += '<div class="col-xs-1" ><i class="fa fa-download "></i></div></a>';
                                  hasil2[i] += '<div class="col-xs-1" onclick="deleteFileDB('+i+')"><i style="color:red" class="fa fa-close "></i></div><br/><br/></div>';
                                @else
                                  hasil2[i] += '<div class="col-xs-2"><i class="fa fa-download "></i></div></a><br/><br/></div>';
                                @endif
                              }
                            }
                          }
                          $("#list_download").append(hasil2);
                        }
                      }

                      if(upload_file[index]!=null){

                        // alert(JSON.stringify(upload_file[index]));
                        // console.log(upload_file[index]);
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

                    console.log('statusSimpan',simpan_file);
                    // temp_file=[];
                     // upload_file[index_modal]=[];
                    for(i=0;i<temp_file.length;i++){

                        // readerPrev(i,index_modal);
                        // upload_file[index_modal][i]=temp_file[i];
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
                    // temp_file=[];
                    document.getElementById('button_'+index_modal).innerHTML = title;
                    $('#modal_berkas').modal('hide');
                  });
                  $('#modal_berkas').on('hidden.bs.modal', function () {
                      if(!simpan_file){
                        hasil=[];
                        // temp_file=[];
                      }
                      $('#kembali').click(function() {
                        console.log('statusClose',simpan_file);
                        simpan_file = false;
                      });
                  })

                  $("#alasan_penolakan").click(function(){
                    document.getElementById("alasan_penolakan").value="";
                  });
                  
                  window.setUnitKerja("{{$userCabang}}","{{$userDivisi}}");
                  window.setDetailAnggaran('{{$filters['nd_surat']}}');
                  window.getListData();
                </script>
                @endsection