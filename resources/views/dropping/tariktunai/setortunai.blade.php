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
                <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                <script>
                $( function() {
                  $( "#tgl_setor" ).datepicker();
                } );
                </script>
                @endsection

                @section('content')
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Setor Tunai</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dropping</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('/dropping') }}">Informasi Dropping</a>
                                    </li>
                                    <li class="breadcrumb-item active">Setor Tunai
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
                              <b>Data setor tunai berhasil dikirim.</b>
                            </div>
                        </div>
                        @elseif(session('offset'))
                        <div class="col-xs-7">
                            <div class="alert alert-warning">
                              <b>Data setor tunai gagal dikirim. Nominal setor tunai melebihi dana dropping.</b>
                            </div>
                        </div>
                        @elseif(session('confirm'))
                        <div class="col-xs-7">
                            <div class="alert alert-warning">
                              <b>Anda sudah melakukan konfirmasi setor Tunai, harap menunggu verifikasi dari Kantor Pusat.</b>
                            </div>
                        </div>
                        @elseif(session('reject1'))
                        <div class="col-xs-8">
                          <div class="alert alert-warning">
                            <b>setor tunai anda ditolak dengan alasan {{ $notif->reason['content'] }}.<br>Silahkan melakukan <i>setor tunai</i> kembali.</b>
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
                            <h4 class="card-title" id="basic-layout-form">Detail Setor Tunai <b><br>{{ $dropping->CABANG_DROPPING }}</b></h4>
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
                              <form class="form" id="setortunai-form" method="POST" action="{{ url('dropping/setortunai/'.$dropping->RECID) }}" enctype="multipart/form-data">
                              {{ csrf_field() }}
                                <input type="hidden" name="sisa_dropping" value="{{ $dropping->tarikTunai['sisa_dropping'] }}">

                                <div class="form-body">
                                  <h4 class="form-section"> Informasi Dropping</h4>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="tgl_dropping">Tanggal Dropping</label>
                                        <input type="text" readonly="" id="tgl_dropping" class="form-control" placeholder="Tanggal Transaksi" name="tgl_dropping" value="{{ date("d-m-Y",strtotime($dropping->TRANSDATE)) }}">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="nominal">Nominal Dropping</label>

                                          <input type="text" readonly="" class="form-control" placeholder="{{ $dropping->DEBIT }}" name="nominal_dropping" value="Rp. {{ number_format($dropping->DEBIT, 0, '','.') }}">

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
                                  @can('masuk_st_d')
                                  <h4 class="form-section">Setor Tunai</h4>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="tgl_setor">Tanggal Setor Tunai</label>
                                        <!-- sementara ini -->
                                        <input id="tgl_setor" class="form-control" name="tgl_setor" required>
                                        <!-- nanti diganti ini -->
                                        <!-- <input type="text" readonly="" id="tgl_setor" class="form-control" placeholder="Tanggal Setor Tunai" name="tgl_setor" value="{{ date('d-m-Y') }}"> -->
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="nominal_setor">Nominal Setor Tunai</label>
                                        <div class="controls">
                                          <input type="text" id="nominal_setor" name="nominal_setor" class="form-control" value="Rp. {{ old('nominal_setor') }}" required>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="berkas">Unggah berkas setor tunai</label>
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
                            <h4 class="card-title" id="basic-layout-colored-form-control">Riwayat Setor dan Tarik Tunai</h4>
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
                                        <table class="table table-striped table-bordered datatable-select-inputs mb-0">
                                          <thead>
                                            <tr>
                                              <th>&nbsp;&nbsp;&nbsp;Tanggal&nbsp;&nbsp;&nbsp;</th>
                                              <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saldo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                              <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nominal Tarik&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                              <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nominal Setor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                              <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sisa Dropping&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                              <th>Attachment</th>
                                              <th>Status Ax</th>
                                            </tr>
                                          </thead>
                                          @foreach($tariktunai as $history)
                                          <tbody>
                                            <tr>
                                              <td>{{ date('d-m-Y H:i:s', strtotime($history->created_at)) }}</td>
                                              <td align=right>Rp. {{ number_format($history->nominal, 0, '','.') }}</td>
                                              
                                              <td align=right>@if($history->stat==3) Rp. {{ number_format($history->nominal_tarik, 0, '','.') }}@endif</td>
                                              <td align=right>@if($history->stat==11) Rp. {{ number_format($history->nominal_tarik, 0, '','.') }}@endif</td>
                                              <td align=right>Rp. {{ number_format($history->sisa_dropping, 0, '','.') }}</td>
                                              <td>
                                                @foreach($berkas->where('id_tariktunai', $history->id)->get() as $value)
                                                  <li><a href="{{ url('dropping/tariktunai/berkas/download').'/'.$value['id'] }}" target="_blank">{{ $value['name'] }}</a></li>
                                                @endforeach
                                              </td>
                                              <td>
                                                @if($history->integratedsetor['PIL_POSTED'] == 1)
                                                  Terintegrasi
                                                @elseif($history->integrated['PIL_POSTED'] == 1)
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
                    @can('masuk_tt_d')
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
                                      <p>Apakah anda yakin dengan <b>data setor tunai dropping</b> yang anda input sudah sesuai?</p>
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
                  // function forms_submit() {
                  //     var num = document.getElementById('nominal_setor').value;
                  //     //var val = parseFloat(num.replace(/./g, ''));
                  //     var val = parseFloat(validDigits(num));
                  //     var mod = val%100

                  //     if(mod != 0 || val < 100){
                  //       alert("Nominal tidak valid! Silahkan input nominal kembali.\nMinimal input nominal Rp. 100 dengan kelipatan 100.");
                  //     }else{
                  //       document.getElementById("setortunai-form").submit();
                  //     }
                  // };

                  function forms_submit() {
                    document.getElementById("setortunai-form").submit();
                    
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
                      var n2= document.getElementById('nominal_setor');
                      n2.value='';

                      n2.onkeyup=n2.onchange= function(e){
                          e=e|| window.event; 
                          var who=e.target || e.srcElement,temp;
                          if(who.id==='nominal_setor')  temp= validDigits(who.value); 
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