<div class="row">
  @if(session('success'))
  <div class="col-xs-7">
    <div class="alert alert-success">
      @if(session('success')[0] > 0)
      Item batch transaksi sebanyak <b>{{ session('success')[0] }} baris baru berhasil disimpan</b>.<br>
      @endif
      @if(session('success')[1] > 0)
      Item batch transaksi sebanyak <b>{{ session('success')[1] }} baris berhasil diupdate</b>.<br>
      @endif
      @if(session('success')[2] > 0)
      Item batch transaksi sebanyak <b>{{ session('success')[2] }} baris berhasil dihapus</b>.
      @endif
      @if(session('success')[3] > 0)
      Berkas batch transaksi sebanyak <b>{{ session('success')[3] }} berkas baru berhasil disimpan</b>.
      @endif
    </div>
  </div>
  @endif
  @if(session('success_submit'))
  <div class="col-xs-6">
    <div class="alert alert-info">
      Batch <code>{{ session('success_submit') }}</code> berhasil disubmit. <b>Silahkan tunggu verifikasi dari user.</b></code>
    </div>
  </div>
  @endif
  @if(session('success_deletion'))
  <div class="col-xs-6">
    <div class="alert alert-success">
      Berkas <code>{{ session('success_deletion') }}</code> berhasil dihapus.
    </div>
  </div>
  @endif
  @if(session('success_newBatch'))
  <div class="col-xs-6">
    <div class="alert alert-success">
      <b>Batch baru</b> berhasil dibuat.
    </div>
  </div>
  @endif
  @if(session('failed_filter'))
  <div class="col-xs-6">
    <div class="alert alert-danger">
      {!! session('failed_filter') !!}
    </div>
  </div>
  @endif
  @if(session('success_filtering'))
  <div class="col-xs-6">
    <div class="alert alert-success">
      Filtering berhasil berdasar
      @if($filters[0])
      <b>tanggal batch. </b>
      @endif
      @if($filters[1])
      <b>nomor batch. </b>
      @endif
    </div>
  </div>
  @endif
</div>