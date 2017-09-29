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
                        <h3 class="content-header-title mb-0">Perizinan Jenis User</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-xs-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('user') }}">Manajemen User</a>
                                    </li>
                                    <li class="breadcrumb-item active">Perizinan Jenis User
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
			                  <h4 class="card-title">List Jenis User</h4>
			                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			                </div>
			                <div class="card-body collapse in">
			                  <div class="card-block">
			                    <div class="table-responsive">
			                      <table class="table table-striped table-bordered datatable-select-inputs nowrap" cellspacing="0" width="100%">
			                        <thead>
			                          <tr>
			                            <th id="filterable" width="200px">Nama Jenis User</th>
			                            <th id="filterable">Dibuat oleh</th>
			                            <th id="filterable">Dibuat pada</th>
			                            <th id="filterable">Terakhir diperbarui</th>
			                            <th>Banyak User</th>
			                            <th id="filterable">Status</th>
			                            <th>Aksi</th>
			                          </tr>
			                        </thead>
			                        <tbody>
			                        	@forelse($users as $user)
			                        		<tr>
			                        			<td>{{  $user->nama }}</td>
			                        			<td>{{  $user->creator['name'] }}</td>
			                        			<td>{!! date('Y-m-d, H:m', strtotime($user->created_at)) !!}</td>
			                        			<td>{!! date('Y-m-d, H:m', strtotime($user->updated_at)) !!}</td>
			                        			<td>{!! $user->countUsers() !!}</td>
			                        			{!! $user->deleted_at ? '<td class="red">Deleted</td>' : '<td class="blue">Aktif</td>' !!}
			                        			<td>
			                        				@if(!$user->deleted_at && Gate::check('edit_jenis'))
			                        					<a class="btn btn-sm btn-primary" href="{{ url('jenis_user').'/'.$user->id.'/edit' }}"><i class="fa fa-edit"></i> Edit</a>
		                        					@endif
		                        					@if(Auth::user()->id != $user->id && !$user->deleted_at && $user->countUsers() == 0)
				                        				<a class="btn btn-sm btn-danger" href="#" onclick="deleteUser({{ $user->id }}, false)"><i class="fa fa-times"></i> Hapus</a>
				                        			@endif
				                        			@if($user->deleted_at)
				                        				<a class="btn btn-sm btn-warning" href="#" onclick="restoreUser({{ $user->id }})"><i class="fa fa-backward"></i> Restore</a>
				                        				<!-- <a class="btn btn-sm btn-danger" href="#" onclick="deleteUser({{ $user->id }}, true)"><i class="fa fa-times"></i> Hapus permanen</a> -->
			                        				@endif
		                        				</td>
			                        		</tr>
			                        	@empty
			                        	@endforelse
			                        </tbody>
			                        <tfoot>
			                          <tr>
			                          	<th>Nama Lengkap</th>
			                            <th>Username</th>
			                            <th>Email</th>
			                            <th>Kantor Cabang</th>
			                            <th></th>
			                            <th>Deleted</th>
			                            <th></th>
			                          </tr>
			                        </tfoot>
			                      </table>
			                      <form method="post" action="#" id="restoreU">
                					 {{ csrf_field() }}
	                			  </form>
	                			  <form method="post" action="#" id="deleteU">
                					 {{ csrf_field() }}
                					 {{ method_field('DELETE') }}
                					 <input type="hidden" name="is_force" value="0">
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
					$(document).ready(function() {
						@if (session('success'))
							toastr.info("{!! session('success') !!}", "Update Berhasil", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
						@endif
					});
					function deleteUser(id, is_force) {
						if (is_force == true) {
							$('input[name="is_force"]').val('1');
						}
						$('form[id="deleteU"').attr('action', '{{ url('jenis_user') }}' + '/' + id);
						var con = confirm("Apakah anda yakin untuk menghapus jenis user ini?");
						if (con) {
							$('form[id="deleteU"').submit();	
						}
					}

					function restoreUser(id) {
						$('form[id="restoreU"').attr('action', '{{ url('jenis_user/restore') }}' + '/' + id);
						var con = confirm("Apakah anda yakin untuk melakukan restore jenis user ini?");
						if (con) {
							$('form[id="restoreU"').submit();	
						}
					}
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
						} );

				</script>
                @endsection