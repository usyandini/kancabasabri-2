<div class="row">
  @if (!isset($jenis_user))
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
  @endif
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
              <input type="checkbox" name="perizinan[info-t]" {{ isset(old("perizinan")['info-t']) ? 'checked=""' : '' }} >
              <label>Informasi transaksi</label>
              <fieldset>
                <input type="checkbox" name="perizinan[tambahBatch-t]" {{ isset(old("perizinan")['tambahBatch-t']) ? 'checked=""' : '' }}> 
                <label>Tambah batch baru</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[verifikasi-t]" {{ isset(old("perizinan")['verifikasi-t']) ? 'checked=""' : '' }}>
                <label>Verifikasi persetujuan transaksi</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[verifikasi2-t]" {{ isset(old("perizinan")['verifikasi2-t']) ? 'checked=""' : '' }}>
                <label>Verifikasi final transaksi</label>
              </fieldset>
            </div>
            <h5>Sub-menu</h5>
            <div class="form-group skin skin-square">
              <fieldset>
                <input type="checkbox" name="perizinan[insert-t]" {{ isset(old("perizinan")['insert-t']) ? 'checked=""' : '' }}>
                <label>Insert poin daftar transaksi</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[update-t]" {{ isset(old("perizinan")['update-t']) ? 'checked=""' : '' }}>
                <label>Update poin daftar transaksi</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[hapus-t]" {{ isset(old("perizinan")['hapus-t']) ? 'checked=""' : '' }}>
                <label>Hapus poin daftar transaksi</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[cari-t]" {{ isset(old("perizinan")['cari-t']) ? 'checked=""' : '' }}>
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
          <h4 class="card-title" id="basic-layout-card-center">Perizinan Menu <code>Anggaran Kegiatan</code></h4>
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
                <input type="checkbox" name="perizinan[info-a]" {{ isset(old("perizinan")['info-a']) ? 'checked=""' : '' }}>
                <label>Informasi Anggaran</label>
                <fieldset>
                  <input type="checkbox" name="perizinan[riwayat-a]" {{ isset(old("perizinan")['riwayat-a']) ? 'checked=""' : '' }}>
                  <label>Riwayat Anggaran</label>
                </fieldset>
                <fieldset>
                  <input type="checkbox" name="perizinan[persetujuan-a]" {{ isset(old("perizinan")['persetujuan-a']) ? 'checked=""' : '' }}>
                  <label>Persetujuan Rembang</label>
                </fieldset>
                <fieldset>
                  <input type="checkbox" name="perizinan[persetujuan2-a]" {{ isset(old("perizinan")['persetujuan2-a']) ? 'checked=""' : '' }}>
                  <label>Persetujuan Manajemen</label>
                </fieldset>
              </div>
              {{-- <h5>Sub-menu</h5>
              <div class="form-group skin skin-square">
                <fieldset>
                  <input type="checkbox" name="perizinan[edit-u]">
                  <label>Edit user</label>
                </fieldset>
                <fieldset>
                  <input type="checkbox" name="perizinan[sdelete-u]">
                  <label>Hapus user (soft delete)</label>
                </fieldset>
                <fieldset>
                  <input type="checkbox" name="perizinan[pdelete-u]">
                  <label>Hapus user (permanent delete)</label>
                </fieldset>
                <fieldset>
                  <input type="checkbox" name="perizinan[restore-u]">
                  <label>Restore user</label>
                </fieldset>
              </div> --}}
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
                  <input type="checkbox" name="perizinan[info-u]" {{ isset(old("perizinan")['info-u']) ? 'checked=""' : '' }}>
                  <label>Informasi user</label>
                  <fieldset>
                    <input type="checkbox" name="perizinan[tambah-u]" {{ isset(old("perizinan")['tambah-u']) ? 'checked=""' : '' }}>
                    <label>Tambah user baru</label>
                  </fieldset>
                  <fieldset>
                    <input type="checkbox" name="perizinan[jenis-u]" {{ isset(old("perizinan")['jenis-u']) ? 'checked=""' : '' }}>
                    <label>Perizinan Jenis User</label>
                  </fieldset>
                </div>
                <h5>Sub-menu</h5>
                <div class="form-group skin skin-square">
                  <fieldset>
                    <input type="checkbox" name="perizinan[edit-u]" {{ isset(old("perizinan")['edit-u']) ? 'checked=""' : '' }}>
                    <label>Edit user</label>
                  </fieldset>
                  <fieldset>
                    <input type="checkbox" name="perizinan[sdelete-u]" {{ isset(old("perizinan")['sdelete-u']) ? 'checked=""' : '' }}>
                    <label>Hapus user (soft delete)</label>
                  </fieldset>
                  <fieldset>
                    <input type="checkbox" name="perizinan[pdelete-u]" {{ isset(old("perizinan")['pdelete-u']) ? 'checked=""' : '' }}>
                    <label>Hapus user (permanent delete)</label>
                  </fieldset>
                  <fieldset>
                    <input type="checkbox" name="perizinan[restore-u]" {{ isset(old("perizinan")['restore-u']) ? 'checked=""' : '' }}>
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