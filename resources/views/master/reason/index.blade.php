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
          <h3 class="content-header-title mb-0">Manajemen Alasan Menolak Verifikasi Transaksi</h3>
          <div class="row breadcrumbs-top">
               <div class="breadcrumb-wrapper col-xs-12">
                    <ol class="breadcrumb">
                         <li class="breadcrumb-item">Manajemen Item</li>
                   </ol>
             </div>
       </div>
 </div>
</div>



<div class="modal fade" data-backdrop="static" id="tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel" > Tambah Item Alasan</h4>
                  </div>
                  <form enctype="multipart/form-data" role="form" action="{{ URL('reason/store') }}" method="POST" >
                        {{ csrf_field() }}
                        <div class="modal-body">
                              <div class="form-group">
                                    <label class="control-label"> Alasan</label>
                                    <input class="form-control" type="text" name="alasan" placeholder="Masukkan alasan" required="required"/>
                              </div>
                              <div class="form-group">
                                    <label class="control-label"> Keterangan </label>
                                    <select class="select form-control" name="keterangan" required="required" >
                                          <option value="" disabled="" selected="">Pilih keterangan</option>
                                          <option value="1">Reject transaksi by Kakancab (lv1)</option>
                                          <option value="2">Reject transaksi by akuntansi (lv2)</option>  
                                          <option value="3">Reject tarik tunai by akuntansi (lv1)</option>
                                          <option value="4">Reject penyesuaian dropping by bia (lv1)</option>
                                          <option value="5">Reject penyesuaian dropping by akuntansi (lv2)</option>                                                  
                                    </select>
                              </div>
                        </div>
                        <div class="modal-footer">
                              <button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-check "></i> Tambah</button>
                              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                  </form>
            </div>
      </div>
</div>
<div class="row">
     <section id="select-inputs">
          <div class="row">
               <div class="col-xs-12">
                    <div class="card">
                         <div class="card-header">
                              <h4 class="card-title">Daftar Item Alasan Menolak</h4>
                              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                              <div class="row mt-1">
                                   <div class="col-md-12 col-xl-3">
                                        <a href="#" class="btn btn-success btn-sm pull-left" data-target="#tambah" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Item Alasan</a>
                                  </div>
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
                                                     <th><center>No</center></th>
                                                     <th id="filterable"><center>Alasan</center></th>
                                                     <th id="filterable"><center>Keterangan</center></th>
                                                     <th><center>Aksi</center></th>
                                               </tr>
                                         </thead>
                                         <tbody>
                                          <?php $no='1';?>
                                          @foreach($reject_reasons as $reason)
                                          <tr>
                                               <td><center>{{ $no }}</center></td>
                                               <td>{{ $reason->content }}</td>
                                               <td><?php 
                                               if($reason->type=='1'){ echo "Reject transaksi by Kakancab (lv1)";}
                                               if($reason->type=='2'){ echo "Reject transaksi by akuntansi (lv2)";}
                                               if($reason->type=='3'){ echo "Reject tarik tunai by akuntansi (lv1)";}
                                               if($reason->type=='4'){ echo "Reject penyesuaian dropping by bia (lv1)";}
                                               if($reason->type=='5'){ echo "Reject penyesuaian dropping by akuntansi (lv2)";}
                                               ?>
                                         </td>
                                         <td><center>
                                               <button class="btn btn-outline-info btn-sm" data-target="#ubah{{$reason->id}}" data-toggle="modal"><i class="fa fa-edit"></i> Edit</button>
                                               <button class="btn btn-danger btn-sm" data-target="#hapus{{$reason->id}}" data-toggle="modal"><i class="fa fa-trash"></i> Hapus</button>

                                               <div class="modal fade" data-backdrop="static" id="hapus{{$reason->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                         <div class="modal-content">
                                                              <div class="modal-header">
                                                                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                   <h4 class="modal-title text-warning" id="myModalLabel" ><i class="fa fa-warning"></i> Perhatian!</h4>
                                                             </div>
                                                             <div class="modal-body">
                                                                   <h4>Anda yakin ingin menghapus alasan <br><span class=text-danger>{{ $reason->content }}</span> ?</h4>
                                                             </div>

                                                             <div class="modal-footer">
                                                                   <a href="{{ URL('reason/delete/'. $reason->id) }}"" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Ya</a>
                                                                   <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                                             </div>

                                                       </div>
                                                 </div>
                                           </div>
                                     </center></td>
                               </tr>
                               <div class="modal fade" data-backdrop="static" id="ubah{{$reason->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                         <div class="modal-content">
                                              <div class="modal-header">
                                                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                   <center><h4 class="modal-title text-info" id="myModalLabel" ><i class="fa fa-edit"></i> Ubah Alasan</h4></center>
                                             </div>
                                             <div class="modal-body">
                                                   <form enctype="multipart/form-data" role="form" action="{{ URL('reason/update/'. $reason->id) }}" method="POST" >
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="id"  value="{{$reason->id}}" />


                                                        <label class="control-label"><b> Alasan </b></label>
                                                        <label class="control-label"> : </label>
                                                        <input class="form-control" type="text" name="alasan" placeholder="masukkan alasan" value="{{$reason->content}}" required="required"/>

                                                        <br><br>
                                                        <label class="control-label"><b> Keterangan </b></label>
                                                        <label class="control-label"><b> : </b></label>
                                                        <select class="select form-control" name="keterangan" required="required"/>
                                                        <option value="" disabled="">Pilih keterangan</option>
                                                        <option value="1" @if ($reason->type=="1")Selected @endif>Reject transaksi by Kakancab (lv1)</option>
                                                        <option value="2" @if ($reason->type=="2")Selected @endif>Reject transaksi by akuntansi (lv2)</option>  
                                                        <option value="3" @if ($reason->type=="3")Selected @endif>Reject tarik tunai by akuntansi (lv1)</option>
                                                        <option value="4" @if ($reason->type=="4")Selected @endif>Reject penyesuaian dropping by bia (lv1)</option>
                                                        <option value="5" @if ($reason->type=="5")Selected @endif>Reject penyesuaian dropping by akuntansi (lv2)</option>                                                  
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
               <?php $no++; ?>
               @endforeach
         </tbody>
   </table>
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

              "emptyTable":  "Tidak Ada Alasan Menolak Tersimpan",
              "info":  "Data Alasan _START_-_END_ dari _TOTAL_ Alasan",
              "infoEmpty":  "Data Alasan 0-0 dari _TOTAL_ Alasan ",
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