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
            		<h3 class="content-header-title mb-0">Manajemen Item Transaksi</h3>
            		<div class="row breadcrumbs-top">
            			<div class="breadcrumb-wrapper col-xs-12">
            				<ol class="breadcrumb">
            					<li class="breadcrumb-item active">Manajemen Item
            					</li>
            				</ol>
            			</div>
            		</div>
            	</div>
            </div>
            <div class="content-body">
            	<div class="row">
            		<section id="select-inputs">
            			<div class="row">
            				<div class="col-xs-12">
            					<div class="card">
            						<div class="card-header">
            							<h4 class="card-title">Daftar Item Transaksi</h4>
            							<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            							<div class="row mt-1">
            								<div class="col-md-12 col-xl-3">
            									<a href="{{ url('item/create') }}" class="btn btn-success btn-sm pull-left"><i class="fa fa-plus"></i> Tambah Item Baru</a>
            								</div>
            							</div>
            						</div>
            						<div class="card-body collapse in">			                
            							<div class="card-block">
            								@if(session('deleted'))
            								<div class="col-xs-6">
            									<div class="alert alert-success">
            										<b>{!! session('deleted') !!}</b>
            									</div>
            								</div>
            								@endif
            								<name="data" id="data">
            								<div class="table-responsive">
            									<table class="table table-striped table-bordered datatable-select-inputs wrap" cellspacing="0" width="100%">
            										<thead>
            											<tr>
            												<th id="filterable"><center>Kode Item</center></th>
            												<th width="300px" id="filterable">Item</th>
            												<th width="300px">Account</th>
            												<th width="200px">Display</th>
            												<th width="30%"><center>Aksi</center></th>
            											</tr>
            										</thead>
            										<tbody>
            											@foreach($items as $item)
            											<tr>
            												<td>{{ $item->kode_item }}</td>
            												<td>{{ $item->nama_item }}</td>
            												<td>{{ $item->SEGMEN_1.'-'.$item->SEGMEN_2.'-'.$item->SEGMEN_3.'-'.$item->SEGMEN_4.'-'.$item->SEGMEN_5.'-'.$item->SEGMEN_6 }}</td>
            												{!! $item->is_displayed ? '<td class="blue">Semua Cabang</td>' : '<td class="red">Cabang Bersangkutan</td>' !!}
            												<td><center>
            													<a href="{{ url('item/edit').'/'.$item->id }}" class="btn btn-outline-info btn-sm">
            														<i class="fa fa-edit"></i> Edit</a>

            														<a href="#" class="btn btn-danger btn-sm" onclick="deleteUser({{ $item->id }})">
            															<i class="fa fa-times"></i> Hapus</a>
            														</center></td>
            													</tr>
            													@endforeach
            												</tbody>
            											</table>
            											<form method="GET" action="#" id="deleteU">
            												{{ csrf_field() }}
            												{{ method_field('DELETE') }}
            											</form>
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

            					"emptyTable":  "Tidak Ada Item Tersimpan",
            					"info":  "Data Item _START_-_END_ dari _TOTAL_ Item",
            					"infoEmpty":  "Data Item 0-0 dari _TOTAL_ Item ",
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
            			});

            			function deleteUser(id) {
            				$('form[id="deleteU"').attr('action', '{{ url('item') }}' + '/delete/master/' + id);
            				var con = confirm("Apakah anda yakin untuk menghapus item ini?");
            				if (con) {
            					$('form[id="deleteU"').submit();	
            				}
            			}
            		</script>
            		@endsection