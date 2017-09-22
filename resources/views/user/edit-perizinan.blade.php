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
        <h4 class="card-title" id="basic-layout-card-center">Perizinan <code>Dropping</code></h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <label class="text-primary" onclick="checkAll(this)" id="dropping"></label>
        </div>
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Menu utama</h5>
          <div class="form-group skin skin-square" id="dropping">
            <fieldset>
              <input type="checkbox" name="perizinan[info_d]" {{ isset($user->perizinan['info_d']) ? 'checked=""' : '' }}>
              <label>Informasi dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[tarikTunai_d]" {{ isset($user->perizinan['tarikTunai_d']) ? 'checked=""' : '' }} >
              <label>Melihat halaman tarik tunai dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[penyesuaian_d]" {{ isset($user->perizinan['penyesuaian_d']) ? 'checked=""' : '' }} >
              <label>Melihat halaman penyesuaian dropping</label>
            </fieldset>
            </div>
          <h5>Sub-menu</h5>
          <div class="form-group skin skin-square" id="dropping">
            <fieldset>
              <input type="checkbox" name="perizinan[insertTT_d]" {{ isset($user->perizinan['insertTT_d']) ? 'checked=""' : '' }}>
              <label>Input tarik tunai</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[insertPD_d]" {{ isset($user->perizinan['insertPD_d']) ? 'checked=""' : '' }}>
              <label>Input penyesuaian dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[verifikasiTT_d]" {{ isset($user->perizinan['verifikasiTT_d']) ? 'checked=""' : '' }}>
              <label>Verifikasi tarik tunai</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[verifikasiPD_d]" {{ isset($user->perizinan['verifikasiPD_d']) ? 'checked=""' : '' }}>
              <label>Verifikasi penyesuaian dropping</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[verifikasiPD2_d]" {{ isset($user->perizinan['verifikasiPD2_d']) ? 'checked=""' : '' }}>
              <label>Verifikasi final penyesuaian dropping</label>
            </fieldset>  
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-card-center">Perizinan <code>Transaksi</code></h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <label class="text-primary" onclick="checkAll(this)" id="transaksi">Centang semua</label>
        </div>
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Menu utama</h5>
          <div class="form-group skin skin-square" id="transaksi">
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
          <div class="form-group skin skin-square" id="transaksi">
            <fieldset>
              <input type="checkbox" name="perizinan[insert_t]" {{ isset($user->perizinan['insert_t']) ? 'checked=""' : '' }}>
              <label>Insert poin daftar transaksi</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[update_t]" {{ isset($user->perizinan['update_t']) ? 'checked=""' : '' }}>
              <label>Update poin daftar transaksi</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[berkas_t]" {{ isset($user->perizinan['berkas_t']) ? 'checked=""' : '' }}>
              <label>Upload dan edit berkas transaksi</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[hapus_t]" {{ isset($user->perizinan['hapus_t']) ? 'checked=""' : '' }}>
              <label>Hapus poin daftar transaksi</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[cari_t]" {{ isset($user->perizinan['cari_t']) ? 'checked=""' : '' }}>
              <label>Pencarian batch transaksi</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[submit_t]" {{ isset($user->perizinan['submit_t']) ? 'checked=""' : '' }}>
              <label>Submit batch untuk verifikasi</label>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-card-center">Perizinan <code>Anggaran Kegiatan</code></h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <label class="text-primary" onclick="checkAll(this)" id="anggaran">Centang semua</label>
        </div>
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Menu utama</h5>
          <div class="form-group skin skin-square" id="anggaran">
            <fieldset>
              <input type="checkbox" name="perizinan[info_a]" {{ isset($user->perizinan['info_a']) ? 'checked=""' : '' }}>
              <label>Informasi Anggaran</label>
            </fieldset>
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
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-card-center">Perizinan <code>Manajemen User</code></h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <label class="text-primary" onclick="checkAll(this)" id="user">Centang semua</label>
        </div>
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Menu utama</h5>
          <div class="form-group skin skin-square" id="user">
            <fieldset>
              <input type="checkbox" name="perizinan[info_u]" {{ isset($user->perizinan['info_u']) ? 'checked=""' : '' }}>
              <label>Informasi user</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[tambah_u]" {{ isset($user->perizinan['tambah_u']) ? 'checked=""' : '' }}> 
              <label>Tambah user</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[jenis_u]" {{ isset($user->perizinan['jenis_u']) ? 'checked=""' : '' }}> 
              <label>Perizinan Jenis User</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[tambah_jenis]" {{ isset($user->perizinan['tambah_jenis']) ? 'checked=""' : '' }}>
              <label>Tambah Jenis User</label>
            </fieldset>
          </div>
          <h5>Sub-menu</h5>
          <div class="form-group skin skin-square" id="user">
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
            <fieldset>
              <input type="checkbox" name="perizinan[edit_jenis]" {{ isset($user->perizinan['edit_jenis']) ? 'checked=""' : '' }}>
              <label>Edit Jenis User</label>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-card-center">Perizinan <code>Manajemen Item</code></h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <label class="text-primary" onclick="checkAll(this)" id="item"></label>
        </div>
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Menu utama</h5>
          <div class="form-group skin skin-square" id="item">
            <fieldset>
              <input type="checkbox" name="perizinan[info_i]" {{ isset($user->perizinan['info_i']) ? 'checked=""' : '' }}>
              <label>Manajemen kombinasi item</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[listAlasan_r]" {{ isset($user->perizinan['listAlasan_r']) ? 'checked=""' : '' }}>
              <label>Manajemen alasan penolakan</label>
            </fieldset>
          </div>
          <h5>Sub-menu</h5>
          <div class="form-group skin skin-square" id="item">
            <fieldset>
              <input type="checkbox" name="perizinan[tambah_i]" {{ isset($user->perizinan['tambah_i']) ? 'checked=""' : '' }}>
              <label>Tambah item</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[delete_i]" {{ isset($user->perizinan['delete_i']) ? 'checked=""' : '' }}>
              <label>Hapus item</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[edit_i]" {{ isset($user->perizinan['edit_i']) ? 'checked=""' : '' }}>
              <label>Edit item</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[jenis_i]" {{ isset($user->perizinan['jenis_i']) ? 'checked=""' : '' }}>
              <label>Tambah jenis anggaran</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[kelompok_i]" {{ isset($user->perizinan['kelompok_i']) ? 'checked=""' : '' }}>
              <label>Tambah kelompok anggaran</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[pos_i]" {{ isset($user->perizinan['pos_i']) ? 'checked=""' : '' }}>
              <label>Tambah pos anggaran</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[simpan_i]" {{ isset($user->perizinan['simpan_i']) ? 'checked=""' : '' }}>
              <label>Simpan item baru</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[tambah_r]" {{ isset($user->perizinan['tambah_r']) ? 'checked=""' : '' }}>
              <label>Tambah alasan</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[delete_r]" {{ isset($user->perizinan['delete_r']) ? 'checked=""' : '' }}>
              <label>Hapus alasan</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[edit_r]" {{ isset($user->perizinan['edit_r']) ? 'checked=""' : '' }}>
              <label>Edit alasan</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[simpan_r]" {{ isset($user->perizinan['simpan_r']) ? 'checked=""' : '' }}>
              <label>Simpan alasan baru</label>
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