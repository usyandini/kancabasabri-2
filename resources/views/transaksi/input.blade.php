                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-callout.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/toastr.min.css') }}">
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
                                      <h4 class="card-title">Pencarian Transaksi by Batch</h4>
                                      <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                                    </div>
                                    <div class="card-body collapse in">
                                      <div class="card-block">
                                        <form method="POST" action="{{ url('transaksi') }}">
                                          <div class="row">
                                            {{ csrf_field() }}
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                  <label>Tanggal Batch</label>
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
                            <div class="col-md-7">
                                <div class="alert alert-amber alert-dismissible fade in mb-2" role="alert">
                                  <h4 class="alert-heading mb-2">Perlu Diperhatikan!</h4>
                                  <ul>
                                    <li>Silahkan menambahkan transaksi baru melalui tombol <i class="fa fa-plus"></i> pada tabel.</li>
                                    <li>Sistem akan melakukan <b><i>automatic generate</i></b> untuk <b>kolom Account</b>. User tidak perlu melakukan input atau perubahan pada kolom tsb.</li>
                                    <li>Selama data batch yang ada <b>belum disubmit untuk verifikasi</b>, semua insert baru akan dimasukkan ke dalam <b>satu batch yang sama</b>. </li>
                                    <li>Pastikan untuk melakukan <b>simpan perubahan batch</b> sebelum melakukan <b>submit batch untuk verifikasi</b>.</li>
                                  </ul>
                                </div>
                              </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">List Transaksi</h4><br>
                                        {{-- @if(!$pending_batch)
                                        <p>Batch saat ini : <code>{{ date("d-m-Y", strtotime($current_batch_stat->created_at)) }}</code> | Terkahir Update : <code>{{ $current_batch_stat->updated_at }}</code> oleh <code>{{ $current_batch_stat['submitter']['name'] }}</code> | Status : <code>{{ $current_batch_stat->status() }}</code></p>
                                        @else
                                        <p>Info batch <code>{{ $current_batch_stat->created_at }}</code>: <code>Masih menunggu konfirmasi verifikasi. <b>Edit atau tambah baru tidak diperbolehkan.</b></code></p>
                                        @endif --}}
                                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    </div>
                                    <div class="card-body collapse in ">
                                        <div class="card-block card-dashboard ">
                                          <div class="row">
                                            @if(session('success'))
                                            <div class="col-xs-7">
                                                <div class="alert alert-success">
                                                  @if(session('success')[0] > 0)
                                                    Batch transaksi sebanyak <b>{{ session('success')[0] }} baris baru berhasil disimpan</b>.<br>
                                                  @endif
                                                  @if(session('success')[1] > 0)
                                                    Batch transaksi sebanyak <b>{{ session('success')[1] }} baris berhasil diupdate</b>.<br>
                                                  @endif
                                                  @if(session('success')[2] > 0)
                                                    Berkas batch transaksi sebanyak <b>{{ session('success')[2] }} berkas baru berhasil disimpan</b>.
                                                  @endif
                                                </div>
                                              </div>
                                            @endif
                                            @if(session('success_submit'))
                                              <div class="col-xs-6">
                                                <div class="alert alert-info">
                                                  Batch <code>{{ date("d-m-Y", strtotime(session('success_submit'))) }}</code> berhasil disubmit. <b>Silahkan tunggu verifikasi dari user.</b></code>
                                                </div>
                                              </div>
                                            @endif
                                          </div>
                                            <div id="basicScenario"></div><br>
                                              <div class="row">
                                                <form method="POST" action="{{ url('transaksi/') }}" id="mainForm" enctype="multipart/form-data">
                                                  {{ csrf_field() }}
                                                  <div class="col-lg-6 col-md-12">
                                                    @if(!$pending_batch)
                                                      <fieldset class="form-group">
                                                        <label for="basicInputFile">Upload berkas</label>
                                                        <input type="file" class="form-control-file" id="basicInputFile" multiple="" name="berkas[]">
                                                      </fieldset>
                                                    @endif
                                                    <div class="bs-callout-info callout-border-left callout-bordered callout-transparent mt-1 p-1">
                                                      <h4 class="info">List Berkas</h4>
                                                      <table>
                                                        @foreach($berkas as $value)
                                                          <tr>
                                                            <td width="25%">File: <a href="{{ asset('file/transaksi').'/'.$value->file_name }}" target="_blank">{{ $value->file_name }}</a></td>
                                                            <td width="25%">Diunggah: <b>{{ $value->created_at }}</b></td>
                                                            <td width="5%">
                                                            @if(!$pending_batch)
                                                              {{-- <form method="POST" action="{{ url('') }}"> --}}
                                                              <a href=""><i class="fa fa-times"></i> Hapus</a>
                                                              {{-- </form> --}}
                                                            @endif
                                                            </td>
                                                          </tr>
                                                        @endforeach
                                                      </table>
                                                    </div>
                                                  </div>
                                                  <input type="hidden" name="batch_values" id="batch_values">
                                                </form>
                                                <div class="col-lg-6 col-md-12">
                                                  <div class="bs-callout-danger callout-border-left callout-bordered mt-1 p-1">
                                                    <h4 class="danger">History Batch </h4>
                                                    <table>
                                                      @foreach($batch_history as $hist)
                                                        <tr>
                                                          <td><b class="text-danger">{{ $hist['stat'] }}</b></td>
                                                          <td>oleh <b class="text-warning">{{ $hist['submitted'] }}</b></td>
                                                          <td>| <code>{{ $hist['created_at'] }}</code></td>
                                                        </tr>
                                                      @endforeach
                                                    </table>
                                                  </div>
                                                </div>
                                              </div>
                                              @if(!$pending_batch)
                                              <div class="row">
                                                <div class="col-xs-2 pull-right">
                                                    <div class="form-group">
                                                        <button onclick="populateBatchInput()" class="btn btn-primary pull-right" id="simpan" value="Simpan"><i class="fa fa-check"></i> Simpan perubahan batch</button>
                                                    </div>
                                                </div>
                                                <div class="col-xs-3 pull-right">
                                                  <div class="form-group">
                                                      <button onclick="checkBatchSubmit()" data-toggle="modal" data-target="#xSmall" class="btn btn-danger pull-right" id="button_status"><i class="fa fa-check-circle"></i> Submit batch untuk Verifikasi</button>
                                                    </div>
                                                </div>
                                              </div>
                                              @endif
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </section>
                    <!-- Basic scenario end -->
                </div>

                <!-- Modal -->
                <div class="modal fade text-xs-left" id="xSmall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20"
                aria-hidden="true">
                  <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel20">Box Konfirmasi</h4>
                      </div>
                      <div class="modal-body" id="confirmation-msg">
                        <p>Anda akan melakukan submit untuk verifikasi batch ini. Anda tidak diperbolehkan untuk memperbarui item batch selama batch ini masih dalam proses verifikasi. Informasi batch ini : 
                        <ul>
                          @if(!$pending_batch)
                            <li>Batch saat ini : <code>{{ date("d-m-Y", strtotime($current_batch_stat->created_at)) }}</code></li>
                            <li>Terkahir Update : <code>{{ $current_batch_stat->updated_at }}</code> oleh <code>{{ $current_batch_stat['submitter']['name'] }}</code></li>
                            <li>Banyak item : <code id="totalRows"></code>, dengan <code>{{ count($berkas).' berkas lampiran' }}</code></li>
                          @endif
                        </ul>
                        </p>
                        <p>Apakah anda yakin dengan <b>data batch</b> yang anda input sudah sesuai?</p>
                      </div>
                      <div class="modal-footer">
                        <form method="POST" action="{{ url('transaksi/submit/verify') }}">
                          {{ csrf_field() }}
                          <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Tidak, kembali</button>
                          <button type="submit" class="btn btn-outline-primary">Ya, submit untuk verifikasi</button>
                        </form>
                      </div>
                    </div>
                  </div>
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
                <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                {{--<script src="{{ asset('app-assets/js/scripts/tables/jsgrid/jsgrid.min.js') }}" type="text/javascript"></script>--}}
                {{--<script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}" type="text/javascript"></script>--}}
                <!-- END PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                <script src="{{ asset('app-assets/js/scripts/extensions/toastr.min.js') }}" type="text/javascript"></script>
                <script type="text/javascript">
                  var inputs = [];
                  var item = m_anggaran = subpos = account_field = null;
                  var tempIdCounter = totalRows = 0;
                  var editableStat = {{ !$pending_batch ? 1 : 0 }};

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
                            return this._insertPicker.datepicker("getDate")!= null ? this._insertPicker.datepicker("getDate").toString() : '';
                        },
                        editValue: function() {
                            return this._editPicker.datepicker("getDate").toString();
                        }
                    });
                     
                    jsGrid.fields.date = MyDateField;

                    $("#basicScenario").jsGrid( {
                      width: "auto",
               
                      sorting: true, 
                      paging: true, 
                      autoload: true, 
                      editing: editableStat == 1 ? true : false, 
                      inserting: editableStat == 1 ? true : false,
               
                      pageSize: 10, pageButtonCount: 10,
                      
                      controller: {
                        loadData: function(filter) {
                          return $.ajax({
                              type: "GET", url: "{{  url($jsGrid_url) }}", data: filter, dataType: "JSON"
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
                            inputs.splice(item["tempId"]-1, 1, item);  
                          } else {
                            inputs.push(item);
                          }
                          console.log(item);  
                        },
                        deleteItem: function(item) {

                        }
                      }, 
                      onRefreshed: function(args) {
                        var items = args.grid.option("data");
                        items.forEach(function(item) {
                          totalRows += 1;
                        });

                        $('code[id="totalRows"]').html(totalRows + " baris");
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
                            css: editableStat == 1 ? '' : "hide"
                          },
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
                              return account_field; },
                            editTemplate: function(value) {
                              account_field = jsGrid.fields.text.prototype.editTemplate.call(this);
                              $(account_field).val(value);
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
                                return result; },
                            editTemplate: function(value) {
                                var result = jsGrid.fields.select.prototype.editTemplate.call(this);
                                $(result).val(value);
                                populateAccount('item', value);

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
                            editTemplate: function(value) {
                                var result = jsGrid.fields.select.prototype.editTemplate.call(this);
                                $(result).val(value);
                                populateAccount('subpos', value);

                                result.on("change", function() {
                                    populateAccount('subpos', $(this).val());
                                });
                                return result; }
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
                            editTemplate: function(value) {
                                var result = jsGrid.fields.select.prototype.editTemplate.call(this);
                                $(result).val(value);
                                populateAccount('m_anggaran', value);

                                result.on("change", function() {
                                    populateAccount('m_anggaran', $(this).val());
                                });
                                return result; }
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
                            css: editableStat == 1 ? '' : "hide"
                          }
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

                  function checkBatchSubmit() {

                  };

                  function populateBatchInput(){
                    if (inputs.length > 0 || $('input[name="berkas[]"]').val() != '') {
                      $('input[name="batch_values"]').val(JSON.stringify(inputs));
                      $('form[id="mainForm"]').submit();
                    } else {
                      toastr.error("Silahkan input perubahan pada tabel transaksi atau berkas transaksi untuk melakukan penyimpanan. Terima kasih.", "Perhatian", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:2e3});
                    }
                  };
                </script>
                @endsection