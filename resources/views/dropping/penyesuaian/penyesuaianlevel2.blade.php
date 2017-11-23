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
            		<h3 class="content-header-title mb-0">Verifikasi Penyesuaian Level 2</h3>
            		
            	</div>
            </div>

            <div class="row">
            	<section id="select-inputs">
            		<div class="row">
            			<div class="col-xs-12">
            				<div class="card">
            					<div class="card-header">
            						<h4 class="card-title">Daftar Penyesuaian Transaksi Level 2</h4>
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
            												<th id="filterable"><center>Tangggal Dropping</center></th>
                                                                                    <th id="filterable"><center>Keterangan</center></th>
                                                                                    <th id="filterable"><center>Jumlah Nominal</center></th>
                                                                                    <th id="filterable"><center>Akun Bank</center></th>
            												<th width="10%"><center>Aksi</center></th>
            											</tr>
            										</thead>
            										<tbody>
            											<?php $no='1';?>
            											@if(count($a))
            											@foreach($a as $b)
            											<tr>
            												<td><center>{{ $no }}</center></td>
                                                                                    <td><center>{{ $b->cabang }}</center></td>
                                                                                    <td><center>{{ date("d-m-Y", strtotime($b->tgl_dropping)) }}</center></td>
                                                                                    <td><center>@if($b->is_pengembalian==1) Pengembalian
                                                                                    @else Penambahan @endif</center></td>
                                                                                    <td><center>Rp {{ number_format($b->nominal,0,"",".") }}</center></td>
                                                                                    <td><center>{{ $b->akun_bank }}</center></td>
            												<td><center>
                                                                                          <a href="{{ URL('/dropping/verifikasi/penyesuaian/final/'. $b->id) }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> Lihat</a>
            													
            												</center></td>
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