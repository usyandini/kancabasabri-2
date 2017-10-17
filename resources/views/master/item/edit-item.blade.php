                @extends('layouts.app')

                @section('additional-vendorcss')
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/jsgrid/jsgrid.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/toastr.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
                <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css') }}">               
                <style type="text/css">
                .hide {
                	display: block;
                }
            </style>
            @endsection

            @section('content')
            <div class="content-header row">
            	<div class="content-header-left col-md-6 col-xs-12 mb-2">
            		<h3 class="content-header-title mb-0">Manajemen Item Anggaran</h3>
            		<div class="row breadcrumbs-top">
            			<div class="breadcrumb-wrapper col-xs-12">
            				<ol class="breadcrumb">
            					<li class="breadcrumb-item active">Manajemen Item</li>
            				</ol>
            			</div>
            		</div>
            	</div>
            </div>
            <div class="content-body">
            	<div class="row">
            		<section id="select-inputs">
            			<div class="row">
            				@if(session('add'))
            				<div class="col-xs-7">
            					<div class="alert alert-success">
            						<b>Data item berhasil ditambah.</b>
            					</div>
            				</div>
            				@elseif(session('unique'))
            				<div class="col-xs-7">
            					<div class="alert alert-warning">
            						<b>Kode item harus unik.</b>
            					</div>
            				</div>
            				@endif
            				<div class="col-xs-12">
            					<div class="card">
            						<div class="card-header">
            							<h4 class="card-title">Daftar Item Anggaran</h4>
            							<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            							<div class="row mt-1">
            								<div class="col-md-12 col-xl-3">
            									<button type="button" data-target="#tambahPos" data-toggle="modal" class="btn btn-success btn-sm pull-left"><i class="fa fa-plus"></i> Tambah Item Baru</button>
            								</div>
            							</div>
            							<div class="modal fade text-xs-left" id="tambahPos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            								<div class="modal-dialog">
            									<div class="modal-content">
            										<div class="modal-header">
            											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            												<span aria-hidden="true">&times;</span>
            											</button>
            											<h4 class="modal-title" id="myModalLabel">Tambah Item Anggaran</h4>
            										</div>
            										<form class="form" id="item-anggaran-form" action="{{ URL('item/submit/all') }}" method="POST">
            											{{ csrf_field() }}
            											<div class="modal-body" id="confirmation-msg">
            												<div class="row">
            													<div class="form-group col-md-12 col-xl-4">
            														<label for="kode_kelompok">Kode</label>
            														<input class="form-control" type="text" name="kode" placeholder="Kode Item Anggaran" value="" required>
            													</div>
            													<div class="form-group col-md-12 col-xl-8">
            														<label for="nama_jenis">Tipe Item Anggaran</label>
            														<select class="form-control" type="text" name="type" placeholder="Tipe Item Anggaran" required>
            															<option value="1" selected>Jenis Anggaran</option>
            															<option value="2">Pos Anggaran</option>
                                                                                                      <option value="3">Kelompok Anggaran</option>
            															<option value="4">Satuan</option>
            														</select>
            													</div>
            													<div class="form-group col-md-12 col-xl-12">
            														<label for="nama_jenis">Nama Item Anggaran</label>
            														<input class="form-control" type="text" name="name" placeholder="Nama Item Anggaran" value="" required>
            													</div>
            												</div>
            											</div>
            											<div class="modal-footer">
            												<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
            												<button type="submit" id="simpan" class="btn btn-outline-primary">Simpan</button>
            											</div>
            										</form>
            									</div>
            								</div>
            							</div>
            						</div>
            						<div class="card-body collapse in">			                
            							<div class="card-block">
            								@if(session('success'))
            								<div class="col-xs-6">
            									<div class="alert alert-success">
            										<b>Data item berhasil diubah.</b>
            									</div>
            								</div>
            								@elseif(session('deleted'))
            								<div class="col-xs-6">
            									<div class="alert alert-success">
            										<b>{!! session('deleted') !!}</b>
            									</div>
            								</div>
            								@endif
            								@if(count($errors->all()) > 0)
            								<div class="alert alert-danger alert-dismissable">
            									@foreach ($errors->all() as $error)
            									{!! $error !!}<br>
            									@endforeach
            								</div>
            								@endif
            								<name="data" id="data">
            								<div class="table-responsive">
            									<table class="table table-striped table-bordered datatable-select-inputs wrap" cellspacing="0" width="100%">
            										<thead>
            											<tr>
            												<th><center>No</center></th>
            												<th id="filterable">Kode Item Anggaran</th>
            												<th id="filterable">Nama Item Anggaran</th>
            												<th id="filterable">Tipe Item Anggaran</th>
            												<th><center>Aksi</center></th>
            											</tr>
            										</thead>
            										<tbody>
            											@foreach($items as $item)
            											@if(!$item->deleted_at)
            											<tr>
            												<td><center>{{ $no++ }}</center></td>
            												<td>{{ $item->kode }}</td>
            												<td>{{ $item->name }}</td>
            												<td>
            													@if($item->type == 1) Jenis Anggaran
            													@elseif($item->type == 2) Kelompok Anggaran
            													@elseif($item->type == 3) Pos Anggaran
                                                                                          @elseif($item->type == 4) Satuan
            													@endif
            												</td>
            												<td><center>
            													<button type="button" class="btn btn-outline-info btn-sm" onclick="showModal({{$item->id}})" data-toogle="modal">
            														<i class="fa fa-edit"></i> Edit</button>
            														<a href="#" class="btn btn-danger btn-sm" onclick="deleteUser({{ $item->id }})">
            															<i class="fa fa-trash"></i> Hapus</a>
            														</center></td>
            													</tr>
            													<div class="modal fade text-xs-left" id="editAnggaran{{$item->id}}"tabindex="-1" role="dialog" 
            														aria-labelledby="myModalLabel" aria-hidden="true">
            														<div class="modal-dialog">
            															<div class="modal-content">
            																<div class="modal-header">
            																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            																		<span aria-hidden="true">&times;</span>
            																	</button>
            																	<h4 class="modal-title" id="myModalLabel">Edit Item Anggaran</h4>
            																</div>
            																<form class="form" id="edit-jenis-form" action="{{ URL('item/update/item/'.$item->id) }}" method="POST">
            																	{{ csrf_field() }}
            																	<div class="modal-body" id="confirmation-msg">
            																		<div class="row">
            																			<div class="form-group col-md-12 col-xl-4">
            																				<label for="edit_kode">Kode Item</label>
            																				<input class="form-control" type="text" name="edit_kode" id="edit_kode" placeholder="Kode Item Anggaran" value="{{ $item->kode }}">
            																			</div> 
            																			<div class="form-group col-md-12 col-xl-8">
            																				<label for="edit_nama">Nama Item</label>
            																				<input class="form-control" type="text" name="edit_nama" id="edit_nama" placeholder="Nama Item Anggaran" value="{{ $item->name }}">
            																			</div>
            																		</div>
            																	</div>
            																	<div class="modal-footer">
            																		<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Kembali</button>
            																		<button type="submit" id="simpan" class="btn btn-outline-primary"><i class="fa fa-check"></i> Simpan</button>
            																	</div>
            																</form>
            															</div>
            														</div>
            													</div>
            													@endif
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
            		<script type="text/javascript" src="{{ asset('app-assets/js/scripts/modal/components-modal.min.js') }}"></script>
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
            				$('form[id="deleteU"').attr('action', '{{ url('item') }}' + '/delete/item/' + id);
            				var con = confirm("Apakah anda yakin untuk menghapus item ini?");
            				if (con) {
            					$('form[id="deleteU"').submit();	
            				}
            			}

            			function showModal(a){
            				$('#editAnggaran'+a).modal('show');
            			}
            		</script>
            		@endsection