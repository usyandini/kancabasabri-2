                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
                @endsection

                @section('content')
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Kirim Transaksi</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="">Informasi Transaksi</a>
                                    </li>
                                    <li class="breadcrumb-item active">Kirim Transaksi
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body"><!-- Basic scenario start -->
                    <section id="basic">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Data Transaksi</h4>
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
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                  <a href="#" class="btn btn-success pull-right"><i class="fa fa-check-square-o"></i> Kirim</a>
                                                  <a href="{{ url('/transaksi') }}" class="btn btn-danger"><i class="fa fa-times"></i> Kembali</a>
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
                {{-- <script src="{{ asset('app-assets/js/scripts/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script> --}}
                <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE LEVEL JS-->

                <script type="text/javascript">
                  $(document).ready(function() {
                    $("#basicScenario").jsGrid( {
                      width:"100%", 
                      // height:"400px",
                      sorting:!0, 
                      autoload:!0,
                      paging:!0,
                      pagesize:15,
                      pageButtonCount:5, 
                      
                      fields: [
	                        { name: "tgl_trans", type: "text", title: "Tanggal" },
			                { name: "item_trans", type: "select", title: "Item" }, 
			                { name: "jml_item", type: "number", title: "Jumlah Item" },
			                { name: "uraian", type: "text", title: "Uraian"},
			                { name: "subpos", type: "select", title: "Sub Pos"},
			                { name: "mata_anggaran", type: "select", title: "Mata Anggaran", width:200 }, 
			                { name: "kasbank", type: "select", title: "Kas/Bank" }, 
			                { name: "account", type: "text", title: "Account", items: db.countries, valueField: "id_akun", width:200 }, 
			                { name: "anggaran", type: "text", title: "Anggaran Tersedia", width:200, sorting: !1 }, 
			                { name: "jml_trans", type: "text", title: "Jumlah Transaksi", width:200, sorting: !1 }
                      ]
                    })
                  });
                </script>
                @endsection