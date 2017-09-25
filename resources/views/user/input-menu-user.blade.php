<div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <label class="text-primary" onclick="checkAll(this)" id="user"></label>
        </div>
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Aksi</h5>
          <div class="form-group skin skin-square" id="user">
            <fieldset>
              <input type="checkbox" name="perizinan[info_u]" {{ isset(old("perizinan")['info_u']) ? 'checked=""' : '' }}>
              <label>Informasi user</label>
            </fieldset>
            <ul>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[edit_u]" {{ isset(old("perizinan")['edit_u']) ? 'checked=""' : '' }}>
                  <label>Edit user</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[sdelete_u]" {{ isset(old("perizinan")['sdelete_u']) ? 'checked=""' : '' }}>
                  <label>Hapus user (soft delete)</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[pdelete_u]" {{ isset(old("perizinan")['pdelete_u']) ? 'checked=""' : '' }}>
                  <label>Hapus user (permanent delete)</label>
                </fieldset>
              </li>
              <li>
                <fieldset>
                  <input type="checkbox" name="perizinan[restore_u]" {{ isset(old("perizinan")['restore_u']) ? 'checked=""' : '' }}>
                  <label>Restore user</label>
                </fieldset>
              </li>
            </ul>
            <fieldset>
              <input type="checkbox" name="perizinan[tambah_u]" {{ isset(old("perizinan")['tambah_u']) ? 'checked=""' : '' }}>
              <label>Tambah user baru</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[jenis_u]" {{ isset(old("perizinan")['jenis_u']) ? 'checked=""' : '' }}>
              <label>Perizinan Jenis User</label>
            </fieldset>
            <ul>
              <li>
                <input type="checkbox" name="perizinan[edit_jenis]" {{ isset(old("perizinan")['edit_jenis']) ? 'checked=""' : '' }}>
                <label>Edit Jenis User</label>
              </li>
            </ul>
            <fieldset>
              <input type="checkbox" name="perizinan[tambah_jenis]" {{ isset(old("perizinan")['tambah_jenis']) ? 'checked=""' : '' }}>
              <label>Tambah Jenis User</label>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </div>