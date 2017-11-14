                <script type="text/javascript">
                  var inputs = [];
                  var item = m_anggaran = subpos = mainaccount = account_field = date_field = anggaran_field = actual_anggaran = null;
                  var tempIdCounter = totalRows = 0;
                  var is_all_anggaran_safe = is_all_rows_not_rejected = true;
                  var berkas = {{ count($berkas) }}
                  var empty_batch = {{ $empty_batch ? 'true' : 'false' }}
                  var editableStat = {{ $editable ? 1 : 0 }};

                  $(document).ready(function() {
                    var keep_anggaran_btn = document.getElementById("keep_anggaran");
                    if (keep_anggaran_btn) {
                      keep_anggaran_btn.onclick = function () {
                        @if(!$empty_batch)
                        location.href = "{{ url('transaksi/refresh/anggaran').'/'.$active_batch->id }}";
                        @endif
                      };
                    }

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
                      rowClass: function(item, itemIndex) {
                        return item.is_anggaran_safe != true ? "contoh" : (item.is_rejected == true ? "contohh" : "")
                      }, 
                      @if(Gate::check('ubah_item_t') || Gate::check('hapus_item_t'))
                          editing: editableStat == 1 ? true : false, 
                      @endif
                      @can('tambah_item_t')
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
                          item["is_anggaran_safe"] = true;
                          inputs.push(item);
                        },
                        updateItem: function(item) {
                          if (item["isNew"]) {
                            inputs.splice(item["tempId"]-1, 1, item);  
                          } else {
                            inputs.push(item);
                          } 
                        },
                        deleteItem: function(item) {
                          if (item["isNew"]) {
                            inputs.splice(item["tempId"]-1, 1);
                          } else {
                            item["toBeDeleted"] = true;
                            inputs.push(item);
                            toastr.info("Jangan lupa untuk menekan tombol <b>Simpan perubahan batch</b> setelah penghapusan item.", "Update List Batch", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                          }
                        }
                      }, 
                      onRefreshed: function(args) {
                        resetAccountEtc()
                        date_field = mainaccount = null;
                        var items = args.grid.option("data");
                        items.forEach(function(item) {
                          if (item.is_anggaran_safe != true) {
                            is_all_anggaran_safe = false
                          }
                          if (item.is_rejected == true) {
                            is_all_rows_not_rejected = false
                          }
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
                            @if(!Gate::check('hapus_item_t'))
                                deleteButton: false,
                            @endif
                            @if(!Gate::check('ubah_item_t'))
                                editButton: false,
                            @endif
                            @if (!$editable || (!Gate::check('ubah_item_t') && !Gate::check('hapus_item_t')))
                              css: editableStat == 1 ? "" : "hide"
                            @endif
                          },
                          { 
                            name: "tgl", 
                            type: "date", 
                            width: 150, 
                            title: "Tanggal", 
                            align: "left",
                            validate: {
                              validator : "required",
                              message : "Kolom tanggal tidak boleh kosong."  
                            },
                            insertTemplate: function(value) {
                              var result = this._insertPicker = $("<input>").datepicker({ defaultDate: new Date() })
                              result.on("change", function() {
                                date_field = result.val()
                                
                                if (validateTransaksiDate(date_field)) {
                                  date_field = ("0" + new Date(date_field).getDate()).slice(-2) + '-' + ("0" + (new Date(date_field).getMonth() + 1)).slice(-2) + '-' + new Date(date_field).getFullYear()
                                  if (mainaccount != null) {
                                    getCombination()
                                  }
                                } else {
                                  toastr.error("Mohon input <b>tanggal transaksi</b> yang valid. Terima kasih", "Tanggal transaksi tidak valid.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                                  $(result).val(null)
                                }
                              })
                              return result;
                            },
                            editTemplate: function(value) {
                              var result = this._editPicker = $("<input>").datepicker().datepicker("setDate", new Date(value));
                              date_field = ("0" + new Date(value).getDate()).slice(-2) + '-' + ("0" + (new Date(value).getMonth() + 1)).slice(-2) + '-' + new Date(value).getFullYear()
                              result.on("change", function() {
                                date_field = result.val()
                                
                                if (validateTransaksiDate(date_field)) {
                                  date_field = ("0" + new Date(date_field).getDate()).slice(-2) + '-' + ("0" + (new Date(date_field).getMonth() + 1)).slice(-2) + '-' + new Date(date_field).getFullYear()
                                  if (mainaccount != null) {
                                    getCombination()
                                  }
                                } else {
                                  toastr.error("Mohon input <b>tanggal transaksi</b> yang valid. Terima kasih", "Tanggal transaksi tidak valid.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                                  $(result).val(null)
                                }
                              })
                              return result;   
                            }
                          },
                          { 
                            name: "item", 
                            width: 300, 
                            align: "left",
                            type: "select", 
                            items: {!! $item !!}, 
                            valueField: "VALUE", 
                            textField: "nama_item", 
                            title: "Jenis Barang/Jasa", 
                            validate: {
                              validator: function(value, item) {
                                return value != "-1"
                              },
                              message: "Kolom Jenis Barang/Jasa tidak boleh tidak dipilih."
                            },
                            insertTemplate: function() {
                                var result = jsGrid.fields.select.prototype.insertTemplate.call(this);
                                result.on("change", function() {
                                    if (date_field == null) {
                                      toastr.error("Mohon input <b>tanggal transaksi</b> terlebih dahulu. Terima kasih", "Tanggal transaksi dibutuhkan.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                                      $(result).val('-1')
                                    } else {
                                      mainaccount = $(this).val()
                                      getCombination()
                                    }
                                });
                                return result; },
                            editTemplate: function(value) {
                                var result = jsGrid.fields.select.prototype.editTemplate.call(this);
                                $(result).val(value)
                                result.on("change", function() {
                                    mainaccount = $(this).val()
                                    getCombination()
                                });
                                return result; } 
                              },
                          { 
                            name: "account", 
                            width: 250, 
                            align: "left",
                            type: "text", 
                            title: "Account", 
                            readOnly: true,
                            validate: {
                              validator: function(value, item) {
                                return value != "Auto generate dari Account"
                              },
                              message: "Kolom Account tidak boleh kosong."
                            },
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
                            name: "anggaran", 
                            width: 200, 
                            align: "left",
                            type: "text", 
                            title: "Anggaran Tersedia (Awal)",
                            readOnly: true,
                            validate: {
                              validator: function(value, item) {
                                return value != "Auto generate dari Account"
                              },
                              message: "Kolom Anggaran Tersedia (Awal) tidak boleh kosong."
                            },
                            itemTemplate: function(value) {
                              //var nilai = validDigits(value);
                              value = addCommas(value);
                              return "<b>Rp. " + value + ",00</b>";
                            },
                            editTemplate: function(value) {
                              var val = addCommas(value);
                              anggaran_field = jsGrid.fields.text.prototype.editTemplate.call(this)
                              $(anggaran_field).val(val)
                              return anggaran_field
                            },
                            insertTemplate: function(value) {
                              anggaran_field = jsGrid.fields.text.prototype.insertTemplate.call(this)
                              return anggaran_field
                            } },
                          { 
                            name: "actual_anggaran", 
                            width: 300, 
                            align: "left",
                            type: "text", 
                            title: "Anggaran Tersedia (Aktual Estimasi)",
                            readOnly: true,
                            validate: {
                              validator: function(value, item) {
                                return value != "Auto generate dari Account"
                              },
                              message: "Kolom Anggaran Tersedia (Aktual Estimasi) tidak boleh kosong."
                            },
                            itemTemplate: function(value) {
                              //var nilai = validDigits(value);
                              value = addCommas(value);
                              return "<b>Rp. " + value + ",00</b>";
                            },
                            editTemplate: function(value) {
                              var val = addCommas(value);
                              actual_anggaran = jsGrid.fields.text.prototype.editTemplate.call(this)
                              $(actual_anggaran).val(val)
                              return actual_anggaran
                            },
                            insertTemplate: function(value) {
                              actual_anggaran = jsGrid.fields.text.prototype.insertTemplate.call(this)
                              return actual_anggaran
                            } },
                          { 
                            name: "sub_pos", 
                            width: 250, 
                            align: "left",
                            type: "select", 
                            items: {!! $subpos !!}, 
                            valueField: "VALUE", 
                            textField: "DESCRIPTION", 
                            readOnly: true,
                            title: "Subpos",
                            validate: {
                              validator: function(value, item) {
                                return value != "-1"
                              },
                              message: "Kolom Subpos tidak boleh kosong."
                            }, 
                            insertTemplate: function() {
                                subpos = jsGrid.fields.select.prototype.insertTemplate.call(this);
                                return subpos; },
                            editTemplate: function(value) {
                                subpos = jsGrid.fields.select.prototype.editTemplate.call(this);
                                $(subpos).val(value)
                                return subpos; 
                              }}, 
                            { 
                            name: "mata_anggaran", 
                            width: 250, 
                            align: "left",
                            type: "select", 
                            items: {!! $kegiatan !!}, 
                            valueField: "VALUE", 
                            textField: "DESCRIPTION", 
                            readOnly: true,
                            title: "Mata Anggaran", 
                            validate: {
                              validator: function(value, item) {
                                return value != "-1"
                              },
                              message: "Kolom Mata Anggaran tidak boleh kosong."
                            },
                            insertTemplate: function() {
                                m_anggaran = jsGrid.fields.select.prototype.insertTemplate.call(this);
                                return m_anggaran; },
                            editTemplate: function(value) {
                                m_anggaran = jsGrid.fields.select.prototype.editTemplate.call(this);
                                $(m_anggaran).val(value)
                                return m_anggaran; }
                            }, 
                          { 
                            name: "qty_item", 
                            width: 250, 
                            align: "left",
                            type: "number", 
                            title: "Jumlah Diajukan (Kuantitas)",
                            validate: {
                              validator: function(value, item) {
                                return value != ''
                              },
                              message: "Kolom jumlah item tidak boleh kosong."
                            }  },
                          { 
                            name: "total", 
                            align: "left",
                            width: 200, 
                            type: "text", 
                            title: "Jumlah Diajukan (Rupiah)",
                            validate: {
                              validator: function(value, item) {
                                return value != ''
                              },
                              message: "Kolom jumlah dalam Rupiah tidak boleh kosong."
                            },
                            insertTemplate: function() {
                              var result = jsGrid.fields.text.prototype.insertTemplate.call(this)
                              result.on("keyup", function() {
                                var nilai = validDigits($(this).val());
                                var val = addCommas(nilai);
                                $(result).val(val)
                              })
                              return result
                            },
                            itemTemplate: function(value) {
                              //var nilai = validDigits(value);
                              value = addCommas(value);
                              return "<b>Rp. " + value + ",00</b>";
                            },
                            editTemplate: function(value) {
                              var val = addCommas(value);
                              var result = jsGrid.fields.text.prototype.editTemplate.call(this)
                              $(result).val(val)

                              result.on("keyup", function() {
                                nilai = validDigits($(this).val());
                                val = addCommas(nilai);
                                $(result).val(val)
                              })
                              return result 
                            } },
                          { 
                            name: "bank", 
                            width: 250,
                            align: "left", 
                            type: "select", 
                            items: {!! $bank !!}, 
                            valueField: "BANK", 
                            textField: "BANK_NAME", 
                            title: "Bank/Kas",
                            insertTemplate: function() {
                              var result = jsGrid.fields.select.prototype.insertTemplate.call(this)
                              var i = 0
                              @foreach ($bank as $b)
                                {{ !$b['accessible'] ? 'result[0][i].disabled = true' : '' }}
                                i++
                              @endforeach
                              return result
                            },
                            validate: {
                              validator: function(value, item) {
                                return value != "-1"
                              },
                              message: "Kolom Bank/Kas tidak boleh tidak dipilih."
                             } },
                          { 
                            name: "desc", 
                            width: 300, 
                            type: "textarea", 
                            title: "Uraian", 
                            align: "left",
                            validate: {
                              validator: "required",
                              message: "Kolom uraian tidak boleh kosong."  
                            } },
                          { 
                            type: "control", 
                            width: 60,
                            @if(!Gate::check('hapus_item_t'))
                                deleteButton: false,
                            @endif
                            @if(!Gate::check('ubah_item_t'))
                                editButton: false,
                            @endif
                            @if (!$editable || (!Gate::check('ubah_item_t') && !Gate::check('hapus_item_t')))
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
                        if (type == 'item' && tmp.length == 1 && !empty_batch) {
                            toastr.error("<b>Kombinasi Account</b> tidak ditemukan sama sekali untuk cabang dan/atau divisi anda.", "Kombinasi Account diperlukan.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                        }
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

                  function validateTransaksiDate(dateInput) {
                    var today = new Date()
                    var month = today.getMonth()
                    var date = today.getDate()
                    var year = today.getFullYear()
                    
                    if ((date > 5 && (new Date(dateInput).getMonth() < month)) || (new Date(dateInput).getMonth() > month)) {
                      return false
                    } 

                    return true
                  }

                  function getCombination() {
                    var combination = null;
                    // alert( "{{ url('item/get/combination').'/' }}" + mainaccount + "/" + date_field)
                    $.ajax({
                      'async': false, 'type': "GET", 'dataType': "JSON", 'url': "{{ url('item/get/combination').'/' }}" + mainaccount + "/" + date_field,
                      'success': function(data) {
                        combination = data;
                        console.log('kombinasi',data);
                      }
                    })
                    if (combination == null) {
                      toastr.error("Anggaran pada <b>tanggal transaksi dan jenis barang/jasa</b> yang diinputkan tidak ditemukan.", "Anggaran tidak ditemukan.", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                      resetAccountEtc()
                    } else {
                      populateAccountEtc(combination)
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

                  function resetAccountEtc() {
                    $(account_field).val('Auto generate dari Account')
                    $(anggaran_field).val('Auto generate dari Account')
                    $(actual_anggaran).val('Auto generate dari Account')

                    $(subpos).val("-1")
                    $(m_anggaran).val("-1")
                  }

                  function populateAccountEtc(data) {
                    var account = data.SEGMEN_1 + '-' + data.SEGMEN_2 + '-' + data.SEGMEN_3 + '-' + data.SEGMEN_4 + '-' +data.SEGMEN_5 + '-' + data.SEGMEN_6
                    $(account_field).val(account)
                    $(subpos).val(data.SEGMEN_5)
                    $(m_anggaran).val(data.SEGMEN_6)

                    $(anggaran_field).val(data.ax_anggaran.PIL_AMOUNTAVAILABLE)
                    var nilai = validDigits($(anggaran_field).val());
                    var val = addCommas(nilai);
                    $(anggaran_field).val(val)

                    $(actual_anggaran).val(data.actual_anggaran)
                    nilai = parseInt($(actual_anggaran).val());
                    val = addCommas(nilai);
                    $(actual_anggaran).val(val)
                  }
                  
                  function pad(n) {
                      return (n < 10) ? ("0" + n) : n;
                  }

                  function generateAccount(item, m_anggaran, subpos) {
                    var kpkcId = {{ Auth::user()->cabang }};
                    var divisiId = {{ Auth::user()->divisi ? Auth::user()->divisi : '00' }};
                    var account = item + '-THT' + '-' + pad(kpkcId) + '-' + pad(divisiId) + '-' + subpos + '-' + m_anggaran;   
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
                    if (totalRows > 0 && is_all_anggaran_safe && is_all_rows_not_rejected && berkas > 0) {
                      $('#xSmall').modal()
                    } else if(!is_all_anggaran_safe) {
                      toastr.error("Anggaran yang bersangkutan tidak mencukupi untuk disubmit. Terima kasih.", "Peringatan Anggaran", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});                      
                    } else if (!is_all_rows_not_rejected) {
                      toastr.error("Untuk melakukan submit kembali, silahkan adakan perbaikan pada batch ini (row berwarna kuning). Terima kasih.", "Perbaikan Diperlukan", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});                      
                    } else {
                      toastr.error("Silahkan input <b>data dan berkas</b> yang hendak disubmit. Terima kasih.", "Data dan berkas tidak boleh kosong", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});                      
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