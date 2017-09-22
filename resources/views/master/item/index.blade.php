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
		                  		@if(session('success'))
				                  	<div class="alert alert-success">
				                  		{!! session('success') !!}
				                	</div>
				                @endif
			                    <div class="table-responsive">
			                      <table class="table table-striped table-bordered datatable-select-inputs nowrap" cellspacing="0" width="100%">
			                        <thead>
			                          <tr>
			                            <th id="filterable" width="200px">Item</th>
			                            <th id="filterable" width="200px">Jenis Anggaran</th>
			                            <th id="filterable" width="200px">Kelompok Anggaran</th>
			                            <th id="filterable" width="200px">Pos Anggaran</th>
			                            <th id="filterable" width="200px">Sub Pos</th>
			                            <th id="filterable" width="200px">Mata Anggaran</th>
			                            <th>Aksi</th>
			                          </tr>
			                        </thead>
			                        <tbody>
		                        		<tr>
		                        			<td>Laptop</td>
		                        			<td>Belanja Modal</td>
		                        			<td>Komputer</td>
		                        			<td>Komputer KC/KCP</td>
		                        			<td>Hardware</td>
		                        			<td>Laptop</td>
		                        			{{-- {!! $user->deleted_at ? '<td class="red">Deleted</td>' : '<td class="blue">Aktif</td>' !!}
		                        			<td>
		                        				<a class="btn btn-sm btn-primary" href="{{ url('user').'/'.$user->id }}"><i class="fa fa-info"></i> Detil</a>
		                        				@if(!$user->deleted_at)
		                        					<a class="btn btn-sm btn-primary" href="{{ url('user').'/'.$user->id.'/edit' }}"><i class="fa fa-edit"></i> Edit</a>
	                        					@endif
	                        					@if(Auth::user()->id != $user->id && !$user->deleted_at)
			                        				<a class="btn btn-sm btn-danger" href="#" onclick="deleteUser({{ $user->id }}, false)"><i class="fa fa-times"></i> Hapus</a>
			                        			@endif
			                        			@if($user->deleted_at)
			                        				<a class="btn btn-sm btn-warning" href="#" onclick="restoreUser({{ $user->id }})"><i class="fa fa-backward"></i> Restore</a>
			                        				<a class="btn btn-sm btn-danger" href="#" onclick="deleteUser({{ $user->id }}, true)"><i class="fa fa-times"></i> Hapus permanen</a>
		                        				@endif
	                        				</td> --}}
	                        				<td></td>
		                        		</tr>
			                        </tbody>
			                      </table>
			                      {{-- <form method="post" action="#" id="restoreU">
                					 {{ csrf_field() }}
	                			  </form>
	                			  <form method="post" action="#" id="deleteU">
                					 {{ csrf_field() }}
                					 {{ method_field('DELETE') }}
                					 <input type="hidden" name="is_force" value="0">
                				   </form> --}}
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
					/*$('.datatable-select-inputs').DataTable( {
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
						} );*/

				</script>
                @endsection