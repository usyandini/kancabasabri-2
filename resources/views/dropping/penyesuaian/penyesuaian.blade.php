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
                @endsection

                @section('content')
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Penyesuaian Dropping</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('/dropping') }}">Informasi Dropping</a>
                                    </li>
                                    <li class="breadcrumb-item active">Penyesuaian Dropping
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body">
                <!-- Basic scenario start -->
                  <section id ="basic-form-layouts">
                    <div class="row match-height">
                    <div class="row">
                        @if(session('success'))
                        <div class="col-xs-8">
                            <div class="alert alert-success">
                              <b>Informasi penyesuaian dropping berhasil dikirim.</b>
                            </div>
                        </div>
                        @elseif(session('fail'))
                        <div class="col-xs-8">
                            <div class="alert alert-warning">
                              <b>Anda sudah melakukan penyesuaian dropping. Harap menunggu verifikasi Kantor Pusat</b>
                            </div>
                        </div>
                        @elseif(session('verifikasi1'))
                        <div class="col-xs-8">
                            <div class="alert alert-warning">
                              <b>Anda sudah melakukan penyesuaian dropping. Telah diverifikasi oleh <i>Bia</i> dan diteruskan ke <i>Akuntansi</i></b>
                            </div>
                        </div>
                        @elseif(session('verifikasi2'))
                        <div class="col-xs-8">
                            <div class="alert alert-warning">
                              <b>Anda sudah melakukan penyesuaian dropping. Penyesuaian dropping hanya bisa dilakukan sekali.</b>
                            </div>
                        </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="col-xs-7">
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <ul>
                                    @foreach ($errors->all() as $error)
                                        <li><b>{{ $error }}</b></li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                      </div>
                      <div class="col-md-6">
                        <div class="card" style="height: 100px;">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-form">Detail Dropping <b><br>{{ $dropping->CABANG_DROPPING }}</b></h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                              <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                              </ul>
                            </div>
                          </div>
                          <div class="card-body collapse in">
                            <div class="card-block">
                              <div class="card-text">
                              </div>
                              <form class="form" id="informasi-form" method="POST" action="{{ url('dropping/penyesuaian/'.$dropping->RECID) }}" >
                              {{ csrf_field() }}

                                <div class="form-body">
                                  <h4 class="form-section"> Informasi Dropping</h4>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="tgl_dropping">Tanggal Dropping</label>
                                        <input type="date" readonly="" id="tgl_dropping" class="form-control" placeholder="Tanggal Transaksi" name="tgl_dropping" value="{{ date("Y-m-d",strtotime($dropping->TRANSDATE)) }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="nominal">Nominal Dropping (Dalam IDR)</label>
                                          <input type="text" readonly="" id="nominal_dropping" class="form-control" placeholder="{{ $dropping->DEBIT }}" name="nominal" value="{{ number_format($dropping->DEBIT) }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                      <div class="form-group">
                                        <label for="rek_bank">Nomor Rekening</label>
                                        <input type="text" readonly="" id="rek_bank" class="form-control" placeholder="Rekening Bank" name="rek_bank" value="{{ $dropping->REKENING_DROPPING }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="akun_bank">Nama Bank</label>
                                        <input type="text" readonly="" id="akun_bank" class="form-control" placeholder="Nama Bank" name="akun_bank" value="{{ $dropping->BANK_DROPPING }}">
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label for="cabang">Kantor Cabang</label>
                                        <input type="text" readonly="" id="cabang" class="form-control" placeholder="Kantor Cabang" name="cabang" value="{{ $dropping->CABANG_DROPPING }}">
                                      </div>
                                    </div>
                                    {{--<div class="col-md-12">
                                      <div class="form-group">
                                        <label for="is_sesuai">Apakah jumlah dropping sudah sesuai dengan pengajuan?</label><br>
                                        <input type="checkbox" onchange="change_checkbox(this)" class="form-control switch" id="switch1" checked="checked" name="is_sesuai" value="1" data-on-label="Sesuai" data-off-label="Tidak Sesuai"/>
                                      </div>
                                    </div>--}}
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="card" id="kesesuaian" style="height: 1800px;">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control">Form Penyesuaian Dropping</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                              <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                              </ul>
                            </div>
                          </div>
                          <div class="card-body collapse in">
                            <div class="card-block">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="alert alert-warning mb-2" role="alert" id="alert-dropping" style="display: block;">
                                    <strong>Perhatian!</strong> Jika dropping tidak sesuai, silahkan melengkapi form <b>pengembalian kelebihan dropping</b> atau <b>penambahan kekurangan dropping</b>.
                                  </div>
                                </div>
                              </div>
                              <form class="form" method="POST" id="kesesuaian-form" action="{{ url('dropping/penyesuaian/'.$dropping->RECID) }}" enctype="multipart/form-data">
                              {{ csrf_field() }}
                                <input type="hidden" name="nominal_dropping" value="{{ $dropping->DEBIT }}">
                                
                                <div class="form-body">
                                  <h4 class="form-section"> Penyesuaian Dropping</h4>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group mt-1 pb-1">
                                        <label for="switcherySize11" class="font-medium-2 text-bold-600 mr-1">Pengembalian kelebihan</label>
                                        <input type="checkbox" onchange="change_title(this)" id="switcherySize11" class="switchery" checked="checked" name="p_is_pengembalian" value="1" />
                                        <label for="switcherySize11" class="font-medium-2 text-bold-600 ml-1">Penambahan kekurangan</label>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div id="judul_kesesuaian">
                                        <h4 class="form-section"> Informasi Penambahan</h4>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="projectinput1">Tanggal Transaksi</label>
                                        <input readonly="" type="date" id="p_tgl_dropping" class="form-control" placeholder="{{ date('d/m/Y') }}" name="p_tgl_dropping" value="{{ date('Y-m-d') }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="projectinput2">Nominal Transaksi (Dalam IDR)</label>
                                        <span class="required"> *</span>
                                        <div class="controls">
                                          <input type="text" id="p_nominal" name="p_nominal" class="form-control" value="{{ old('p_nominal') }}" required>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <h4 class="form-section"> Informasi Bank</h4>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label for="p_cabang">Kantor Cabang</label>
                                        <span class="required"> *</span>
                                        <div class="controls">
                                          <select class="form-control kcabang" id="cabang" name="p_cabang" required>
                                              <option value="0">--Pilih Kantor Cabang</option>
                                            @foreach($kcabangs as $cabang)
                                              <option value="{{ $cabang->DESCRIPTION }}">{{ $cabang->DESCRIPTION }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="p_akun_bank">Nama Bank</label>
                                        <span class="required"> *</span>
                                        <div class="controls">
                                          <select class="form-control akun_bank" id="akun_bank" name="p_akun_bank" disabled="" required>
                                              <option value="0">Pilih kantor cabang terlebih dahulu</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="p_rek_bank">Nomor Rekening</label>
                                        <span class="required"> *</span>
                                        <div class="controls">
                                          <select class="form-control rekening" name="p_rek_bank" disabled="" required>
                                            <option>Pilih bank terlebih dahulu</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label for="berkas">Upload berkas penyesuaian dropping</label>
                                        <span class="required"> *</span>
                                        <div class="controls">
                                          <input type="file" class="form-control-file" id="berkas" name="berkas[]" multiple="" required>

                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row match-height">
                      <div class="col-md-12">
                        <div class="card" id="history">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"><b>History Kesesuaian dropping</b></h4>
                            {{--<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                              <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                              </ul>
                            </div>--}}
                            <div class="card-body">
                              <div class="card-block">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <div class="table-responsive">
                                        <table class="table">
                                          <thead>
                                            <tr>
                                              <th>Tanggal</th>
                                              <th>Kantor Cabang</th>
                                              <th>Nominal Penyesuaian</th>
                                              <th>Status</th>
                                              <th>Attachment</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              @if(isset($kesesuaian))
                                                <td><b>{{ date('d-m-Y H:i:s', strtotime($kesesuaian->created_at)) }}</b></td>
                                                <td>{{ $kesesuaian->cabang }}</td>
                                                <td>IDR {{ number_format($kesesuaian->nominal) }}</td>
                                                @if($kesesuaian->is_pengembalian == 1)
                                                <td>Pengembalian</td>
                                                @else
                                                <td>Penambahan</td>
                                                @endif

                                                <td>
                                                @foreach($berkas as $value)
                                                <li><a href="{{ url('dropping/penyesuaian/berkas/download').'/'.$value->id }}" target="_blank">{{ $value->name }}</a></li>
                                                @endforeach
                                                </td>

                                              @endif
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row match-height">
                      <div class="col-md-12">
                        <div class="card">
                        {{-- <div class="card-header"></div> --}}
                          <div class="card-body collapse in">
                            <div class="card-block">
                              <div class="form-actions">
                                <a href="{{ url('dropping') }}" class="btn btn-warning mr-1">
                                  <i class="ft-x"></i> Keluar
                                </a>
                                <button type="submit" data-toggle="modal" data-target="#xSmall" class="btn btn-primary">
                                  <i class="fa fa-check-square-o"></i> Submit
                                </button>
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
                                      <p>Apakah anda yakin dengan <b>data penambahan dropping</b> yang anda input sudah benar?</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Tidak, kembali</button>
                                      <button type="submit" id="post" onclick="forms_submit()" class="btn btn-outline-primary">Ya, kirim</button>
                                    </div>
                                  </div>
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
                <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js') }}"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/toggle/switchery.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/forms/switch.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/forms/validation/form-validation.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/modal/components-modal.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/extensions/toastr.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE LEVEL JS-->  

                <script type="text/javascript">
                  /*function change_checkbox(el) {
                    if(el.checked) {
                      document.getElementById("kesesuaian").style.display = 'none';
                      document.getElementById("confirmation-msg").innerHTML = '<p>Apakah anda yakin untuk menyimpan <b>data tarik tunai dropping</b> yang anda input sudah sesuai?</p>';
                    } else {
                      document.getElementById("kesesuaian").style.display = 'block';
                      document.getElementById("confirmation-msg").innerHTML = '<p>Apakah anda yakin untuk menyimpan <b>data ketidaksesuaian dropping</b> yang telah anda input?</p>';
                    }
                  };*/


                  function addCommas(n){
                      var rx=  /(\d+)(\d{3})/;
                      return String(n).replace(/^\d+/, function(w){
                          while(rx.test(w)){
                              w= w.replace(rx, '$1,$2');
                          }
                          return w;
                      });
                  }
                  // return integers and decimal numbers from input
                  // optionally truncates decimals- does not 'round' input
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
                  window.onload= function(){
                      var n2= document.getElementById('p_nominal');
                      n2.value='';

                      n2.onkeyup=n2.onchange= function(e){
                          e=e|| window.event; 
                          var who=e.target || e.srcElement,temp;
                          if(who.id==='nominal_tarik')  temp= validDigits(who.value); 
                          else temp= validDigits(who.value);
                          who.value= addCommas(temp);
                      }   
                      n2.onblur = function(){
                          var temp2=parseFloat(validDigits(n2.value));
                          if(temp2)n2.value=addCommas(temp2.toFixed());
                      }
                  }


                  function change_title(t){
                    if(t.checked){
                      document.getElementById("kesesuaian-form").style.display = 'inline';
                      document.getElementById("judul_kesesuaian").innerHTML = '<h4 class="form-section"> Informasi Penambahan</h4>';
                      document.getElementById("confirmation-msg").innerHTML = '<p>Apakah anda yakin dengan <b>data penambahan dropping</b> yang anda input sudah benar?</p>';
                    } else {
                      document.getElementById("kesesuaian-form").style.display = 'block';
                      document.getElementById("judul_kesesuaian").innerHTML = '<h4 class="form-section"> Informasi Pengembalian</h4>';
                      document.getElementById("confirmation-msg").innerHTML = '<p>Apakah anda yakin dengan <b>data pengembalian dropping</b> yang anda input sudah benar?</p>';
                    }
                  };

                  function forms_submit() {
                    document.getElementById("kesesuaian-form").submit();
                  };

                  $('select.kcabang').on('change', function(){
                      $.post('{{ url('/dropping/banks') }}', {_token: '{{ csrf_token() }}', type: 'bank', id: $(this).val()}, function(e){
                        console.log(e);
                          if (e != 0) {
                            $('select[name="p_akun_bank"]').html(e);
                            $('select[name="p_akun_bank"]').prop("disabled", false);
                          } else {
                            $('select[name="p_akun_bank"]').html("<option value='0'>Pilih kantor cabang terlebih dahulu</option>");
                            $('select[name="p_akun_bank"]').prop("disabled", true);
                            toastr.error("Daftar bank pada kantor cabang yang dimaksud tidak ditemukan. Silahkan pilih kantor cabang lain. Terima kasih.", "Perhatian", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                          }

                          $('select[name="p_rek_bank"]').html("<option value='0'>Pilih bank terlebih dahulu</option>");
                          $('select[name="p_rek_bank"]').prop("disabled", true);
                      });
                  });

                  $('select.akun_bank').on('change', function(){
                      $.post('{{ url('/dropping/banks') }}', {_token: '{{ csrf_token() }}', type: 'rekening', id: $(this).val()}, function(e){
                        console.log(e);
                          if (e != 0) {
                            $('select[name="p_rek_bank"]').html(e);
                            $('select[name="p_rek_bank"]').prop("disabled", false);
                          } else {
                            $('select[name="p_rek_bank"]').html("<option value='0'>Pilih bank terlebih dahulu</option>");
                            $('select[name="p_rek_bank"]').prop("disabled", true);
                            toastr.error("Daftar rekening pada bank yang dimaksud tidak ditemukan. Silahkan pilih bank lain. Terima kasih.", "Perhatian", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
                          }
                      });
                  });
                </script>
                @endsection