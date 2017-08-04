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
                        <h3 class="content-header-title mb-0">Persetujuan Transaksi</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Persetujuan Transaksi
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
                                      <h4 class="card-title">Persetujuan Transaksi</h4>
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
                                                  <input class="form-control" type="date" placeholder="{{ date('d/m/Y') }}" name="tgl_transaksi" id="tgl_transaksi" value="{{ date('Y-m-d') }}" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                  <label>No. Batch</label>
                                                  <input class="form-control" type="text" id="batch" readonly="readonly"></input>
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
                                    <div class="alert alert-warning mb-4" role="alert" id="alert-dropping" style="display: block;">
                                      <strong>Perhatian!</strong> Persetujuan transaksi hanya dilakukan oleh <b>Divisi Kasimin</b>.
                                    </div>
                                    <div class="card-body collapse in ">
                                        <div class="card-block card-dashboard ">
                                            <!-- <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p> -->
                                            <div id="basicScenario"></div><br>
                                            <div class="col-xs-12 pull-right">
                                              <label>Status<input type="text" class="form-control" id="status" readonly="readonly" value="Simpan"></input></label>
                                              <div class="form-groups">
                                                  <button type="submit" class="btn btn-primary" id="button_status" value="Terima"><i class="fa fa-check"> Terima</i></button>
                                                  <button type="submit" class="btn btn-danger" id="button_status" value="Tolak"><i class="fa fa-times"> Tolak</i></button>
                                              </div>
                                              <div class="form-group">
                                                <a href="#" class="btn btn-success pull-right"><i class="fa fa-check-square-o"></i> Kirim</a>
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
                      width: "auto",
               
                      sorting: true,
                      paging: true,
                      autoload: true,
                      editing: false,
                      inserting: false,
                      align: "center",
               
                      pageSize: 5,
                      pageButtonCount: 10,
                      
                      controller: {
                        loadData: function(filter) {
                          return $.ajax({
                              type: "GET",
                              url: "{{  url('transaksi/get')}}",
                              data: filter,
                              dataType: "JSON"
                          })
                        },
                        insertItem: function (item) {
                          item["type"] = 'insert';
                          x.push(item);
                          console.log(x);
                          //   return $.ajax({
                          //       type: "POST",
                          //       url: "{{ url('transaksi/transaksi_process') }}",
                          //       data: {
                          //         "item" : item,
                          //        "_token" : "{{ csrf_token() }}"
                          //       }
                          //   });
                          /*$.extend(item, {
                            tgl: $("#tgl").val(),
                            item: parseInt($("#item").val(), 10),
                            qty_item: parseInt($("#qty_item").val(), 10),
                            desc: $("#desc").val(),
                            sub_pos: parseInt($("#sub_pos").val(), 10),
                            mata_anggaran: parseInt($("#mata_anggaran").val(), 10),
                            bank: $("#bank").val(),
                            account: $("#account").val(),
                            anggaran: $("#anggaran").val(),
                            total: $("#total").val()
                          });
                            $("#basicScenario").jsGrid(isNew ? "insertItem" : "loadData", item);*/
                          }

                      }, 

                      fields: [
                          { name: "tgl", type: "text", width: 100, title: "Tanggal" },
                          { name: "item", width: 300, type: "select", items: getData('item'), valueField: "MAINACCOUNTID", textField: "NAME", title: "Item", align: "center" },
                          { name: "qty_item", width: 100, type: "number", title: "Jumlah Item" },
                          { name: "desc", width: 100, type: "text", title: "Uraian", align: "center" },
                          { name: "sub_pos", width: 100, type: "select", items: getData('subpos'), valueField: "VALUE", textField: "DESCRIPTION", title: "Subpos"},
                          { name: "mata_anggaran", width: 200, type: "select", items: getData('kegiatan'), valueField: "VALUE", textField: "DESCRIPTION", title: "Mata Anggaran"},
                          { name: "bank", width: 200, type: "select", items: getData('bank'), valueField: "BANK", textField: "BANK_NAME", title: "Bank/Kas"},
                          { name: "account", width: 200, type: "text", title: "Account" },
                          { name: "anggaran", width: 200, type: "text", title: "Anggaran tersedia" },
                          { name: "total", width: 100, type: "text", title: "Total" }
                        ]
                    });
                  });
                  
                  function getData(type) {
                    var returned = function () {
                        var tmp = null;
                        $.ajax({
                            'async': false,
                            'type': "GET",
                            'dataType': 'JSON',
                            'url': "{{ url('transaksi/get/attributes') }}/" +type,
                            'success': function (data) {
                                tmp = data;
                            }
                        });
                        return tmp;
                    }();
                    return returned;
                  };

                  function simpan_jsgrid(){
                    /*$('#basicScenario').each(function(){
                        x.push($(this).html());
                    });
                    $('#button_status').click(function(){
                        $.ajax({
                          type : "POST",
                          url : "{{ url('transaksi/transaksi_process') }}",
                          data : "content="+x,
                          success: function(item) {
                              alert(item);// alert the data from the server
                          },
                          error : function() {
                          }
                         });
                    });*/
                    console.log(x);
                  };
                </script>
                @endsection