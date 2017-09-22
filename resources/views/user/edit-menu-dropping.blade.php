  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <label class="text-primary" onclick="checkAll(this)" id="dropping"></label>
        </div>
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Aksi</h5>
          <div class="form-group skin skin-square" id="dropping">
            <fieldset>
              <input type="checkbox" name="perizinan[cari_d]" {{ isset($user->perizinan['cari_d']) ? 'checked=""' : '' }}>
              <label>Pencarian dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[masuk_tt_d]" {{ isset($user->perizinan['masuk_tt_d']) ? 'checked=""' : '' }}>
              <label>Lihat tarik tunai</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[masuk_tt_d]" {{ isset($user->perizinan['masuk_tt_d']) ? 'checked=""' : '' }}>
              <label>Masukkan tarik tunai</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[setuju_tt_d]" {{ isset($user->perizinan['setuju_tt_d']) ? 'checked=""' : '' }}>
              <label>Persetujuan tarik tunai</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[lihat_p_d]" {{ isset($user->perizinan['lihat_p_d']) ? 'checked=""' : '' }}>
              <label>Lihat penyesuaian dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[masuk_p_d]" {{ isset($user->perizinan['masuk_p_d']) ? 'checked=""' : '' }}>
              <label>Masukkan penyesuaian dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[setuju_p_d]" {{ isset($user->perizinan['setuju_p_d']) ? 'checked=""' : '' }}>
              <label>Persetujuan penyesuaian dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[setuju_p2_d]" {{ isset($user->perizinan['setuju_p2_d']) ? 'checked=""' : '' }}>
              <label>Persetujuan akhir penyesuaian dropping</label>
            </fieldset>
          </div>
        </div>
        <div class="card-block">
          <h5>Notifikasi</h5>
          <div class="form-group skin skin-square" id="dropping">
            <fieldset>
              <input type="checkbox" name="perizinan[notif_setuju_tt_d]" {{ isset($user->perizinan['notif_setuju_tt_d']) ? 'checked=""' : '' }}>
              <label>Persetujuan tarik tunai</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[notif_setuju_p_d]" {{ isset($user->perizinan['notif_setuju_p_d']) ? 'checked=""' : '' }}>
              <label>Persetujuan penyesuaian dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[notif_setuju_p2_d]" {{ isset($user->perizinan['notif_setuju_p2_d']) ? 'checked=""' : '' }}>
              <label>Persetujuan akhir penyesuaian dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[notif_ubah_tt_d]" {{ isset($user->perizinan['notif_ubah_tt_d']) ? 'checked=""' : '' }}>
              <label>Perubahan tarik tunai dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[notif_ubah_p_d]" {{ isset($user->perizinan['notif_ubah_p_d']) ? 'checked=""' : '' }}>
              <label>Perubahan penyesuaian dropping</label>
            </fieldset>
           </div>
        </div>
      </div>
    </div>
  </div>