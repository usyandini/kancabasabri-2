                <script type="text/javascript">
                  var inputs = [];
                  var item = m_anggaran = subpos = account_field = null;
                  var tempIdCounter = totalRows = 0;
                  var editableStat = {{ $editable ? 1 : 0 }};

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
                            return this._insertPicker.datepicker("getDate")!= null ? this._insertPicker.datepicker("getDate") : '';
                        },
                        editValue: function() {
                            return this._editPicker.datepicker("getDate");
                        }
                    });
                     
                    jsGrid.fields.date = MyDateField;

                    $("#basicScenario").jsGrid( {
                      width: "100%",

                      sorting: true, 
                      paging: true, 
                      autoload: true, 
                      @if(Gate::check('update_t') || Gate::check('hapus_t'))
                          editing: editableStat == 1 ? true : false, 
                      @endif
                      @can('insert_t')
                          inserting: editableStat == 1 ? true : false,
                      @endcan
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
                            @if(!Gate::check('hapus_t'))
                                deleteButton: false,
                            @endif
                            @if(!Gate::check('update_t'))
                                editButton: false,
                            @endif
                            @if (!$editable || (!Gate::check('update_t') && !Gate::check('hapus_t')))
                              css: editableStat == 1 ? "" : "hide"
                            @endif
                          },
                          { 
                            name: "account", 
                            width: 200, 
                            align: "left",
                            type: "text", 
                            title: "Account", 
                            readOnly: true, 
                            itemTemplate: function(value) {
                              return "<span class='tag tag-default'>"+value+"</span>";
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
                            title: "Jenis Barang/Jasa", 
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
                            title: "Jumlah",
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
                              return "<span class='tag tag-danger'>IDR " + parseInt(value).toLocaleString() + ",00</span>";
                            },
                            valdiate: {
                              validator: "min",
                              message: "Kolom total tidak boleh kosong.",
                              param: [1]
                             } },
                          { 
                            type: "control", 
                            width: 60,
                            @if(!Gate::check('hapus_t'))
                                deleteButton: false,
                            @endif
                            @if(!Gate::check('update_t'))
                                editButton: false,
                            @endif
                            @if (!$editable || (!Gate::check('update_t') && !Gate::check('hapus_t')))
                              css: editableStat == 1 ? "" : "hide"
                            @endif
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
                    var account = item + '-THT-' + userId +'-00-' + subpos + '-' + m_anggaran;   
                    $(account_field).val(account);
                  };

                  function deleteBerkas(file_id, file_name) {
                    $('input[name="file_id"]').val(file_id);
                    $('input[name="file_name"]').val(file_name);
                    $('form[id="deleteBerkas"').submit();
                  };

                  function approveOrNot(el) {
                    if(el.checked) {
                      document.getElementById("reason").style.display = 'none';
                    } else {
                      document.getElementById("reason").style.display = 'block';
                      toastr.info("Silahkan input alasan penolakan anda untuk verifikasi lvl 1 ini. Terima kasih.", "Alasan penolakan dibutuhkan", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                    }
                  };

                  function submitVer() {
                    var valid = true;
                    if (!$('input[name="is_approved"]').is(':checked')) {
                      if ($('select[name="reason"]').val() == '0') {
                        valid = false;
                        toastr.error("Silahkan input alasan penolakan anda untuk verifikasi lvl 1 ini. Terima kasih.", "Alasan penolakan dibutuhkan.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                      } 
                    }
                    if (valid) {
                      $('form[id="verification"]').submit();
                    }
                  };

                  function checkBatchSubmit() {
                    if (totalRows > 0) {
                      $('#xSmall').modal()
                    } else {
                      toastr.error("Silahkan input data yang hendak disubmit. Terima kasih.", "Data tidak boleh kosong", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});                      
                    }
                  };

                  function populateBatchInput(){
                    if (inputs.length > 0 || $('input[name="berkas[]"]').val() != '') {
                      $('input[name="batch_values"]').val(JSON.stringify(inputs));
                      $('form[id="mainForm"]').submit();
                    } else {
                      toastr.error("Silahkan input perubahan pada tabel transaksi atau berkas transaksi untuk melakukan penyimpanan. Terima kasih.", "Input tidak boleh kosong.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                    }
                  };
                </script>