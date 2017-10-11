  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <label class="text-primary" onclick="checkAll(this)" id="pengajuan"></label>
        </div>
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Aksi</h5>
          <div class="form-group skin skin-square" id="pengajuan">
            <fieldset>
              <input type="checkbox" name="perizinan[informasi_a_d]" {{ isset(old("perizinan")['informasi_a_d']) ? 'checked=""' : '' }}>
              <label>Pengajuan Dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[setuju_a_d]" {{ isset(old("perizinan")['lihat_tt_d']) ? 'checked=""' : '' }}>
              <label>Persetujuan Pengajuan Dropping</label>
            </fieldset>
          </div>
        </div>
        <div class="card-block">
          <h5>Notifikasi</h5>
          <div class="form-group skin skin-square" id="pengajuan">
            <fieldset>
              <input type="checkbox" name="perizinan[notif_setuju_a_d]" {{ isset(old("perizinan")['notif_setuju_a_d']) ? 'checked=""' : '' }}>
              <label>Permintaan Persetujuan Pengajuan Dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[notif_ubah_a_d]" {{ isset(old("perizinan")['notif_ubah_a_d']) ? 'checked=""' : '' }}>
              <label>Perubahan Pengajuan Dropping</label>
            </fieldset>
           </div>
        </div>
      </div>
    </div>
  </div>