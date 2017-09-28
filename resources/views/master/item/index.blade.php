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
                        <h3 class="content-header-title mb-0">Master Item</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Manajemen Item</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="{{ url('/item') }}">Manajemen Kombinasi Item</a>
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
			                  <h4 class="card-title">Daftar Item</h4>
			                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			                  <div class="col-md-12" >
	                              <a href="{{ url('item/create') }}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Tambah</a>
	                          </div>
			                </div>
			                <div class="card-body collapse in">			                
			                  <div class="card-block">
			                  	<name="data" id="data">
			                  	<div class="table-responsive">
			                      <table class="table table-striped table-bordered datatable-select-inputs wrap" cellspacing="0" width="120%">
			                        <thead>
			                          <tr>
			                          	<th width="5%">No</th>
			                          	<th id="filterable" width="5%"><center>Kode Item</center></th>
			                            <th id="filterable" width="20%">Item</th>
			                            <th id="filterable" width="10%">Jenis Anggaran</th>
			                            <th id="filterable" width="10%">Kelompok Anggaran</th>
			                            <th id="filterable" width="10%">Pos Anggaran</th>
			                            <th id="filterable" width="10%">Sub Pos</th>
			                            <th id="filterable" width="10%">Mata Anggaran</th>
			                            <th width="40%"><center>Aksi</center></th>
			                          </tr>
			                        </thead>
			                        <tbody>
			                        @foreach($items as $item)
		                        		<tr>
		                        			<td width="5%">{{ $no++ }}</td>
		                        			<td width="5%">{{ $item->kode_item }}</td>
		                        			<td width="20%">{{ $item->nama_item }}</td>
		                        			<td width="10%">{{ $jenis->where('kode', $item->jenis_anggaran)->first()['name'] }}
		                        			<td width="10%">{{ $kelompok->where('kode', $item->kelompok_anggaran)->first()['name'] }}</td>
		                        			<td width="10%">{{ $pos->where('kode', $item->pos_anggaran)->first()['name'] }}</td>
		                        			<td width="10%">{{ $item->sub_pos }}</td>
		                        			<td width="10%">{{ $item->mata_anggaran }}</td>
	                        				<td width="40%"><center>
	                        					<a href="{{ url('item/edit').'/'.$item->id }}" class="btn btn-info btn-sm">
	                        					<i class="fa fa-edit"></i> Edit</a>

	                        					<a href="#" class="btn btn-danger btn-sm" onclick="deleteUser({{ $item->id }})">
	                        					<i class="fa fa-trash"></i> Hapus</a>
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