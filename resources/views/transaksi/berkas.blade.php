<div class="col-lg-6 col-md-12">
  @if($editable && Gate::check('berkas_t'))
  <fieldset class="form-group">
    <label for="basicInputFile">Unggah berkas</label>
    <input type="file" class="form-control-file" id="basicInputFile" multiple="" name="berkas[]">
  </fieldset>
  @endif
  <div class="bs-callout-info callout-border-left callout-bordered callout-transparent mt-1 p-1">
    <h4 class="info">Daftar Berkas</h4>
    <table>
      @forelse($berkas as $value)
      <tr>
        <td width="25%"><a href="{{ url('transaksi/berkas/download').'/'.$value->id }}" target="_blank">{{ $value->file_name }}</a></td>
        <?php
        $tanggal=$value->created_at;                                 
        $tgl= date('d-m-Y H:i:s', strtotime($tanggal));
        ?>
        <td width="25%"><b>{{ $tgl }}</b></td>
        <td width="5%">
          @if($editable && Gate::check('berkas_t'))
          <?php 
            $is_reversed=\DB::table('batches_status')->where('batch_id', $active_batch['id'])->where('stat', 6)->first();
          ?>
          @if(!$is_reversed)
          <!-- <a href="javascript:deleteBerkas('{{ $value->id }}', '{{ $value->file_name }}');"><i class="fa fa-times"></i> Hapus</a> -->
          <span data-toggle='tooltip' title='Hapus'><a class="btn btn-outline-danger btn-sm" data-target="#hapus{{$value->id}}" data-toggle="modal"><i class="fa fa-times"></i> Hapus</a></span>
          @endif
          <div class="modal fade" data-backdrop="static" id="hapus{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <center><h4 class="modal-title text-warning" id="myModalLabel" ><i class="fa fa-warning"></i> Peringatan!</h4></center> 
                </div>
                <div class="modal-body">
                  <center><h5>Anda yakin ingin menghapus berkas <br><span class=text-danger>{{ $value->file_name }}</span> ?</h5></center>
                </div>
                <div class="modal-footer">
                  <a href="javascript:deleteBerkas('{{$value->id}}', '{{ $value->file_name }}');" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Ya</a>
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                </div>
              </div>
            </div>
          </div>
          @endif
        </td>
      </tr>
      @empty
      <code>Belum ada berkas terlampir</code>
      @endforelse
    </table>
  </div>
</div>