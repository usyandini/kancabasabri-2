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
            		<h3 class="content-header-title mb-0">Reject History Transaksi</h3>
            		
            	</div>
            </div>

            <div class="row">
            	<section id="select-inputs">
            		<div class="row">
            			<div class="col-xs-12">
            				<div class="card">
            					<div class="card-header">
            						<h4 class="card-title">Daftar Reject History Transaksi</h4>
            						<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            					</div>
            					
            						<div class="card-body collapse in">			                
            							<div class="card-block">
            								<div class="table-responsive">
            									<table class="table table-striped table-bordered datatable-select-inputs nowrap" cellspacing="0" width="100%">
            										<thead>
            											<tr>
            												<th><center>No</center></th>
                                                            <th id="filterable"><center>Ditolak Oleh</center></th>
                                                            <th id="filterable"><center>Verifikasi Level</center></th>
                                                            <th id="filterable"><center>Alasan</center></th>
                                                            <th id="filterable"><center>Dibuat Oleh</center></th>
                                                            <th id="filterable"><center>Cabang</center></th>
                                                            <th id="filterable"><center>No Batch</center></th>
            											</tr>
            										</thead>
            										<tbody>
            											<?php $no='1';?>
            											@if(count($a))
            											@foreach($a as $b)
                                                        <?php
                                                         $rejectreason=$b->reject_reason;
                                                         $cabang=$b->cabang;
                                                         $submitted=$b->submitted_by;
                                                         $created=$b->created_by;
                                                         $z = \DB::select("SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_KPKC]  WHERE VALUE!='00'");
                                                         $z2 = \DB::select("SELECT id, username FROM [DBCabang].[dbo].[users]");
                                                         $z3 = \DB::select("SELECT id, content FROM [DBCabang].[dbo].[reject_reasons]");

                                                         ?>
            											<tr>
            												<td><center>{{ $no }}</center></td>
                                                            <td>@foreach($z2 as $x2)
                                                             @if($submitted==$x2->id)
                                                             {{ $x2->username }}
                                                             @endif
                                                             @endforeach</td>
                                                            <td><center>
                                                            @if($b->stat==3) level 1 
                                                            @elseif($b->stat==5) level 2 
                                                            @endif
                                                            </center></td>
                                                            <td>@foreach($z3 as $x3)
                                                             @if($rejectreason==$x3->id)
                                                             {{ $x3->content }}
                                                             @endif
                                                             @endforeach</td>
                                                            <td>@foreach($z2 as $x2)
                                                             @if($created==$x2->id)
                                                             {{ $x2->username }}
                                                             @endif
                                                             @endforeach</td>
            												<td>@foreach($z as $x)
                                                             @if($cabang==$x->VALUE)
                                                             {{ $x->DESCRIPTION }}
                                                             @endif
                                                             @endforeach</td>
                                                            <td><center>{{date("ymd", strtotime($b->tanggal))}}-{{$b->cabang}}/{{$b->divisi}}-{{$b->seq_number}}</center></td>
                                                             
            											</tr>
            											
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