                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <style type="text/css">
                .hide {
                  display: none;
                }
                .jsgrid-row .jsgrid-cell, .jsgrid-alt-row .jsgrid-cell {
                  background: inherit;
                }
                .contoh {
                  background: rgb(247, 137, 136);
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
                    @can('cari_t')
                    <div class="col-xs-5">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">Pencarian Transaksi</h4>
                          <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                        </div>
                        <div class="card-body collapse in">
                          <div class="card-block">
                            <form method="POST" action="{{ url('transaksi/filter/process') }}">
                              <div class="row">
                                {{ csrf_field() }}
                                <div class="col-xs-6">
                                  <div class="form-group">
                                    <label>Nomor Batch Lokal</label>
                                    <select class="select2 form-control" name="batch">
                                      <option value="0">Pilih nomor</option>
                                      @foreach($batch_nos as $batch)
                                      <option value="{{ $batch->id }}" {{ $filters[0] == $batch->id ? 'selected=""' : '' }}>{{ $batch->batchNo() }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                {{-- <div class="col-xs-6">
                                  <div class="form-group">
                                    <label>No. Batch</label>
                                    <input class="form-control" type="text" id="batch" name="batch_no"></input>
                                  </div>
                                </div> --}}
                              </div>
                              <div class="row">
                                <div class="col-xs-2">
                                  <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</a>
                                    </div>
                                  </div>
                                  @if($filters)
                                  <div class="col-xs-2">
                                    <div class="form-group">
                                      <a href="{{ url('transaksi') }}" class="btn btn-danger"><i class="fa fa-times"></i> Reset pencarian</a>
                                    </div>
                                  </div>
                                  @endif
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endcan
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
                            @if ($filters)
                            <h4 class="card-title">Hasil Pencarian Transaksi</h4><br>
                            @else
                            <h4 class="card-title">Daftar Transaksi</h4><br>
                            @endif
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="font-small-3">
                              @if ($active_batch)
                              <span>No. Batch: <code>{{ $active_batch->batchNo() }}</code></span>
                              <span>KPKC: <code>{{ $active_batch->kantorCabang()->DESCRIPTION }}</code> <span>Divisi:</span> <code>{{ $active_batch->divisi == '00' ? 'Non-Divisi' : $active_batch->divisi()->DESCRIPTION  }}</code></span>
                              @endif
                            </div>
                          </div>
                          <div class="card-body collapse in ">
                            <div class="card-block card-dashboard ">
                              @include('transaksi.success')
                              <div id="basicScenario"></div><br>
                              <div class="row">
                                <form method="POST" action="{{ url('transaksi/') }}" id="mainForm" enctype="multipart/form-data">
                                  {{ csrf_field() }}
                                  @if ($active_batch)
                                  <input type="hidden" name="batch_id" value="{{ $active_batch->id }}">
                                  @endif
                                  <div class="col-lg-6 col-md-12">
                                    @if($editable && Gate::check('berkas_t'))
                                    <fieldset class="form-group">
                                      <label for="basicInputFile">Unggah berkas</label>
                                      <input type="file" class="form-control-file" id="basicInputFile" multiple="" name="berkas[]">
                                    </fieldset>
                                    @endif
                                    <div class="bs-callout-info callout-border-left callout-bordered callout-transparent mt-1 p-1">
                                      <h4 class="info">Daftar Berkas</h4>
                                      <table>
                                        @forelse($berkas as $value)
                                        <tr>
                                          <td width="25%">Berkas: <a href="{{ url('transaksi/berkas/download').'/'.$value->id }}" target="_blank">{{ $value->file_name }}</a></td>
                                          <td width="25%">Diunggah: <b>{{ $value->created_at }}</b></td>
                                          <td width="5%">
                                            @if($editable && Gate::check('berkas_t'))
                                            <a href="javascript:deleteBerkas('{{ $value->id }}', '{{ $value->file_name }}');"><i class="fa fa-times"></i> Hapus</a>
                                            @endif
                                          </td>
                                        </tr>
                                        @empty
                                        <code>Belum ada berkas terlampir</code>
                                        @endforelse
                                      </table>
                                    </div>
                                  </div>
                                  <input type="hidden" name="batch_values" id="batch_values">
                                </form>
                                <form method="POST" id="deleteBerkas" action="{{ url('transaksi/berkas/remove') }}">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="file_id" value="">
                                  <input type="hidden" name="file_name" value="">
                                </form>
                                <div class="col-lg-6 col-md-12">
                                  <div class="bs-callout-danger callout-border-left callout-bordered mt-1 p-1">
                                    @if (!$empty_batch && $active_batch->latestStat())
                                    <h4>Status Terakhir</h4>
                                    <table>
                                      <tr>
                                        <td width="65%">
                                          <b class="text-danger">{{ $active_batch->latestStat()->status() }}</b><br>
                                          @if (isset($active_batch->latestStat()['rejectReason']))
                                          <span class="font-small-3">{{ $active_batch->latestStat()['rejectReason']['reason']->content }}</span>
                                          @endif
                                        </td>
                                        <td>
                                          <code style="padding: 0;">{{ $active_batch->latestStat()->updated_at }}</code><br>
                                          <span class="font-small-3">Oleh: {{ $active_batch->latestStat()->submitter->name }} / {{ $active_batch->latestStat()->submitter->username }}</span>
                                        </td>
                                      </tr>
                                    </table>
                                    <br>
                                    @endif
                                    <h4>Histori Batch</h4>
                                    <table>
                                      @forelse($batch_history as $hist)
                                      <tr>
                                        <td><b class="text-danger">{{ $hist->status() }}</b> 
                                          @if ($hist['stat'] != "1" && $hist['stat'] != "0")
                                          <code>({{ $hist['total'] }}x)</code>
                                          @endif
                                        </td>
                                        <td>| <code>{{ $hist['tgl'] }}</code></td>
                                      </tr>
                                      @empty
                                      <code>Belum ada Histori batch terbaru.</code>
                                      @endforelse
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-xs-2">
                                  <div class="form-group">
                                    <button class="btn btn-pink" onclick="location.href='{{ url('transaksi/create') }}'"><i class="fa fa-plus"></i> Buat Batch baru</button>
                                  </div>
                                </div>
                                @if($editable)
                                <div class="col-xs-2 pull-right">
                                  <div class="form-group">
                                    <button class="btn btn-info pull-right" id="keep_anggaran" value="Simpan"><i class="fa fa-money"></i> Perbarui Status Anggaran</button>
                                  </div>
                                </div>
                                @if (Gate::check('tambah_item_t') || Gate::check('ubah_item_t') || Gate::check('hapus_item_t'))
                                <div class="col-xs-2 pull-right">
                                  <div class="form-group">
                                    <button onclick="populateBatchInput()" class="btn btn-primary pull-right" id="simpan" value="Simpan"><i class="fa fa-check"></i> Simpan perubahan batch</button>
                                  </div>
                                </div>
                                @endif
                                @if (Gate::check('ajukan_t'))
                                <div class="col-xs-3 pull-right">
                                  <div class="form-group">
                                    <button onclick="checkBatchSubmit()" class="btn btn-danger pull-right" id="button_status"><i class="fa fa-check-circle"></i> Submit batch untuk Verifikasi</button>
                                  </div>
                                </div>
                                @endif
                                @endif
                              </div>
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
                          @if(!$empty_batch && $editable)
                          <li>Batch saat ini : <code>{{ date("d-m-Y", strtotime($active_batch->created_at)) }}</code></li>
                          <li>Terakhir Update : <code>{{ $active_batch->updated_at }}</code> oleh <code>{{ $active_batch['submitter']['name'] }}</code></li>
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
              <!-- END PAGE VENDOR JS-->
              <!-- BEGIN PAGE LEVEL JS-->
              <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
              <!-- END PAGE LEVEL JS-->
              @include('transaksi.js')
              @endsection