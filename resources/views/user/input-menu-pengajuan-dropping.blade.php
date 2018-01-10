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
              <label>Informasi Pengajuan Dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[tambah_a_d]" {{ isset(old("perizinan")['tambah_a_d']) ? 'checked=""' : '' }}>
              <label>Tambah Pengajuan Dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[ubah_a_d]" {{ isset(old("perizinan")['ubah_a_d']) ? 'checked=""' : '' }}>
              <label>Ubah Pengajuan Dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[hapus_a_d]" {{ isset(old("perizinan")['hapus_a_d']) ? 'checked=""' : '' }}>
              <label>Hapus Pengajuan Dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[kirim_a_d]" {{ isset(old("perizinan")['kirim_a_d']) ? 'checked=""' : '' }}>
              <label>Kirim Pengajuan Dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[setuju_a_d]" {{ isset(old("perizinan")['setuju_a_d']) ? 'checked=""' : '' }}>
              <label>Persetujuan Pengajuan Dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[setuju_a_d_2]" {{ isset(old("perizinan")['setuju_a_d_2']) ? 'checked=""' : '' }}>
              <label>Persetujuan Pengajuan Dropping 2</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[setuju_a_d_3]" {{ isset(old("perizinan")['setuju_a_d_2']) ? 'checked=""' : '' }}>
              <label>Persetujuan Pengajuan Dropping 3</label>
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
              <input type="checkbox" name="perizinan[notif_setuju_a_d_2]" {{ isset(old("perizinan")['notif_setuju_a_d_2']) ? 'checked=""' : '' }}>
              <label>Permintaan Persetujuan Pengajuan Dropping 2</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[notif_setuju_a_d_3]" {{ isset(old("perizinan")['notif_setuju_a_d_3']) ? 'checked=""' : '' }}>
              <label>Permintaan Persetujuan Pengajuan Dropping 3</label>
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