<div class="row">
  @if (isset($jenis_user))
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-card-center">Jenis User (preset)</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      </div>
      <div class="card-body">
        <div class="card-block">
          <div class="form-group">
            <select class="select2 form-control" name="jenis_user" id="jenis_user">
              <option selected disabled="">Jenis User</option>
              @foreach ($jenis_user as $jenis)
              <option value="{{ $jenis->id }}" {{ $jenis->id == $user->jenis_user ? 'selected=""' : '' }}>{{ $jenis->nama }}</option>
              @endforeach
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
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Menu utama</h5>
          <div class="form-group skin skin-square">
            <fieldset>
              <input type="checkbox" name="perizinan[info_t]" {{ isset($user->perizinan['info_t']) ? 'checked=""' : '' }}>
              <label>Informasi transaksi</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[tambahBatch_t]" {{ isset($user->perizinan['tambahBatch_t']) ? 'checked=""' : '' }}>
              <label>Tambah batch baru</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[verifikasi_t]" {{ isset($user->perizinan['verifikasi_t']) ? 'checked=""' : '' }}>
              <label>Verifikasi persetujuan transaksi</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[verifikasi2_t]" {{ isset($user->perizinan['verifikasi2_t']) ? 'checked=""' : '' }}>
              <label>Verifikasi final transaksi</label>
            </fieldset>
          </div>
          <h5>Sub-menu</h5>
          <div class="form-group skin skin-square">
            <fieldset>
              <input type="checkbox" name="perizinan[insert_t]" {{ isset($user->perizinan['insert_t']) ? 'checked=""' : '' }}>
              <label>Insert poin daftar transaksi</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[update_t]" {{ isset($user->perizinan['update_t']) ? 'checked=""' : '' }}>
              <label>Update poin daftar transaksi</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[hapus_t]" {{ isset($user->perizinan['hapus_t']) ? 'checked=""' : '' }}>
              <label>Hapus poin daftar transaksi</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[cari_t]" {{ isset($user->perizinan['cari_t']) ? 'checked=""' : '' }}>
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
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Menu utama</h5>
          <div class="form-group skin skin-square">
            <fieldset>
              <input type="checkbox" name="perizinan[info_u]" {{ isset($user->perizinan['info_u']) ? 'checked=""' : '' }}>
              <label>Informasi user</label>
              <fieldset>
                <input type="checkbox" name="perizinan[tambah_u]" {{ isset($user->perizinan['tambah_u']) ? 'checked=""' : '' }}> 
                <label>Tambah user</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[jenis_u]" {{ isset($user->perizinan['jenis_u']) ? 'checked=""' : '' }}> 
                <label>Perizinan Jenis User</label>
              </fieldset>
            </div>
            <h5>Sub-menu</h5>
            <div class="form-group skin skin-square">
              <fieldset>
                <input type="checkbox" name="perizinan[edit_u]" {{ isset($user->perizinan['edit_u']) ? 'checked=""' : '' }}>
                <label>Edit user</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[sdelete_u]" {{ isset($user->perizinan['sdelete_u']) ? 'checked=""' : '' }}>
                <label>Hapus user (soft delete)</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[pdelete_u]" {{ isset($user->perizinan['pdelete_u']) ? 'checked=""' : '' }}>
                <label>Hapus user (permanent delete)</label>
              </fieldset>
              <fieldset>
                <input type="checkbox" name="perizinan[restore_u]" {{ isset($user->perizinan['restore_u']) ? 'checked=""' : '' }}>
                <label>Restore user</label>
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
        </div>
        <div class="card-body">
          <div class="card-block">
            <h5>Menu utama</h5>
            <div class="form-group skin skin-square">
              <fieldset>
                <input type="checkbox" name="perizinan[info_a]" {{ isset($user->perizinan['info_a']) ? 'checked=""' : '' }}>
                <label>Informasi Anggaran</label>
                <fieldset>
                  <input type="checkbox" name="perizinan[riwayat_a]" {{ isset($user->perizinan['riwayat_a']) ? 'checked=""' : '' }}>
                  <label>Riwayat Anggaran</label>
                </fieldset>
                <fieldset>
                  <input type="checkbox" name="perizinan[persetujuan_a]" {{ isset($user->perizinan['persetujuan_a']) ? 'checked=""' : '' }}>
                  <label>Persetujuan Rembang</label>
                </fieldset>
                <fieldset>
                  <input type="checkbox" name="perizinan[persetujuan2_a]" {{ isset($user->perizinan['persetujuan2_a']) ? 'checked=""' : '' }}>
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