                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css') }}">
                <style type="text/css">
                .hide {
                	display: none;
                }
            </style>
            @endsection

            @section('content')
            <div class="content-header row">
            	<div class="content-header-left col-md-6 col-xs-12 mb-2">
            		<h3 class="content-header-title mb-0">Verifikasi Transaksi Level 1</h3>
            		
            	</div>
            </div>

            <div class="row">
              <section id="select-inputs">
                <div class="row">
                  <div class="col-xs-12">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Pencarian Pengajuan Dropping</h4>
                        <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                      </div>
                      <div class="card-body collapse in">
                        <div class="card-block">
                          <form enctype="multipart/form-data" role="form" action="{{ URL('transaksi/lihat/persetujuan/hasil') }}" method="POST" >
                            <div class="row">
                              {{ csrf_field() }}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label>Kantor Cabang</label><br>
                                  <select class="select2 form-control block" name="cabang" style="width:100%" required="required">
                                    <option value="" disabled="" selected=""> - Pilih Kantor Cabang - </option>
                                    <?php
                                    $second="SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_KPKC]  WHERE VALUE!='00'";
                                    $return = DB::select($second);
                                    ?>
                                    @foreach ($return as $cabang)
                                    <option value="{{ $cabang->VALUE }}" >{{ $cabang->DESCRIPTION }}</option>                                         
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label>Periode Awal</label><br>
                                  <select class="select2 form-control block" name="awal" style="width:100%" required="required">
                                    <option value="" disabled="" selected=""> - Pilih Periode Awal - </option>
                                    <option value="01"> Januari </option>
                                    <option value="02"> Februari </option>
                                    <option value="03"> Maret </option>
                                    <option value="04"> April </option>
                                    <option value="05"> Mei </option>
                                    <option value="06"> Juni </option>
                                    <option value="07"> Juli </option>
                                    <option value="08"> Agustus </option>
                                    <option value="09"> September </option>
                                    <option value="10"> Oktober </option>
                                    <option value="11"> November </option>
                                    <option value="12"> Desember </option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label>Periode Akhir</label><br>
                                  <select class="select2 form-control block" name="akhir" style="width:100%" required="required">
                                    <option value="" disabled="" selected=""> - Pilih Periode Akhir - </option>
                                    <option value="01"> Januari </option>
                                    <option value="02"> Februari </option>
                                    <option value="03"> Maret </option>
                                    <option value="04"> April </option>
                                    <option value="05"> Mei </option>
                                    <option value="06"> Juni </option>
                                    <option value="07"> Juli </option>
                                    <option value="08"> Agustus </option>
                                    <option value="09"> September </option>
                                    <option value="10"> Oktober </option>
                                    <option value="11"> November </option>
                                    <option value="12"> Desember </option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label>Tahun</label><br>
                                  <select class="select2 form-control" name="tahun" style="width:100%" required>
                                  <option selected disabled>Pilih Tahun</option>
                                  <?php
                                  $thn_skr = date('Y');
                                  for($x=$thn_skr; $x >= 2015; $x--){
                                    ?>
                                    <option value="{{$x}}">{{$x}}</option>
                                    <?php }?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-7">
                                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-search "></i> Cari</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>                  
                  </div>
                </div>
              </div>
            @if($a)
            <div class="row">
            	<section id="select-inputs">
            		<div class="row">
            			<div class="col-xs-12">
            				<div class="card">
            					<div class="card-header">
            						<h4 class="card-title">Daftar Verifikasi Transaksi Level 1</h4>
            						<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            					</div>
            					
            						<div class="card-body collapse in">			                
            							<div class="card-block">
            								<div class="table-responsive">
            									<table class="table table-striped table-bordered datatable-select-inputs nowrap" cellspacing="0" width="100%">
            										<thead>
                                                          <tr>
                                                                <th width="5%"><center>No</center></th>
                                                                <th id="filterable"><center>Cabang</center></th>
                                                                <th id="filterable"><center>No Batch</center></th>
                                                                <th id="filterable"><center>Status</center></th>
                                                                <th width="10%"><center>Aksi</center></th>
                                                          </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                              <?php $no='1';?>
                                                                              @if(count($a))
                                                                              @foreach($a as $b)
                                                                              <?php

                                                                                  $cabang=$b->cabang;
                                                                                  $z = \DB::select("SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_KPKC]  WHERE VALUE!='00'");
                                                                                  $c = \DB::table('batches_status')->where('batch_id', $b->batch_id)->where('stat', 4)->first();
                                                                                  $d = \DB::table('batches_status')->where('batch_id', $b->batch_id)->orderBy('id', 'desc')->first();
                                                                                  
                                                                              ?>
                                                                              @if(Gate::check('unit_'.$cabang."00"))
                                                                              <tr>
                                                                                    <td><center>{{ $no }}</center></td>
                                                                                    <td><center>@foreach($z as $x)
                                                                                          @if($cabang==$x->VALUE)
                                                                                          {{ $x->DESCRIPTION }}
                                                                                          @endif
                                                                                        @endforeach</center></td>
                                                                                    <td><center>{{date("ymd", strtotime($b->tanggal))}}-{{$b->cabang}}/{{$b->divisi}}-{{$b->seq_number}}</center></td>
                                                                                    <td><center>
                                                                                          @if($c)
                                                                                            @if($d->stat==2)
                                                                                            <span class="tag tag-warning">Belum diverifikasi</span>
                                                                                            @else
                                                                                            <span class="tag tag-success">Telah diverifikasi</span>
                                                                                            @endif
                                                                                          @else
                                                                                            @if($d->stat==3)
                                                                                              <span class="tag tag-danger">Telah ditolak</span>
                                                                                            @else
                                                                                              <span class="tag tag-warning">Belum diverifikasi</span>
                                                                                            @endif
                                                                                          @endif
                                                                                    </center></td>
                                                                                    <td><center>
                                                                                          <a href="{{ URL('transaksi/persetujuan/'. $b->batch_id) }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> Lihat</a>
                                                                                          
                                                                                    </center></td>
                                                                              </tr>
            											                      @endif
            											<?php $no++;?>
            											@endforeach
            											@endif
            										</tbody>
            									</table>

            								</div>
            							</div>
            						</div>
            					</div>
            				</div>
            			</div>
            		</section>
            	</div>
                @endif
            </div>
            @endsection

            @section('customjs')
            <!-- BEGIN PAGE VENDOR JS-->
            <script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
            <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
            <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}" type="text/javascript"></script>
            <!-- END PAGE VENDOR JS-->
            <!-- BEGIN PAGE LEVEL JS-->
            <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script> 
            <script src="{{ asset('app-assets/vendors/js/tables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"
            type="text/javascript"></script>
            <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"
            type="text/javascript"></script>
            <script type="text/javascript">


            	$('.datatable-select-inputs').DataTable( {
            		scrollX: true,
            		"language": {
            			"paginate": {
            				"previous": "Sebelumnya",
            				"next": "Selanjutnya"
            			},

            			"emptyTable":  "Tidak Ada Data Tersimpan",
            			"info":  "Menampilkan _START_-_END_ dari _TOTAL_ Data",
            			"infoEmpty":  "Menampilkan 0-0 dari _TOTAL_ Data ",
            			"search": "Pencarian:",
            			"lengthMenu": "Perlihatkan _MENU_ masukan",
            			"infoFiltered": "(telah di filter dari _MAX_ total masukan)",
            			"zeroRecords": "Tidak ada data ditemukan"
            		},
            		initComplete: function () {
            			this.api().columns('#filterable').every( function () {
            				var column = this;
            				var select = $('<select><option value="">Filter kolom</option></select>')
            				.appendTo( $(column.footer()).empty() )
            				.on( 'change', function () {
            					var val = $.fn.dataTable.util.escapeRegex(
            						$(this).val()
            						);

            					column
            					.search( val ? '^'+val+'$' : '', true, false )
            					.draw();
            				} );

            				column.data().unique().sort().each( function ( d, j ) {
            					select.append( '<option value="'+d+'">'+d+'</option>' );
            				} );
            			} );
            		}
            	} );

            </script>

            @endsection