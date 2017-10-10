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
                          <form method="POST" action="{{url('pelaporan/cari/'.$kategori.'/'.$type) }}" id="filterPelaporan" name="filterPelaporan" >
                            <div class="card-header">
                              <h4 class="card-title">Pencarian {{$sub_title}}</h4>
                              <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                              <div class="card-block ">
                                <div class="col-xs-10">
                                  {{ csrf_field() }}
                                  <div class="col-xs-3">
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
                                  <div class="col-xs-6">
                                      <div class="form-group">
                                        <label>Unit Kerja</label>
                                        <select class="select2 form-control " name="cari_unit_kerja" id="cari_unit_kerja">
                                          <option value="0">Semua</option>
                                          @foreach($unit_kerja as $unit)
                                          <?php
                                            $cabang = explode(" Cabang ", $unit->DESCRIPTION);
                                            // echo count($cabang);
                                            $id = "00".$unit->VALUE;
                                            if(count($cabang) > 1){
                                              // echo $cabang[1];
                                              $id = $unit->VALUE."00";
                                            }
                                          ?>
                                          @if(Gate::check("unit_".$id) )
                                            <option value="{{ $unit->DESCRIPTION }}">{{  $unit->DESCRIPTION}}</option>
                                          @endif
                                          @endforeach
                                        </select>
                                      </div>
                                  </div>
                                </div>
                                <div class="col-xs-10">
                                  <div class="col-xs-2">
                                    <div class="form-group">
                                      <label>TW</label>
                                      <select class="select2 form-control" name="cari_tw_dari" id="cari_tw_dari" onchange="changeTW(0,this)">
                                        <option value="0">None</option>
                                        <option value="1">I</option>
                                        <option value="2">II</option>
                                        <option value="3">III</option>
                                        <option value="4">IV</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xs-1">
                                    <div class="form-group">
                                      <div style="visibility:hidden">a</div>
                                      <div style="visibility:hidden">a</div>
                                      <label>s/d</label>
                                      <input type="hidden" name="type" id="type" value="Cari">
                                    </div>
                                  </div>
                                  <div class="col-xs-2">
                                    <div class="form-group">
                                      <label>TW</label>
                                      <select class="select2 form-control" name="cari_tw_ke" id="cari_tw_ke" onchange="changeTW(1,this)">
                                        <option value="0">None</option>
                                        <option value="1">I</option>
                                        <option value="2">II</option>
                                        <option value="3">III</option>
                                        <option value="4">IV</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xs-2">
                                    <div class="form-group">
                                      <label style="visibility:hidden">TW</label>
                                      <div class="btn btn-primary" onclick="cariPelaporan()" style="width:110px"><i class="fa fa-search"></i> Cari</div>                                            
                                    </div>
                                  </div>
                                  <div class="col-xs-1">
                                    <div class="form-group">
                                      <label style="visibility:hidden">TW</label>
                                      <div onclick="tambahPelaporan()" class="btn btn-success" style="width:110px"><i class="fa fa-plus"></i> Tambah</div>                                          
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                      <div class="row">
                        <div class="card">
                            <div class="card-body collapse in">
                                <div class="card-block">
                                  <form method="POST" action="{{url('pelaporan/submit/tambah') }}" id="insertLaporanAnggaran" name="insertLaporanAnggaran" enctype="multipart/form-data">
                                  {{ csrf_field() }}
                                  <div class="row">
                                  <hr />
                                  <div class="col-xs-12">
                                    <input type="hidden" name="item_form_master" id="item_form_master">
                                    <input type="hidden" name="kategori" id="kategori" value="{{$kategori}}">
                                    <input type="hidden" name="type" id="type" value="{{$type}}">
                                    
                                      <!-- <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p> -->
                                    <div class="col-xs-12">
                                      <div id="basicScenario"></div>
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
                    @if (session('back'))
                      toastr.error("{!! session('back') !!}", "{!! session('title') !!}", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:5000});
                    @endif
                    $("#basicScenario").jsGrid( {
                      width: "100%",
               
                      sorting: true,
                      paging: true,
                      autoload: true,

                      inserting: false,
                      editing:  false,
                      pageSize: 5,
                      pageButtonCount: 10,
                      noDataContent: "Data Belum Tersedia",
                      loadMessage: "Mohon, ditunggu...",
                      deleteConfirm: "Apakah anda yakin akan menghapus anggaran baris ini?",

                      controller: {
                        loadData: function(filter) {
                          <?php 
                            $tp = $type;
                            if($type == 'item' && $filters['type'] == 'Tambah'){
                              $tp = 1;
                            }
                          ?>
                          return $.ajax({
                              type: "GET",
                              url:"{{url('pelaporan/get/filteredPelaporan/'.$tp.'/'.$kategori.'/'.$filters['cari_tahun'].'/'.$filters['cari_tw_dari'].'/'.$filters['cari_tw_ke'].'/'.urlencode(strtolower($filters['unit_kerja'])))}} ",
                              data: filter,
                              dataType: "JSON"
                          })
                        },
                      }, 
                      fields: [
                          {
                            name: "id",
                            css: "hide",
                            width: 0

                          },
                          { name: "created_at", 
                            type: "text",
                            align:"center",
                            title: "Tanggal Buat", 
                            width: 100,
                            itemTemplate:function(value){
                              // var tanggal = "";
                              var date = new Date(value['date']);
                              var month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                              "Juli", "Agustus", "September", "Oktober", "November", "Desember"][date.getMonth()];
                              var tanggal = date.getDate()+' '+month + ' ' + date.getFullYear();
                              // tanggal = value.split(" ")
                              return tanggal;
                            }
                          },
                          { name: "unit_kerja", 
                            type: "text",
                            align:"center",
                            title: "Unit Kerja", 
                            width: 100
                          },
                          { name: "tw_dari", 
                            type: "text",
                            align:"center",
                            title: "Dari TW", 
                            width: 70,
                            itemTemplate:function(value){
                              var tw_dari = "";
                              switch(value){
                                case "1" : tw_dari="I";break;
                                case "2" : tw_dari="II";break;
                                case "3" : tw_dari="III";break;
                                case "4" : tw_dari="IV";break;
                              }
                              return tw_dari;
                            }
                          },
                          { name: "tw_ke", 
                            type: "text",
                            align:"center",
                            title: "KE TW", 
                            width: 70,
                            itemTemplate:function(value){
                              var tw_ke = "";
                              switch(value){
                                case "1" : tw_ke="I";break;
                                case "2" : tw_ke="II";break;
                                case "3" : tw_ke="III";break;
                                case "4" : tw_ke="IV";break;
                              }
                              return tw_ke;
                            }
                          },
                          { name: "id", align:"center", title: "Detail",  width: 50 ,

                            itemTemplate: function(value) {
                              @if($type=="item"&&$kategori=="usulan_program"&&$filters['type']!="Tambah")
                              var url = "{{url('pelaporan/edit_usulan_program').'/'}}"+value;
                              @elseif($type=="item"&&$filters['type']=="Tambah")
                              var url = "{{url('pelaporan/tambah/'.$type.'/'.$kategori).'/'}}"+value;
                              @else
                              var url = "{{url('pelaporan/edit/'.$type.'/'.$kategori).'/'}}"+value;
                              @endif
                              var button = "<a href='"+url+"' class='btn btn-sm btn-primary '> Detail</a>";
                              return button;
                            }
                          }
                      ]
                    })
                    
                  });

                  function changeTW(type,e){

                    // alert(e.id)

                    id_tw_dari="";id_tw_ke="";
                    if(e.id == "tw_dari"||e.id == "tw_ke"){
                      id_tw_dari = "tw_dari";
                      id_tw_ke = "tw_ke";
                    }else if(e.id == "cari_tw_dari"||e.id == "cari_tw_ke"){
                      id_tw_dari = "cari_tw_dari";
                      id_tw_ke = "cari_tw_ke";
                    }
                    // console.log(this.id);
                    tw_dari = document.getElementById(id_tw_dari).value;
                    if(type == 0){
                      // alert(id_tw_ke);
                    // alert(document.getElementById(id_tw_ke).value);
                      document.getElementById(id_tw_ke).selectedIndex = tw_dari;
                      document.getElementById('select2-'+id_tw_ke+'-container').innerHTML = document.getElementById(id_tw_ke).options.item(tw_dari).text;
                      document.getElementById('select2-'+id_tw_ke+'-container').title = document.getElementById(id_tw_ke).options.item(tw_dari).text;
                    }
                    tw_ke = document.getElementById(id_tw_ke).value;
                    if(e.id == "tw_dari"||e.id == "tw_ke"){
                      if(tw_dari > 0){

                        tanggal_mulai = document.getElementById('tanggal_mulai');
                        tanggal_selesai = document.getElementById('tanggal_selesai');
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
                  }

                  function cariPelaporan(){
                    if(document.getElementById("cari_tw_dari").value=="0"||document.getElementById("cari_tw_ke").value=="0"){
                      toastr.error("Silahkan Pilih Salah Satu TW. Terima kasih.", "TW Belum Dipilih.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    }else{
                      $('form[id="filterPelaporan"]').submit();
                    }
                  }

                  function tambahPelaporan(){
                    @if($type == "item")
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
                    $("#type").val("Tambah")
                    $('select[name="cari_tahun"] option[value=0]').attr("selected","selected");
                    $('select[name="cari_unit_kerja"] option[value="{{$units}}"]').attr("selected","selected");
                    $('select[name="cari_tw_dari"] option[value='+tw+']').attr("selected","selected");
                    $('select[name="cari_tw_ke"] option[value='+tw+']').attr("selected","selected");
                    $('form[id="filterPelaporan"]').submit();
                    
                    @else
                    url = "{{url('pelaporan/tambah/'.$type.'/'.$kategori.'/-1') }}";
                    window.location.href = url;
                    @endif
                    
                  }


                </script>
                @endsection