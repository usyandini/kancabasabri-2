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
            {{-- part alert --}}
            @if (Session::has('after_save'))
            <div class="row">
            	<div class="col-md-12">
            		<div class="alert alert-dismissible alert-{{ Session::get('after_save.alert') }}">
            			<button type="button" class="close" data-dismiss="alert">×</button>
            			<strong>{{ Session::get('after_save.title') }}</strong>

            		</div>
            	</div>
            </div>
            @endif
            {{-- end part alert --}}


            {{-- Kita cek, jika sessionnya ada maka tampilkan alertnya, jika tidak ada maka tidak ditampilkan alertnya --}}

            @if (Session::has('after_update'))
            <div class="row">
            	<div class="col-md-12">
            		<div class="alert alert-dismissible alert-{{ Session::get('after_update.alert') }}">
            			<button type="button" class="close" data-dismiss="alert">×</button>
            			<strong>{{ Session::get('after_update.title') }}</strong>

            		</div>
            	</div>
            </div>
            @endif
            {{-- end part alert --}}

            {{-- Kita cek, jika sessionnya ada maka tampilkan alertnya, jika tidak ada maka tidak ditampilkan alertnya --}}

            @if (Session::has('after_delete'))
            <div class="row">
            	<div class="col-md-12">
            		<div class="alert alert-dismissible alert-{{ Session::get('after_delete.alert') }}">
            			<button type="button" class="close" data-dismiss="alert">×</button>
            			<strong>{{ Session::get('after_delete.title') }}</strong>

            		</div>
            	</div>
            </div>
            @endif
            {{-- end part alert --}}


            <div class="content-header row">
            	<div class="content-header-left col-md-6 col-xs-12 mb-2">
            		<h3 class="content-header-title mb-0">Transaksi</h3>
            		<div class="row breadcrumbs-top">
            			<div class="breadcrumb-wrapper col-xs-12">
            				<ol class="breadcrumb">
            					<li class="breadcrumb-item">Tanggal Transaksi</li>
            				</ol>
            			</div>
            		</div>
            	</div>
            </div>




            <div class="row">
            	<section id="select-inputs">
            		<div class="row">
            			<div class="col-xs-12">
            				<div class="card">
            					<div class="card-header">
            						<h4 class="card-title">Filter Tanggal Input Transaksi</h4>
            						<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
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
            												<th width="5%"><center>No</center></th>
                                                                                    <th id="filterable"><center>Tanggal</center></th>
            												<th id="filterable"><center>Status</center></th>
                                                                                    <th id="filterable"><center>Bulan Awal</center></th>
                                                                                    <th id="filterable"><center>Bulan Akhir</center></th>
                                                                                    <th id="filterable"><center>Tahun</center></th>
            												<th width="10%"><center>Aksi</center></th>
            											</tr>
            										</thead>
            										<tbody>
            											<?php $no='1';?>
            											@if(count($tanggal))
            											@foreach($tanggal as $reason)

            											<tr>
            												<td><center>{{ $no }}</center></td>
            												<td><center>{{ $reason->tanggal }}</center></td>
                                                                                    <td><center>@if($reason->stat==1) <a class="btn btn-info btn-sm"><b>Aktif:Tanggal</b></a> @elseif($reason->stat==2) <a class="btn btn-success btn-sm"><b>Aktif:Tahun & Bulan</b></a> @endif</center></td>
                                                                                    <td><center>@if($reason->bulanawal==0) Januari
                                                                                                @elseif($reason->bulanawal==1) Februari
                                                                                                @elseif($reason->bulanawal==2) Maret
                                                                                                @elseif($reason->bulanawal==3) April
                                                                                                @elseif($reason->bulanawal==4) Mei
                                                                                                @elseif($reason->bulanawal==5) Juni
                                                                                                @elseif($reason->bulanawal==6) Juli
                                                                                                @elseif($reason->bulanawal==7) Agustus
                                                                                                @elseif($reason->bulanawal==8) September
                                                                                                @elseif($reason->bulanawal==9) Oktober
                                                                                                @elseif($reason->bulanawal==10) November
                                                                                                @elseif($reason->bulanawal==11) Desember @endif
                                                                                    </center></td>
                                                                                    <td><center>@if($reason->bulanakhir==0) Januari
                                                                                                @elseif($reason->bulanakhir==1) Februari
                                                                                                @elseif($reason->bulanakhir==2) Maret
                                                                                                @elseif($reason->bulanakhir==3) April
                                                                                                @elseif($reason->bulanakhir==4) Mei
                                                                                                @elseif($reason->bulanakhir==5) Juni
                                                                                                @elseif($reason->bulanakhir==6) Juli
                                                                                                @elseif($reason->bulanakhir==7) Agustus
                                                                                                @elseif($reason->bulanakhir==8) September
                                                                                                @elseif($reason->bulanakhir==9) Oktober
                                                                                                @elseif($reason->bulanakhir==10) November
                                                                                                @elseif($reason->bulanakhir==11) Desember @endif
                                                                                    </center></td>
            												<td><center>{{ $reason->tahun }}</center></td>
                                                                                    <td><center>
            													<a href="#" class="btn btn-outline-info btn-sm" data-target="#ubah{{$reason->id}}" data-toggle="modal"><i class="fa fa-edit"></i> Edit</a>
            												</center></td>
            											</tr>
            											<div class="modal fade" data-backdrop="static" id="ubah{{$reason->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            												<div class="modal-dialog">
            													<div class="modal-content">
            														<div class="modal-header">
            															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            															<center><h4 class="modal-title text-info" id="myModalLabel" ><i class="fa fa-edit"></i> Ubah Tanggal</h4></center>
            														</div>
            														<div class="modal-body">
            															<form enctype="multipart/form-data" role="form" action="{{ URL('transaksi/input_tanggal/update_input_tanggal/'. $reason->id) }}" method="POST" >
            																{{ csrf_field() }}
            																<input type="hidden" name="id"  value="{{$reason->id}}" />

                                                                                                            <label class="control-label"><b> Aktif </b></label>
                                                                                                            <label class="control-label"> : </label>
                                                                                                            <select class="form-control block" name="stat" style="width:100%" required="required">
                                                                                                                  <option value="" disabled="" selected=""> - Aktif - </option>
                                                                                                                  <option value="1" @if ($reason->stat==1)Selected @endif> Tanggal </option>
                                                                                                                  <option value="2" @if ($reason->stat==2)Selected @endif> Bulan dan Tahun </option>
                                                                                                            </select><br>
            																<label class="control-label"><b> Tanggal </b></label>
            																<label class="control-label"> : </label>
            																<input class="form-control" type="number" min="1" name="tanggal" placeholder="masukkan tanggal" value="{{$reason->tanggal}}" required="required"/>
                                                                                                            <br>
                                                                                                            <label class="control-label"><b> Bulan Awal </b></label>
                                                                                                            <label class="control-label"> : </label>
                                                                                                            <select class="form-control block" name="awal" style="width:100%" required="required">
                                                                                                                  <option value="" disabled="" selected=""> - Pilih Bulan Awal - </option>
                                                                                                                  <option value="0" @if ($reason->bulanawal==0)Selected @endif> Januari </option>
                                                                                                                  <option value="1" @if ($reason->bulanawal==1)Selected @endif> Februari </option>
                                                                                                                  <option value="2" @if ($reason->bulanawal==2)Selected @endif> Maret </option>
                                                                                                                  <option value="3" @if ($reason->bulanawal==3)Selected @endif> April </option>
                                                                                                                  <option value="4" @if ($reason->bulanawal==4)Selected @endif> Mei </option>
                                                                                                                  <option value="5" @if ($reason->bulanawal==5)Selected @endif> Juni </option>
                                                                                                                  <option value="6" @if ($reason->bulanawal==6)Selected @endif> Juli </option>
                                                                                                                  <option value="7" @if ($reason->bulanawal==7)Selected @endif> Agustus </option>
                                                                                                                  <option value="8" @if ($reason->bulanawal==8)Selected @endif> September </option>
                                                                                                                  <option value="9" @if ($reason->bulanawal==9)Selected @endif> Oktober </option>
                                                                                                                  <option value="10" @if ($reason->bulanawal==10)Selected @endif> November </option>
                                                                                                                  <option value="11" @if ($reason->bulanawal==11)Selected @endif> Desember </option>
                                                                                                            </select>
                                                                                                            <br>
                                                                                                            <label class="control-label"><b> Bulan Akhir </b></label>
                                                                                                            <label class="control-label"> : </label>
                                                                                                            <select class="form-control block" name="akhir" style="width:100%" required="required">
                                                                                                                  <option value="" disabled="" selected=""> - Pilih Bulan Akhir - </option>
                                                                                                                  <option value="0" @if ($reason->bulanakhir==0)Selected @endif> Januari </option>
                                                                                                                  <option value="1" @if ($reason->bulanakhir==1)Selected @endif> Februari </option>
                                                                                                                  <option value="2" @if ($reason->bulanakhir==2)Selected @endif> Maret </option>
                                                                                                                  <option value="3" @if ($reason->bulanakhir==3)Selected @endif> April </option>
                                                                                                                  <option value="4" @if ($reason->bulanakhir==4)Selected @endif> Mei </option>
                                                                                                                  <option value="5" @if ($reason->bulanakhir==5)Selected @endif> Juni </option>
                                                                                                                  <option value="6" @if ($reason->bulanakhir==6)Selected @endif> Juli </option>
                                                                                                                  <option value="7" @if ($reason->bulanakhir==7)Selected @endif> Agustus </option>
                                                                                                                  <option value="8" @if ($reason->bulanakhir==8)Selected @endif> September </option>
                                                                                                                  <option value="9" @if ($reason->bulanakhir==9)Selected @endif> Oktober </option>
                                                                                                                  <option value="10" @if ($reason->bulanakhir==10)Selected @endif> November </option>
                                                                                                                  <option value="11" @if ($reason->bulanakhir==11)Selected @endif> Desember </option>
                                                                                                            </select>
                                                                                                            <br>
                                                                                                            <label class="control-label"><b> Tahun </b></label>
                                                                                                            <label class="control-label"> : </label>
                                                                                                            <select class="form-control" name="tahun" style="width:100%" required value="{{$reason->tahun}}">
                                                                                                                <option selected disabled>Pilih Tahun</option>
                                                                                                                <?php
                                                                                                                $thn_skr = date('Y');
                                                                                                                for($x=$thn_skr; $x >= 2015; $x--){
                                                                                                                  ?>
                                                                                                                  <option value="{{$x}}"
                                                                                                                  @if($x == $reason->tahun) Selected>{{ $x }}@endif
                                                                                                                  @if($x <> $reason->tahun)>{{ $x }}@endif
                                                                                                                  </option>
                                                                                                                  <?php }?>
                                                                                                            </select>

                                                                                                            

            															</div>
            															<div class="modal-footer">
            																<button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Ubah</button>
            																<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
            															</div>
            														</form>
            													</div>
            												</div>
            											</div>
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