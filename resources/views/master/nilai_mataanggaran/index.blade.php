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
            		<h3 class="content-header-title mb-0">Master Nilai Mata Anggaran</h3>
            		<div class="row breadcrumbs-top">
            			<div class="breadcrumb-wrapper col-xs-12">
            				<ol class="breadcrumb">
            					<li class="breadcrumb-item">Master Nilai Mata Anggaran</li>
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
                        <h4 class="card-title">Tambah Nilai Mata Anggaran</h4>
                        <a class="heading-elements-toggle"><i class="ft-align-justify font-medium-3"></i></a>
                      </div>
                      <div class="card-body collapse in">
                        <div class="card-block">
                          <form enctype="multipart/form-data" role="form" action="{{ URL('nilai_mataanggaran/store_nilai_mataanggaran') }}" method="POST" >
                            <div class="row">
                              {{ csrf_field() }}
                              <div class="col-xs-5">
                                <div class="form-group">
                                  <label><b>Mata Anggaran</b></label><br>
                                  <select class="select2 form-control block" name="description" id="description" onchange="getVal('description', 'kode');" required="required">
                                    
                                    <option disabled="" selected="" value="">- Pilih Mata Anggaran -</option>
                                    <?php
                                    $second="SELECT DESCRIPTION, VALUE
                                            FROM [AX_DUMMY].[dbo].[PIL_VIEW_KEGIATAN] as a
                                            join [DBCabang].[dbo].[item_master_anggaran] as b
                                            on a.value=b.mata_anggaran order by description";
                                    $return = DB::select($second);
                                    ?>
                                    @foreach($return as $cabang)
                                      <option value="{{ $cabang->VALUE }}" >{{ $cabang->DESCRIPTION }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-xs-2">
                                <div class="form-group">
                                  <label><b>Kode</b></label><br>
                                  <input type="text" class="form-control block" name="kode" id="kode" value="" readonly="" placeholder="Kode">
                                </div>
                              </div>
                              <div class="col-xs-4">
                                <div class="form-group">
                                  <label><b>Nilai Per Satuan</b></label><br>
                                  <input class="form-control block" type="text" name="nilai" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="masukkan nilai per satuan" required="required">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-7">
                                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-plus "></i> Tambah</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                                      
                  </div>
                </div>
              </div>

            <div class="row">
            	<section id="select-inputs">
            		<div class="row">
            			<div class="col-xs-12">
            				<div class="card">
            					
            					
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
            												<th id="filterable"><center>Kode</center></th>
                                                                                    <th id="filterable"><center>Mata Anggaran</center></th>
                                                                                    <th id="filterable"><center>Nilai Per Satuan</center></th>
            												<th width="10%"><center>Aksi</center></th>
            											</tr>
            										</thead>
            										<tbody>
            											<?php $no='1';?>
            											@if(count($a))
            											@foreach($a as $b)

            											<tr>
            												<td><center>{{ $no }}</center></td>
            												<td><center>{{ $b->value }}</center></td>
                                                                                    <td>{{ $b->description }}</td>
                                                                                    <td align="right">Rp. {{ number_format($b->nilai,0,"",".") }}</td>
            												<td><center>
            													<a href="#" class="btn btn-outline-info btn-sm" data-target="#ubah{{$b->id}}" data-toggle="modal"><i class="fa fa-edit"></i> Edit</a>
            													<a href="#" class="btn btn-danger btn-sm" data-target="#hapus{{$b->id}}" data-toggle="modal"><i class="fa fa-trash"></i> Hapus</a>

            													<div class="modal fade" data-backdrop="static" id="hapus{{$b->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            														<div class="modal-dialog">
            															<div class="modal-content">
            																<div class="modal-header">
            																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            																	<h4 class="modal-title text-warning" id="myModalLabel" ><i class="fa fa-warning"></i> Peringatan !</h4>
            																</div>
            																<div class="modal-body">
            																	<h4>Anda yakin ingin nilai mata anggaran <br><span class=text-danger>{{ $b->description }}</span> ?</h4>
            																</div>
            																<div class="modal-footer">
            																	<a href="{{ URL('nilai_mataanggaran/delete_nilai_mataanggaran/'. $b->id) }}"" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Ya</a>
            																	<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
            																</div>
            															</div>
            														</div>
            													</div>

            												</center></td>
            											</tr>
            											<div class="modal fade" data-backdrop="static" id="ubah{{$b->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            												<div class="modal-dialog">
            													<div class="modal-content">
            														<div class="modal-header">
            															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            															<center><h4 class="modal-title text-info" id="myModalLabel" ><i class="fa fa-edit"></i> Ubah Nilai Persatuan</h4></center>
            														</div>
            														<div class="modal-body">
            															<form enctype="multipart/form-data" role="form" action="{{ URL('nilai_mataanggaran/update_nilai_mataanggaran/'. $b->id) }}" method="POST" >
            																{{ csrf_field() }}
            																<input type="hidden" name="id"  value="{{$b->id}}" />


            																<label class="control-label"><b> Mata Anggaran </b></label>
            																<label class="control-label"> : </label>
            																<input class="form-control" type="text" name="description" disabled value="{{$b->description}}" required="required"/>
                                                                                                            <br>
                                                                                                            <label class="control-label"><b> Mata Anggaran </b></label>
                                                                                                            <label class="control-label"> : </label>
                                                                                                            <input class="form-control" type="text" name="value" disabled value="{{$b->value}}" required="required"/>
                                                                                                            <br>
                                                                                                            <label class="control-label"><b> Nilai Per Satuan </b></label>
                                                                                                            <label class="control-label"> : </label>
                                                                                                            <input class="form-control" type="text" name="nilai" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="masukkan nilai per satuan" value="{{ number_format($b->nilai,0,"",".") }}" required="required"/>
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
                  function getVal(s, v){
                    var inv_nrs;
                    inv_nrs = document.getElementById(s);
                    /* Ketika nama item diambil dari nama mata anggaran */
                    // if(s = 'kegiatan'){
                    //   document.getElementById('nama_item').value = inv_nrs.options[inv_nrs.selectedIndex].text;
                    // }
                    return document.getElementById(v).value = inv_nrs.options[inv_nrs.selectedIndex].value;
                  }

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

  function tandaPemisahTitik(b){
    var _minus = false;
    if (b<0) _minus = true;
    b = b.toString();
    b=b.replace(".","");
    b=b.replace("-","");
    c = "";
    panjang = b.length;
    j = 0;
    for (i = panjang; i > 0; i--){
      j = j + 1;
      if (((j % 3) == 1) && (j != 1)){
        c = b.substr(i-1,1) + "." + c;
      } else {
        c = b.substr(i-1,1) + c;
      }
    }
    if (_minus) c = "-" + c ;
    return c;
  }

  function numbersonly(ini, e){
    if (e.keyCode>=49){
      if(e.keyCode<=57){
        a = ini.value.toString().replace(".","");
        b = a.replace(/[^\d]/g,"");
        b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
        ini.value = tandaPemisahTitik(b);
        return false;
      }
      else if(e.keyCode<=105){
        if(e.keyCode>=96){
                        //e.keycode = e.keycode - 47;
                        a = ini.value.toString().replace(".","");
                        b = a.replace(/[^\d]/g,"");
                        b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
                        ini.value = tandaPemisahTitik(b);
                        //alert(e.keycode);
                        return false;
                      }
                      else {return false;}
                    }
                    else {
                      return false; }
                    }else if (e.keyCode==48){
                      a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
                      b = a.replace(/[^\d]/g,"");
                      if (parseFloat(b)!=0){
                        ini.value = tandaPemisahTitik(b);
                        return false;
                      } else {
                        return false;
                      }
                    }else if (e.keyCode==95){
                      a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
                      b = a.replace(/[^\d]/g,"");
                      if (parseFloat(b)!=0){
                        ini.value = tandaPemisahTitik(b);
                        return false;
                      } else {
                        return false;
                      }
                    }else if (e.keyCode==8 || e.keycode==46){
                      a = ini.value.replace(".","");
                      b = a.replace(/[^\d]/g,"");
                      b = b.substr(0,b.length -1);
                      if (tandaPemisahTitik(b)!=""){
                        ini.value = tandaPemisahTitik(b);
                      } else {
                        ini.value = "";
                      }

                      return false;
                    } else if (e.keyCode==9){
                      return true;
                    } else if (e.keyCode==17){
                      return true;
                    } else {
                        //alert (e.keyCode);
                        return false;
                      }

                    }

            </script>

            @endsection