<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-card-center">Jenis User (preset)</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      </div>
      <div class="card-body">
        <div class="card-block">
          <div class="form-group">
            <select class="select2 form-control" name="cabang">
              <option selected disabled="">Jenis User</option>
              <option>Administrator</option>
              <option>Kasimin</option>
              <option>Akutansi</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-card-center">Perizinan Menu <code>Transaksi</code></h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <a href="">deselect all</a>
        </div>
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Menu utama</h5>
          <div class="form-group skin skin-square">
            <fieldset>
              <input type="checkbox" name="perizinan[info-t]" value="1">
              <label>Informasi transaksi</label>
              <fieldset>
                <input type="checkbox" name="perizinan[tambahBatch-t]" value="1">
                <label>Tambah batch baru</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[verifikasi-t]" value="1">
                <label>Verifikasi persetujuan transaksi</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[verifikasi2-t]" value="1">
                <label>Verifikasi final transaksi</label>
              </fieldset>
            </div>
            <h5>Sub-menu</h5>
            <div class="form-group skin skin-square">
              <fieldset>
                <input type="checkbox" name="perizinan[insert-t]" value="1">
                <label>Insert poin daftar transaksi</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[update-t]" value="1">
                <label>Update poin daftar transaksi</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[hapus-t]" value="1">
                <label>Hapus poin daftar transaksi</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[cari-t]" value="1">
                <label>Pencarian batch transaksi</label>
              </fieldset>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title" id="basic-layout-card-center">Perizinan Menu <code>Manajemen User</code></h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <a href="">deselect all</a>
          </div>
        </div>
        <div class="card-body">
          <div class="card-block">
            <h5>Menu utama</h5>
            <div class="form-group skin skin-square">
              <fieldset>
                <input type="checkbox" name="perizinan[info-u]" value="">
                <label>Informasi user</label>
                <fieldset>
                  <input type="checkbox" name="perizinan[tambah-u]" value="">
                  <label>Tambah user baru</label>
                </fieldset>
                <fieldset>
                  <input type="checkbox" name="perizinan[jenis-u]" value="">
                  <label>Perizinan Jenis User</label>
                </fieldset>
              </div>
              <h5>Sub-menu</h5>
              <div class="form-group skin skin-square">
                <fieldset>
                  <input type="checkbox" name="perizinan[edit-u]" value="">
                  <label>Edit user</label>
                </fieldset>
                <fieldset>
                  <input type="checkbox" name="perizinan[sdelete-u]" value="">
                  <label>Hapus user (soft delete)</label>
                </fieldset>
                <fieldset>
                  <input type="checkbox" name="perizinan[pdelete-u]" value="">
                  <label>Hapus user (permanent delete)</label>
                </fieldset>
                <fieldset>
                  <input type="checkbox" name="perizinan[restore-u]" value="">
                  <label>Restore user</label>
                </fieldset>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-block">
              <div class="form-actions right">
                <a href="{{ url('user') }}" class="btn btn-warning mr-1">
                  <i class="ft-x"></i> Kembali
                </a>    
                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-check-square-o"></i> Simpan
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>