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
        <td width="25%"><b>{{ $value->created_at }}</b></td>
        <td width="5%">
          @if($editable && Gate::check('berkas_t'))
          <a href="javascript:deleteBerkas('{{ $value->id }}', '{{ $value->file_name }}');"><i class="fa fa-times"></i> Hapus</a>
          @endif
        </td>
      </tr>
      @empty
      <code>Belum ada berkas terlampir</code>
      @endforelse
    </table>
  </div>
</div>