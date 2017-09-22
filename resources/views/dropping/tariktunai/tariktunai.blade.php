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
                        <h3 class="content-header-title mb-0">Tarik Tunai</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('/dropping') }}">Informasi Dropping</a>
                                    </li>
                                    <li class="breadcrumb-item active">Tarik Tunai
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
                        <div class="col-xs-7">
                            <div class="alert alert-success">
                              <b>Data tarik tunai berhasil dikirim.</b>
                            </div>
                        </div>
                        @elseif(session('offset'))
                        <div class="col-xs-7">
                            <div class="alert alert-warning">
                              <b>Data tarik tunai gagal dikirim. Nominal tarik tunai melebihi dana dropping.</b>
                            </div>
                        </div>
                        @elseif(session('confirm'))
                        <div class="col-xs-7">
                            <div class="alert alert-warning">
                              <b>Anda sudah melakukan konfirmasi Tarik Tunai, harap menunggu verifikasi dari Kantor Pusat.</b>
                            </div>
                        </div>
                        @elseif(session('reject1'))
                        <div class="col-xs-8">
                          <div class="alert alert-warning">
                            <b>Tarik tunai anda ditolak oleh Akuntansi dengan alasan {{ $notif->reason['content'] }}.<br>Silahkan melakukan <i>tarik tunai</i> kembali.</b>
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
                            <h4 class="card-title" id="basic-layout-form">Detail Tarik Tunai <b><br>{{ $dropping->CABANG_DROPPING }}</b></h4>
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
                              <form class="form" id="tariktunai-form" method="POST" action="{{ url('dropping/tariktunai/'.$dropping->RECID) }}" enctype="multipart/form-data">
                              {{ csrf_field() }}
                                <input type="hidden" name="sisa_dropping" value="{{ $dropping->tarikTunai['sisa_dropping'] }}">

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

                                          <input type="text" readonly="" class="form-control" placeholder="{{ $dropping->DEBIT }}" name="nominal_dropping" value="{{ number_format($dropping->DEBIT, 0, '','.') }}">

                                          <input type="hidden" id="nominal" name="nominal" value="{{ $dropping->DEBIT }}">
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
                                  </div>
                                  @can('insertTT_d')
                                  <h4 class="form-section">Tarik Tunai</h4>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="tgl_tarik">Tanggal Tarik Tunai</label>
                                        <input type="date" readonly="" id="tgl_tarik" class="form-control" placeholder="Tanggal Tarik Tunai" name="tgl_tarik" value="{{ date("Y-m-d") }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="nominal_tarik">Nominal Tarik Tunai(Dalam IDR)</label>
                                        <span class="required"> *</span>
                                        <div class="controls">
                                          <input type="text" id="nominal_tarik" name="nominal_tarik" class="form-control" value="{{ old('nominal_tarik') }}" required>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="berkas">Unggah berkas tarik tunai</label>
                                      <span class="required"> *</span>
                                      <div class="controls">
                                        <input type="file" class="form-control-file" id="berkasInput" name="berkas[]" multiple="" required>
                                      </div>
                                    </div>
                                  </div>
                                  @endcan
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="card" id="history" style="height: 1800px;display: block;">
                          <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control">History Tarik Tunai</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                              <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                              </ul>
                            </div>
                          </div>
                          <div class="card-body collapse in">
                            <div class="card-block">
                              <div class="form-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <div class="table-responsive">
                                        <table class="table">
                                          <thead>
                                            <tr>
                                              <th>Tanggal</th>
                                              <th>Saldo</th>
                                              <th>Nominal Tarik</th>
                                              <th>Sisa Dropping</th>
                                              <th>Attachment</th>
                                              <th>Status Ax</th>
                                            </tr>
                                          </thead>
                                          @foreach($tariktunai as $history)
                                          <tbody>
                                            <tr>
                                              <th>{{ date('d-m-Y H:i:s', strtotime($history->created_at)) }}</th>

                                              <td>IDR {{ number_format($history->nominal, 0, '','.') }}</td>
                                              <td>IDR {{ number_format($history->nominal_tarik, 0, '','.') }}</td>
                                              <td>IDR {{ number_format($history->sisa_dropping, 0, '','.') }}</td>
                                              <td>
                                                @foreach($berkas->where('id_tariktunai', $history->id)->get() as $value)
                                                  <li><a href="{{ url('dropping/tariktunai/berkas/download').'/'.$value['id'] }}" target="_blank">{{ $value['name'] }}</a></li>
                                                @endforeach
                                              </td>
                                              <td>
                                                @if($history->integrated['PIL_POSTED'] == 1)
                                                  Terintegrasi
                                                @else
                                                  -
                                                @endif
                                              </td>
                                            </tr>
                                          </tbody>
                                          @endforeach
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
                    @can('insertTT_d')
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
                                      <p>Apakah anda yakin dengan <b>data tarik tunai dropping</b> yang anda input sudah sesuai?</p>
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
                    @endcan
                  </section>

                <!-- Basic scenario end -->
                </div>
                @endsection

                @section('customjs')
                <!-- BEGIN PAGE VENDOR JS-->
                <script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
                {{-- <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js') }}"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/toggle/switchery.min.js') }}" type="text/javascript"></script> --}}
                <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
                {{-- <script src="{{ asset('app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script> --}}
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
                {{-- <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/forms/switch.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/forms/validation/form-validation.js') }}" type="text/javascript"></script> --}}
                <script src="{{ asset('app-assets/js/scripts/modal/components-modal.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/js/scripts/extensions/toastr.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE LEVEL JS-->  

                <script type="text/javascript">
                  function forms_submit() {
                      var num = document.getElementById('nominal_tarik').value;
                      //var val = parseFloat(num.replace(/./g, ''));
                      var val = parseFloat(validDigits(num));
                      var mod = val%100

                      if(mod != 0 || val < 100){
                        alert("Nominal tidak valid! Silahkan input nominal kembali.\nMinimal input nominal IDR 100 dengan kelipatan 100.");
                      }else{
                        document.getElementById("tariktunai-form").submit();
                      }
                  };

                  // insert commas as thousands separators 
                  function addCommas(n){
                      var rx=  /(\d+)(\d{3})/;
                      return String(n).replace(/^\d+/, function(w){
                          while(rx.test(w)){
                              w= w.replace(rx, '$1.$2');
                          }
                          return w;
                      });
                  }
                  // return integers and decimal numbers from input
                  // optionally truncates decimals- does not 'round' input
                  function validDigits(n, dec){
                      //n= n.replace(/[^\d\.]+/g, '');
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
                      var n2= document.getElementById('nominal_tarik');
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
                </script>
                @endsection