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
            <input id="menu_trans" type="checkbox" name="perizinan[menu_transaksi]" {{ isset(old("perizinan")['menu_transaksi']) ? 'checked=""' : '' }} >
            <label>Menu transaksi</label>
          </fieldset>
          <div id="menu_trans">
            <ul style="margin-bottom: 0;">
              <li>
                <fieldset >
                  <input type="checkbox" name="perizinan[info_t]" {{ isset(old("perizinan")['info_t']) ? 'checked=""' : '' }} >
                  <label>Informasi transaksi</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[tambah_t]" {{ isset(old("perizinan")['tambah_t']) ? 'checked=""' : '' }}>
                  <label >Tambah batch transaksi</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[tambah_item_t]" {{ isset(old("perizinan")['tambah_item_t']) ? 'checked=""' : '' }}>
                  <label>Tambah item batch daftar transaksi</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[ubah_item_t]" {{ isset(old("perizinan")['ubah_item_t']) ? 'checked=""' : '' }}>
                  <label>Ubah item batch daftar transaksi</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[hapus_item_t]" {{ isset(old("perizinan")['hapus_item_t']) ? 'checked=""' : '' }}>
                  <label>Hapus item batch  daftar transaksi</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[berkas_t]" {{ isset(old("perizinan")['berkas_t']) ? 'checked=""' : '' }}>
                  <label>Unggah dan edit berkas transaksi</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[simpan_t]" {{ isset(old("perizinan")['simpan_t']) ? 'checked=""' : '' }}>
                  <label>Simpan batch untuk verifikasi</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[ajukan_t]" {{ isset(old("perizinan")['ajukan_t']) ? 'checked=""' : '' }}>
                  <label>Ajukan batch untuk verifikasi</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[setuju_t]" {{ isset(old("perizinan")['setuju_t']) ? 'checked=""' : '' }}>
                  <label>Persetujuan transaksi</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[setuju2_t]" {{ isset(old("perizinan")['setuju2_t']) ? 'checked=""' : '' }}>
                  <label>Persetujuan final transaksi</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[tanggal]" {{ isset(old("perizinan")['tanggal']) ? 'checked=""' : '' }}>
                  <label>Manajemen tanggal transaksi</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[report_mata_anggaran]" {{ isset(old("perizinan")['report_mata_anggaran']) ? 'checked=""' : '' }}>
                  <label>Report Realisasi Mata Anggaran</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[report_realisasi_anggaran]" {{ isset(old("perizinan")['report_realisasi_anggaran']) ? 'checked=""' : '' }}>
                  <label>Report Realisasi Transaksi</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[report_kasbank]" {{ isset(old("perizinan")['report_kasbank']) ? 'checked=""' : '' }}>
                  <label>Report Kas/Bank</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[reject_t]" {{ isset(old("perizinan")['reject_t']) ? 'checked=""' : '' }}>
                  <label>Reject History Transaksi</label>
                </fieldset>
              </li>
            </ul>
            <fieldset style="display: none">
                  <input type="checkbox" name="perizinan[cari_t]" checked="checked">
                  <label >Pencarian batch transaksi</label>
            </fieldset>
          </div>
          
        </div>
        <h5>Notifikasi</h5>
        <div class="form-group skin skin-square" id="transaksi">
          <fieldset >
            <input type="checkbox" name="perizinan[notif_setuju_t]" {{ isset(old("perizinan")['notif_setuju_t']) ? 'checked=""' : '' }}>
            <label>Permintaan Persetujuan transaksi</label>
          </fieldset>
          <fieldset >
            <input type="checkbox" name="perizinan[notif_setuju2_t]" {{ isset(old("perizinan")['notif_setuju2_t']) ? 'checked=""' : '' }}>
            <label>Permintaan Persetujuan final transaksi</label>
          </fieldset>
          <fieldset >
            <input type="checkbox" name="perizinan[notif_ubah_t]" {{ isset(old("perizinan")['notif_ubah_t']) ? 'checked=""' : '' }}>
            <label>Perubahan status batch transaksi</label>
          </fieldset>
        </div>
      </div>
    </div>
  </div>
</div>