                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-callout.min.css') }}">
                <style type="text/css">
                  .hide {
                    display: none;
                  }
                </style>
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
                                    <div class="card-body collapse in ">
                                        <div class="card-block card-dashboard ">
                                          <div class="row">
                                            @if(session('success'))
                                            <div class="col-xs-7">
                                                <div class="alert alert-success">
                                                  Batch transaksi sebanyak <b>{{ session('success')[0] }} baris baru berhasil disimpan</b>.<br>
                                                  Batch transaksi sebanyak <b>{{ session('success')[1] }} baris berhasil diupdate</b>.
                                                </div>
                                              </div>
                                            @endif
                                            <div class="col-md-6">
                                              <div class="alert alert-info mb-2" role="alert" id="alert-dropping" style="display: block;">
                                                <strong>Perhatian!</strong> Silahkan menambahkan transaksi baru melalui tombol <i class="fa fa-plus"></i> pada tabel.
                                              </div>
                                              <div class="alert alert-warning mb-2" role="alert" id="alert-dropping" style="display: block;">
                                                <strong>Perhatian!</strong> Sistem akan melakukan generate secara otomatis untuk <b>kolom Account</b>. User tidak perlu melakukan input pada kolom tsb.
                                              </div>
                                            </div>
                                          </div>
                                            <!-- <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p> -->
                                            <div id="basicScenario"></div><br>
                                            <form method="POST" action="{{ url('transaksi/') }}" id="mainForm" enctype="multipart/form-data">
                                              {{ csrf_field() }}
                                              <div class="row">
                                                <div class="col-lg-6 col-md-12">
                                                  <fieldset class="form-group">
                                                    <label for="basicInputFile">Upload berkas</label>
                                                    <input type="file" class="form-control-file" id="basicInputFile" multiple="" name="berkas[]">
                                                  </fieldset>
                                                </div>
                                                <input type="hidden" name="batch_values" id="batch_values">
                                              </div>
                                              <div class="row">
                                                <div class="col-xs-2 pull-right">
                                                    <div class="form-group">
                                                        <button type="submit" onclick="populateBatchInput()" class="btn btn-primary pull-right" id="button_status" value="Simpan"><i class="fa fa-check"></i> Simpan perubahan batch</button>
                                                    </div>
                                                </div>
                                                <div class="col-xs-3 pull-right">
                                                  <div class="form-group">
                                                      <button type="submit" onclick="" class="btn btn-danger pull-right" id="button_status" value="Simpan"><i class="fa fa-check-circle"></i> Submit batch untuk Verifikasi</button>
                                                    </div>
                                                </div>
                                              </div>
                                            </form>
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
                  var inputs = [];
                  var item = m_anggaran = subpos = account_field = null;
                  var tempIdCounter = 0;

                  $(document).ready(function() {
                    var MyDateField = function(config) {
                        jsGrid.Field.call(this, config);
                    };
                     
                    MyDateField.prototype = new jsGrid.Field({
                     
                        css: "date-field", align: "center",
                     
                        myCustomProperty: "foo",
                     
                        sorter: function(date1, date2) {
                            return new Date(date1) - new Date(date2);
                        },
                     
                        itemTemplate: function(value) {
                            return value ? ("0" + new Date(value).getDate()).slice(-2) + '/' + ("0" + (new Date(value).getMonth() + 1)).slice(-2) + '/' + new Date(value).getFullYear() : '';
                        },
                     
                        insertTemplate: function(value) {
                            return this._insertPicker = $("<input>").datepicker({ defaultDate: new Date() });
                        },
                     
                        editTemplate: function(value) {
                            return this._editPicker = $("<input>").datepicker().datepicker("setDate", new Date(value));
                        },
                     
                        insertValue: function() {                            
                            return this._insertPicker.datepicker("getDate")!= null ? this._insertPicker.datepicker("getDate").toISOString() : '';
                        },
                        editValue: function() {
                            return this._editPicker.datepicker("getDate").toISOString();
                        }
                    });
                     
                    jsGrid.fields.date = MyDateField;

                    $("#basicScenario").jsGrid( {
                      width: "auto",
               
                      sorting: true, paging: true, autoload: true, editing: true, inserting: true,
               
                      pageSize: 5, pageButtonCount: 10,
                      
                      controller: {
                        loadData: function(filter) {
                          return $.ajax({
                              type: "GET", url: "{{  url('transaksi/get')}}", data: filter, dataType: "JSON"
                          })
                        },
                        insertItem: function (item) {
                          item["isNew"] = true;
                          item["tempId"] = ++tempIdCounter;
                          inputs.push(item);
                          console.log(item);
                        },
                        updateItem: function(item) {
                          if (item["isNew"]) {
                            inputs.splice(item["tempId"], 1, item);  
                          } else {
                            inputs.push(item);
                          }
                          console.log(item);  
                        }
                      }, 

                      fields: [
                          {
                            name: "id",
                            css: "hide",
                            width: 0,
                            readOnly: true
                          },
                          { 
                            type: "control", 
                            width: 60,
                            itemTemplate: function(value, item) {
                              var $result = $([]);

                              if(item) {
                                  $result = $result.add(this._createEditButton(item));
                              }
                  
                              if(item) {
                                  $result = $result.add(this._createDeleteButton(item));
                              }
                  
                              return $result;
                            } },
                          { 
                            name: "account", 
                            width: 200, 
                            align: "left",
                            type: "text", 
                            title: "Account", 
                            readOnly: true, 
                            itemTemplate: function(value) {
                              return "<span class='tag tag-default'><b>"+value+"</b></span>";
                            },
                            insertTemplate: function() {
                              account_field = jsGrid.fields.text.prototype.insertTemplate.call(this);
                              return account_field; } },
                          { 
                            name: "tgl", 
                            type: "date", 
                            width: 150, 
                            title: "Tanggal", 
                            align: "left",
                            validate: {
                              validator : "required",
                              message : "Kolom tanggal tidak boleh kosong."  
                            } },
                          { 
                            name: "item", 
                            width: 300, 
                            align: "left",
                            type: "select", 
                            items: getData('item'), 
                            valueField: "MAINACCOUNTID", 
                            textField: "NAME", 
                            title: "Item", 
                            selectedindex: 0,
                            insertTemplate: function() {
                                var result = jsGrid.fields.select.prototype.insertTemplate.call(this);
                                result.on("change", function() {
                                    populateAccount('item', $(this).val());
                                });
                                return result; } },
                          { 
                            name: "qty_item", 
                            width: 100, 
                            align: "left",
                            type: "number", 
                            title: "Jumlah Item",
                            itemTemplate: function(value) {
                              return value + " buah";
                            },
                            validate: {
                              validator: "min",
                              message: "Kolom jumlah item tidak boleh 0.",
                              param: [0]
                            }  },
                          { 
                            name: "desc", 
                            width: 300, 
                            type: "textarea", 
                            title: "Uraian", 
                            align: "left",
                            validate: {
                              validator: "required",
                              message: "Kolom uraian tidak boleh kosong."  
                            }  },
                          { 
                            name: "sub_pos", 
                            width: 200, 
                            align: "left",
                            type: "select", 
                            items: getData('subpos'), 
                            valueField: "VALUE", 
                            textField: "DESCRIPTION", 
                            title: "Subpos", 
                            insertTemplate: function() {
                                var result = jsGrid.fields.select.prototype.insertTemplate.call(this);
                                result.on("change", function() {
                                    populateAccount('subpos', $(this).val());
                                });
                                return result; },
                            }, 
                          { 
                            name: "mata_anggaran", 
                            width: 200, 
                            align: "left",
                            type: "select", 
                            items: getData('kegiatan'), 
                            valueField: "VALUE", 
                            textField: "DESCRIPTION", 
                            title: "Mata Anggaran", 
                            insertTemplate: function() {
                                var result = jsGrid.fields.select.prototype.insertTemplate.call(this);
                                result.on("change", function() {
                                    populateAccount('m_anggaran', $(this).val());
                                });
                                return result; },
                            }, 
                          { 
                            name: "bank", 
                            width: 200,
                            align: "left", 
                            type: "select", 
                            items: getData('bank'), 
                            valueField: "BANK", 
                            textField: "BANK_NAME", 
                            title: "Bank/Kas", 
                            valdiate: {
                              validator: "min",
                              message: "Kolom bank tidak boleh tidak dipilih.",
                              param: [1]
                             } },
                          { 
                            name: "anggaran", 
                            width: 200, 
                            align: "left",
                            type: "number", 
                            title: "Anggaran tersedia",
                            itemTemplate: function(value) {
                              return "<span class='tag tag-info'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                            },
                            valdiate: {
                              validator: "min",
                              message: "Kolom anggaran tidak boleh kosong.",
                              param: [1]
                             } },
                          { 
                            name: "total", 
                            align: "left",
                            width: 200, 
                            type: "number", 
                            title: "Total",
                            itemTemplate: function(value) {
                              return "<span class='tag tag-danger'><b>IDR " + parseInt(value).toLocaleString() + ",00</b></span>";
                            },
                            valdiate: {
                              validator: "min",
                              message: "Kolom total tidak boleh kosong.",
                              param: [1]
                             } },
                          { 
                            type: "control", 
                            width: 60,
                            itemTemplate: function(value, item) {
                              var $result = $([]);

                              if(item) {
                                  $result = $result.add(this._createEditButton(item));
                              }
                  
                              if(item) {
                                  $result = $result.add(this._createDeleteButton(item));
                              }
                  
                              return $result;
                            } }
                        ]
                    });
                  });

                  
                  function getData(type) {
                    var returned = function () {
                        var tmp = null;
                        $.ajax({
                            'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('transaksi/get/attributes') }}/" +type,
                            'success': function (data) {
                                tmp = data;
                            }
                        });
                        return tmp;
                    }();
                    return returned;
                  };

                  function populateAccount(type, value) {
                    switch (type) {
                      case 'item':
                        item = value;
                        break;
                      case 'm_anggaran':
                        m_anggaran = value;
                        break;
                      case 'subpos':
                        subpos = value;
                        break;
                    }
                    generateAccount(item, m_anggaran, subpos);
                  }

                  function generateAccount(item, m_anggaran, subpos) {
                    var userId = {{ Auth::user()->id }};
                    var account = item + '-THT-' + userId + '-' + subpos + '-' + m_anggaran;   
                    $(account_field).val(account);
                  };

                  function populateBatchInput(){
                    $('input[name="batch_values"]').val(JSON.stringify(inputs));
                  };
                </script>
                @endsection