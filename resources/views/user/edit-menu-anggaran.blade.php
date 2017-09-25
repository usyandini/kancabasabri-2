<div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <label class="text-primary" onclick="checkAll(this)" id="anggaran"></label>
        </div>
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Aksi</h5>
          <div class="form-group skin skin-square" id="anggaran">
            <fieldset>
              <input id="info_anggaran" type="checkbox" name="perizinan[info_a]" {{ isset($user->perizinan['info_a']) ? 'checked=""' : '' }}>
              <label>Informasi Anggaran dan Kegiatan</label>
            </fieldset>
            <ul id="info_anggaran">
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[cari_a]" {{ isset($user->perizinan['cari_a']) ? 'checked=""' : '' }}>
                    <label >Cari anggaran dan kegiatan</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[tambah_a]" {{ isset($user->perizinan['tambah_a']) ? 'checked=""' : '' }}>
                    <label>Tambah anggaran dan kegiatan baru</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[tambah_item_a]" {{ isset($user->perizinan['tambah_item_a']) ? 'checked=""' : '' }}>
                    <label>Tambah item daftar anggaran dan kegiatan</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[ubah_item_a]" {{ isset($user->perizinan['ubah_item_a']) ? 'checked=""' : '' }}>
                    <label>Ubah item anggaran dan kegiatan</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[hapus_item_a]" {{ isset($user->perizinan['hapus_item_a']) ? 'checked=""' : '' }}>
                    <label>Hapus item anggaran dan kegiatan</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[berkas_item_a]" {{ isset($user->perizinan['berkas_item_a']) ? 'checked=""' : '' }}>
                    <label>Unggah berkas item anggaran dan kegiatan</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[kirim_a]" {{ isset($user->perizinan['kirim_a']) ? 'checked=""' : '' }}>
                    <label>Kirim anggaran dan kegiatan</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_ia]" {{ isset($user->perizinan['setuju_ia']) ? 'checked=""' : '' }}>
                    <label>Persetujuan Kanit Kerja</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_iia]" {{ isset($user->perizinan['setuju_iia']) ? 'checked=""' : '' }}>
                    <label>Persetujuan Renbang</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_iiia]" {{ isset($user->perizinan['setuju_iiia']) ? 'checked=""' : '' }}>
                    <label>Persetujuan Direksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_iva]" {{ isset($user->perizinan['setuju_iva']) ? 'checked=""' : '' }}>
                    <label>Persetujuan Dekom</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_va]" {{ isset($user->perizinan['setuju_va']) ? 'checked=""' : '' }}>
                    <label>Persetujuan Ratek</label>
                  </fieldset>
                </li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_via]" {{ isset($user->perizinan['setuju_via']) ? 'checked=""' : '' }}>
                    <label>Persetujuan RUPS</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_viia]" {{ isset($user->perizinan['setuju_viia']) ? 'checked=""' : '' }}>
                    <label>Persetujuan FinRUPS</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_viiia]" {{ isset($user->perizinan['setuju_viiia']) ? 'checked=""' : '' }}>
                    <label>Persetujuan Risalah RUPS</label>
                  </fieldset>
                </li>
            </ul>    
            <fieldset>
              <input type="checkbox" name="perizinan[riwayat_a]" {{ isset($user->perizinan['riwayat_a']) ? 'checked=""' : '' }}>
              <label>Riwayat Anggaran Kegiatan</label>
            </fieldset>
          </div>
        </div>
        <div class="card-block">
          <h5>Notifikasi</h5>
          <div class="form-group skin skin-square" id="anggaran">
           <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_ia]" {{ isset($user->perizinan['notif_setuju_ia']) ? 'checked=""' : '' }}>
              <label>Permintaan Persetujuan Kanit Kerja</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_iia]" {{ isset($user->perizinan['notif_setuju_iia']) ? 'checked=""' : '' }}>
              <label>Permintaan Persetujuan Renbang</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_iiia]" {{ isset($user->perizinan['notif_setuju_iiia']) ? 'checked=""' : '' }}>
              <label>Permintaan Persetujuan Direksi</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_iva]" {{ isset($user->perizinan['notif_setuju_iva']) ? 'checked=""' : '' }}>
              <label>Permintaan Persetujuan Dekom</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_va]" {{ isset($user->perizinan['notif_setuju_va']) ? 'checked=""' : '' }}>
              <label>Permintaan Persetujuan Ratek</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_via]" {{ isset($user->perizinan['notif_setuju_via']) ? 'checked=""' : '' }}>
              <label>Permintaan Persetujuan RUPS</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_viia]" {{ isset($user->perizinan['notif_setuju_viia']) ? 'checked=""' : '' }}>
              <label>Permintaan Persetujuan FinRUPS</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_viiia]"{{ isset($user->perizinan['notif_setuju_viiia']) ? 'checked=""' : '' }}>
              <label>Permintaan Persetujuan Risalah RUPS</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_ubah_a]" {{ isset($user->perizinan['notif_ubah_a']) ? 'checked=""' : '' }}>
              <label>Perubahan Anggaran dan Kegiatan</label>
            </fieldset>
           </div>
        </div>
      </div>
    </div>
  </div>