<div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <label class="text-primary" onclick="checkAll(this)" id="transaksi"></label>
        </div>
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Aksi</h5>
          <div class="form-group skin skin-square" id="transaksi">
            <fieldset >
              <input id="info_transaksi" type="checkbox"  name="perizinan[info_t]" {{ isset($user->perizinan['info_t']) ? 'checked=""' : '' }} >
              <label>Informasi transaksi</label>
            </fieldset>
            <ul id="info_transaksi">
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[cari_t]" {{ isset($user->perizinan['cari_t']) ? 'checked=""' : '' }}>
                    <label >Pencarian batch transaksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[tambah_item_t]" {{ isset($user->perizinan['tambah_item_t']) ? 'checked=""' : '' }}>
                    <label>Tambah item batch daftar transaksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[ubah_item_t]" {{ isset($user->perizinan['ubah_item_t']) ? 'checked=""' : '' }}>
                    <label>Ubah item batch daftar transaksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[hapus_item_t]" {{ isset($user->perizinan['hapus_item_t']) ? 'checked=""' : '' }}>
                    <label>Hapus item batch  daftar transaksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[berkas_t]" {{ isset($user->perizinan['berkas_t']) ? 'checked=""' : '' }}>
                    <label>Unggah dan edit berkas transaksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[simpan_t]" {{ isset($user->perizinan['simpan_t']) ? 'checked=""' : '' }}>
                    <label>Simpan batch untuk verifikasi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[ajukan_t]" {{ isset($user->perizinan['ajukan_t']) ? 'checked=""' : '' }}>
                    <label>Ajukan batch untuk verifikasi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_t]" {{ isset($user->perizinan['setuju_t']) ? 'checked=""' : '' }}>
                    <label>Persetujuan transaksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju2_t]" {{ isset($user->perizinan['setuju2_t']) ? 'checked=""' : '' }}>
                    <label>Persetujuan final transaksi</label>
                  </fieldset>
                </li>
            </ul>
            
          </div>
        </div>
        <div class="card-block">
          <h5>Notifikasi</h5>
          <div class="form-group skin skin-square" id="transaksi">
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_t]" {{ isset($user->perizinan['notif_setuju_t']) ? 'checked=""' : '' }}>
              <label>Permintaan Persetujuan transaksi</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju2_t]" {{ isset($user->perizinan['notif_setuju2_t']) ? 'checked=""' : '' }}>
              <label>Permintaan Persetujuan final transaksi</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_ubah_t]" {{ isset($user->perizinan['notif_ubah_t']) ? 'checked=""' : '' }}>
              <label>Perubahan status batch transaksi</label>
            </fieldset>
           </div>
        </div>
      </div>
    </div>
  </div>