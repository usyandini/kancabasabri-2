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
                              <div class="col-lg-6 col-xl-3 mb-1">
                                <div class="form-group">
                                  <select class="select2 form-control " name="cari_unit_kerja" id="cari_unit_kerja" onchange="set_nd_surat()">
                                    <option disabled="" selected="">Unit Kerja</option>
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
                              <div class="col-lg-6 col-xl-3 mb-1">
                                <div class="form-group">
                                  <select class="select2 form-control" name="cari_stat_anggaran" id="cari_stat_anggaran" onchange="set_nd_surat()">
                                    <option disabled="" selected="">Status Anggaran</option>
                                    <option value="0">Semua</option>
                                    <option value="1">Draft</option>
                                    <option value="2">Transfer</option>
                                    <option value="3">Complate</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-6 col-xl-3 mb-1">
                                <div class="form-group">
                                  <select class="select2 form-control " name="cari_nd_surat" id="cari_nd_surat">
                                    <option disabled="" selected="">ND/Surat</option>
                                  </select>
                                </div>
                              </div>
                              
                              
                              <div class="col-lg-3 col-xl-3 mb-1">
                                <a href="#" class="btn btn-outline-primary" onclick="cariAnggaran()"><i class="fa fa-search"></i> Cari</a>                                            
                              </div>
                            </div>
                            <div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">@if(Gate::check('tambah_a'))
                          <a href="{{ url('anggaran/tambah') }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Kegiatan dan Anggaran</a>                                   
                        @endif</div>
                    <div class="card-body collapse in">
                      <div class="card-block ">
                        
                        <div id="basicScenario">
                           
                        </div>
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
                @if(session('batas'))
                toastr.error("{{session('batas')}}", "Perhatian.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                @endif

                $(document).ready(function() {
                  $("#basicScenario").jsGrid( {
                    width: "100%",

                    sorting: true,
                    paging: true,
                    autoload: true,

                    pageSize: 5,
                    pageButtonCount: 10,
                    noDataContent: "Data Belum Tersedia",
                    loadMessage: "Mohon, ditunggu...",

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
                      align: "center",
                      title: "Tanggal", 
                      width: 90,
                      itemTemplate: function (value) { debugger; if (value == "") return ""; else return new Date(value).toLocaleDateString(); }
                      // ,
                      // itemTemplate:function(value,item)
                      // {
                      //   return date('d-m-Y',value);
                      // }
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
                          <?php
                            $setuju = false;
                            if(Gate::check('setuju_i')||Gate::check('setuju_ii')||Gate::check('setuju_iii')
                              ||Gate::check('setuju_iv')||Gate::check('setuju_v')||Gate::check('setuju_vi')
                              ||Gate::check('setuju_vii')||Gate::check('setuju_viii'))
                              {
                                $setuju = true;
                              } 
                          ?>
                          @if($setuju)
                          var button = "<a href='{{ url('anggaran/persetujuan/')}}/"+value+"./1'   class='btn btn-sm btn-primary'> Detail</a>";
                          @else
                          var button = "<a href='{{ url('anggaran/edit/')}}/"+value+"'   class='btn btn-sm btn-primary'> Detail</a>";
                          @endif
                          return button;
                        }
                      }
                    ]
                  })

                });

                function set_nd_surat(){
                  cari_unit_kerja = document.getElementById('cari_unit_kerja').value;
                  cari_stat_anggaran = document.getElementById('cari_stat_anggaran').value;
                  if(cari_stat_anggaran == "Status Anggaran"){
                    cari_stat_anggaran = 0;
                  }
                  if(cari_unit_kerja != "Unit Kerja"||cari_stat_anggaran != "Status Anggaran"){
                    $.ajax({
                      'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('anggaran/get/nd_surat').'/' }}"+encodeURI(cari_unit_kerja)+"/"+encodeURI(cari_stat_anggaran),
                      'success': function (data) {

                        nd_surat_option = document.getElementById('cari_nd_surat');
                        var length = nd_surat_option.options.length;
                        // alert(length);
                        for (i = 1; i < length; i++) {
                          // alert(nd_surat_option.options[1].innerHTML);
                          nd_surat_option.options[1] = null;
                        }
                        for(i =0 ;i<data.length;i++){
                          var value = data[i].nd_surat;
                          var desc = data[i].nd_surat;
                          nd_surat_option.options[nd_surat_option.options.length] = new Option(desc, value);
                        }

                      }
                    });
                  }
                }
                function cariAnggaran(){
                  if(document.getElementById("cari_nd_surat").value=="ND/Surat"){
                    toastr.error("Silahkan Pilih ND/Surat. Terima kasih.", "ND/Surat Belum Dipilih.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                  }else if(document.getElementById("cari_stat_anggaran").value=="Status Anggaran"){
                    toastr.error("Silahkan Pilih Status Anggaran. Terima kasih.", "Status Anggaran Belum Dipilih.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                  }else if(document.getElementById("cari_unit_kerja").value=="0"||document.getElementById("cari_unit_kerja").value=="Unit Kerja"){
                    toastr.error("Silahkan Pilih Salah Satu Unit Kerja. Terima kasih.", "Unit Kerja Belum Dipilih.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                  }else{
                    $('form[id="filterAnggaran"]').submit();
                  }
                }

              </script>
              @endsection