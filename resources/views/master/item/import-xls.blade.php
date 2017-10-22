				        @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/toggle/switchery.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/switch.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/toastr.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/validation/form-validation.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/custom.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
                @endsection

                @section('content')
                <div class="content-header row">
                  <div class="content-header-left col-md-6 col-xs-12 mb-2">
                    <h3 class="content-header-title mb-0">Import Item</h3>
                    <div class="row breadcrumbs-top">
                      <div class="breadcrumb-wrapper col-xs-12">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="{{ url('/item/transaksi') }}">Manajemen Item</a>
                          </li>
                          <li class="breadcrumb-item active">Import Item
                          </li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="content-body">
                  <div class="row">
                    <form class="form" action="{{ url('item/import/process') }}" method="POST" enctype="multipart/form-data">
                      <div class="col-md-8">
                        {{ csrf_field() }}
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-card-center">Form Import Item via Excel </h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                          </div>
                          <div class="card-body collapse in">
                            <div class="card-block">
                              <div class="row">
                                @if(count(session('insert_success')) > 0)
                                <div class="col-xs-12">
                                  <div class="alert alert-success">
                                    <ul>
                                      @foreach (session('insert_success') as $element)
                                      <li>{!! $element !!}</li>
                                      @endforeach
                                    </ul>
                                  </div>
                                </div>
                                @endif
                                @if(count($errors) > 0)
                                <div class="col-xs-12">
                                  <div class="alert alert-danger alert-dismissable">
                                    <ul>
                                      @foreach ($errors->all() as $error)
                                      <li>{!! $error !!}</li>
                                      @endforeach
                                    </ul>
                                  </div>
                                </div>
                                @endif
                              </div>
                              <div class="form-body">
                                <div class="row">
                                  <div class="form-group col-md-5">
                                    <label for="eventRegInput1">Jenis Item</label>
                                    <select class="form-control" name="type" required="">
                                      <option disabled="" selected="" value="-1">Pilih Jenis Item</option>
                                      <option value="transaksi">Item Transaksi</option>
                                      <option value="anggaran">Item Anggaran</option>
                                    </select>
                                  </div>
                                  <div class="form-group col-md-7">
                                    <label for="eventRegInput1">File Excel <code class="font-small-1">(.xls, .xlsx, atau .csv)</code></label>
                                    <input type="file" required="" class="form-control" placeholder="" name="file">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-block">
                              <div class="pull-right">
                                <a href="{{ url('item/transaksi') }}" class="btn btn-danger">
                                  <i class="ft-x"></i> Kembali
                                </a>    
                                <button type="submit" class="btn btn-outline-primary">
                                  <i class="fa fa-check-square-o"></i> Unggah
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                @endsection
                
                @section('customjs')
                <!-- BEGIN PAGE VENDOR JS-->
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script> 
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/jquery.dataTables.min.js') }}"></script>
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/modal/components-modal.min.js') }}"></script>
                <script type="text/javascript">
                  function getVal(s, v){
                    var inv_nrs;
                    inv_nrs = document.getElementById(s);
                    /* Ketika nama item diambil dari nama mata anggaran */
                    // if(s = 'kegiatan'){
                    //   document.getElementById('nama_item').value = inv_nrs.options[inv_nrs.selectedIndex].text;
                    // }
                    return document.getElementById(v).value = inv_nrs.options[inv_nrs.selectedIndex].value;
                  }

                  //alert for required in bahasa
                  document.addEventListener("DOMContentLoaded", function() {
                    var elements = document.getElementsByTagName("INPUT");
                    for (var i = 0; i < elements.length; i++) {
                      elements[i].oninvalid = function(e) {
                        e.target.setCustomValidity("");
                        if (!e.target.validity.valid) {
                          e.target.setCustomValidity("Kolom harap diisi");
                        }
                      };
                      elements[i].oninput = function(e) {
                        e.target.setCustomValidity("");
                      };
                    }

                    var select = document.getElementsByTagName("SELECT");
                    for (var i = 0; i < select.length; i++) {
                      select[i].oninvalid = function(e) {
                        e.target.setCustomValidity("");
                        if (!e.target.validity.valid) {
                          e.target.setCustomValidity("Harap memilih pada kolom ini");
                        }
                      };
                      select[i].oninput = function(e) {
                        e.target.setCustomValidity("");
                      };
                    }
                  });

                  $('input[type="radio"]').iCheck('enable')
                  $('input').iCheck({
                    checkboxClass: 'icheckbox_square-red',
                    radioClass: 'iradio_square-red',
                    increaseArea: '20%' // optional
                  });
                </script>
                @endsection		