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
              <input id="info_transaksi" type="checkbox"  name="perizinan[info_t]" {{ isset(old("perizinan")['info_t']) ? 'checked=""' : '' }} >
              <label>Informasi transaksi</label>
            </fieldset>
            <ul id="info_transaksi">
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[cari_t]" {{ isset(old("perizinan")['cari_t']) ? 'checked=""' : '' }}>
                    <label >Pencarian batch transaksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[insert_t]" {{ isset(old("perizinan")['insert_t']) ? 'checked=""' : '' }}>
                    <label>Insert poin daftar transaksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[update_t]" {{ isset(old("perizinan")['update_t']) ? 'checked=""' : '' }}>
                    <label>Update poin daftar transaksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[berkas_t]" {{ isset(old("perizinan")['berkas_t']) ? 'checked=""' : '' }}>
                    <label>Upload dan edit berkas transaksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[hapus_t]" {{ isset(old("perizinan")['hapus_t']) ? 'checked=""' : '' }}>
                    <label>Hapus poin daftar transaksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[submit_t]" {{ isset(old("perizinan")['submit_t']) ? 'checked=""' : '' }}>
                    <label>Submit batch untuk verifikasi</label>
                  </fieldset>
                </li>
            </ul>
            <fieldset>
              <input type="checkbox" name="perizinan[verifikasi_t]" {{ isset(old("perizinan")['verifikasi_t']) ? 'checked=""' : '' }}>
              <label>Verifikasi persetujuan transaksi</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[verifikasi2_t]" {{ isset(old("perizinan")['verifikasi2_t']) ? 'checked=""' : '' }}>
              <label>Verifikasi final transaksi</label>
            </fieldset>
          </div>
        </div>
        <div class="card-block">
          <h5>Notifikasi</h5>
          <div class="form-group skin skin-square" id="transaksi">
            <fieldset >
              <input type="checkbox" name="perizinan[notif_verifikasi_t]" value="1">
              <label>verifikasi persetujuan transaksi</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_verifikasi2_t]" value="1">
              <label>verifikasi final transaksi</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_update_t]" value="1">
              <label>Update status batch transaksi</label>
            </fieldset>
           </div>
        </div>
      </div>
    </div>
  </div>