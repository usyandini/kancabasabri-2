                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
                <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/core/colors/palette-callout.min.css">
                @endsection

                @section('content')
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Informasi Transaksi</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Informasi Transaksi
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body"><!-- Basic scenario start -->
                    <section id="basic">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="card">
                                    <div class="card-header">
                                      <h4 class="card-title">Pencarian Transaksi</h4>
                                      <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                                    </div>
                                    <div class="card-body collapse in">
                                      <div class="card-block">
                                        <form method="POST" action="{{ url('transaksi') }}">
                                          <div class="row">
                                            {{ csrf_field() }}
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                  <label>Tanggal</label>
                                                  <input class="form-control" type="date" placeholder="{{ date('d/m/Y') }}" name="tgl_transaksi" id="tgl_transaksi" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                  <label>No. Batch</label>
                                                  <input class="form-control" type="text" id="batch"></input>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-xs-2">
                                                <div class="form-group">
                                                  <a href="#" class="btn btn-primary"><i class="fa fa-search"></i> Cari</a>
                                                </div>
                                              </div>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">List Transaksi</h4>
                                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    </div>
                                    <div class="card-body collapse in">
                                        <div class="card-block card-dashboard ">
                                            <!-- <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p> -->
                                            <div id="basicScenario"></div><br>
                                            <div class="col-lg-6 col-md-12 pull-right">
                                              <fieldset class="form-group">
                                                <label class="custom-file center-block block">
                                                  <input type="file" id="file_transaksi" class="custom-file-input">
                                                  <span class="custom-file-control"></span>
                                                </label>
                                              </fieldset>
                                            </div>
                                            <div class="col-xs-4">
                                              <label>Status<input type="text" class="form-control" id="status" readonly="readonly" value="Simpan"></input></label>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <button onclick="simpan_jsgrid()" class="btn btn-primary pull-right"><i class="fa fa-check" id="status" value="Simpan"></i> Simpan</button>
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
                {{--<script src="{{ asset('app-assets/js/scripts/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script>--}}
                {{--<script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}" type="text/javascript"></script>--}}
                <!-- END PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                {{-- <script src="{{ asset('app-assets/js/scripts/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script> --}}
                <script type="text/javascript">
                  // $(document).ready(function() {
                  //   $("#basicScenario").jsGrid( {
                  //     width:"100%", 
                  //     //height:"400px",
                  //     // sorting:true, 
                  //     autoload:true,
                  //     paging:true,
                  //     editButton:true,
                  //     deleteButton:true,
                  //     editing:true,

                  //     deleteConfirm: "Apakah anda yakin untuk menghapus?",
                  //     controller: {}                       
                       
                  //     fields: [
                  //           { name: "tgl_trans", type: "text", title: "Tanggal" },
                  //           { name: "item_trans", type: "select", title: "Item" }, 
                  //           { name: "jml_item", type: "number", title: "Jumlah Item" },
                  //           { name: "uraian", type: "text", title: "Uraian"},
                  //           { name: "subpos", type: "select", title: "Sub Pos"},
                  //           { name: "mata_anggaran", type: "select", title: "Mata Anggaran", width:200 }, 
                  //           { name: "kasbank", type: "select", title: "Kas/Bank" }, 
                  //           { name: "account", type: "text", title: "Account", items: db.countries, valueField: "id_akun", width:200 }, 
                  //           { name: "anggaran", type: "text", title: "Anggaran Tersedia", width:200, sorting: !1 }, 
                  //           { name: "jml_trans", type: "text", title: "Jumlah Transaksi", width:200, sorting: !1 }, 
                  //           { type: "control" }
                  //     ]
                  //   })
                  var x = [];
                  $(document).ready(function() {
                    $("#basicScenario").jsGrid( {
                      width: "100%",
               
                      sorting: true,
                      paging: true,
                      autoload: true,
                      editing: true,
                      inserting: true,
               
                      pageSize: 5,
                      pageButtonCount: 10,
                      
                      controller: {
                        loadData: function(filter) {
                          return $.ajax({
                              type: "GET",
                              url: "{{  url('dropping/get')}}",
                              data: filter,
                              dataType: "JSON"
                          })
                        },
                        insertItem: function (item) {
                          item["type"] = 'insert';
                          x.push(item);
                          console.log(x);
                            // return $.ajax({
                            //     type: "POST",
                            //     url: "{{ url('transaksi') }}",
                            //     data: {
                            //       "item" : item,
                            //       "_token" : "{{ csrf_token() }}"
                            //     }
                            // });
                        }

                      }, 

                      fields: [
                          { name: "journalnum", type: "text", title: "Nomor Jurnal", width: 90 },
                          { name: "bank", type: "text", title: "Nama Bank", width: 80 },
                          { name: "banknum", type: "text", title: "No. Rekening", width: 100 },
                          { name: "transdate", type: "text", title: "Tanggal Dropping", width: 100 },
                          { name: "debit", type: "text", title: "Nominal", width: 100 },
                          { name: "company", type: "text", title: "Kantor Cabang", width: 100 },
                          { name: "stat", type: "text", title: "Status Posting", itemTemplate:function(e) {
                            var content = e == '1' ? "Sesuai" : (e == '0' ? "Tidak sesuai" : 'Belum posting');
                            var tag = e == '1' ? "tag-success" : (e == '0' ? "tag-default" : 'tag-info');
                            return "<span class='tag "+tag+"'>"+content+"</span>" ;
                            } 
                          },
                          { type: "control" }
                        ]
                    });
                  });

                  function simpan_jsgrid() {
                    console.log(x);
                  };
                </script>
                @endsection