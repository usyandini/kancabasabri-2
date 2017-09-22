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
                        <h3 class="content-header-title mb-0">Manajemen Kombinasi Item</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Manajemen Item</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="{{ url('/item') }}">Master Item</a>
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
			                      <table class="table table-striped table-bordered datatable-select-inputs wrap" cellspacing="0" width="100%">
			                        <thead>
			                          <tr>
			                          	<th><center>No</center></th>
			                          	<th id="filterable"><center>Kode Item</center></th>
			                            <th id="filterable">Item</th>
			                            <th id="filterable">Jenis Anggaran</th>
			                            <th id="filterable">Kelompok Anggaran</th>
			                            <th id="filterable">Pos Anggaran</th>
			                            <th id="filterable">Sub Pos</th>
			                            <th id="filterable">Mata Anggaran</th>
			                            <th><center>Aksi</center></th>
			                          </tr>
			                        </thead>
			                        <tbody>
			                        @foreach($items as $item)
		                        		<tr>
		                        			<td><center>{{ $no++ }}</center></td>
		                        			<td>{{ $item->kode_item }}</td>
		                        			<td>{{ $item->nama_item }}</td>
		                        			<td>{{ $jenis->where('kode', $item->jenis_anggaran)->first()['name'] }}
		                        			<td>{{ $kelompok->where('kode', $item->kelompok_anggaran)->first()['name'] }}</td>
		                        			<td>{{ $pos->where('kode', $item->pos_anggaran)->first()['name'] }}</td>
		                        			<td>{{ $item->sub_pos }}</td>
		                        			<td>{{ $item->mata_anggaran }}</td>
	                        				<td>
	                        					<a href="{{ url('item/edit').'/'.$item->id }}" class="btn btn-info btn-sm">
	                        					<i class="fa fa-edit"></i> Edit</a>

	                        					<a href="#" class="btn btn-danger btn-sm" onclick="deleteUser({{ $item->id }})">
	                        					<i class="fa fa-trash"></i> Hapus</a>
	                        				</td>
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
						$('form[id="deleteU"').attr('action', '{{ url('item') }}' + '/delete/' + id);
						var con = confirm("Apakah anda yakin untuk menghapus item ini?");
						if (con) {
							$('form[id="deleteU"').submit();	
						}
					}
				</script>
                @endsection