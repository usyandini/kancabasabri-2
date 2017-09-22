<div class="row">
 <!--  @if (isset($jenis_user))
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
              <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif -->
  
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-card-center">Perizinan <code>Transaksi</code></h4>
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
              <input type="checkbox" id="tambah_transaksi" name="perizinan[tambahBatch_t]" {{ isset(old("perizinan")['tambahBatch_t']) ? 'checked=""' : '' }}> 
              <label>Tambah batch baru</label>
              <ul id="tambah_transaksi">
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[insert_t]" {{ isset(old("perizinan")['insert_t']) ? 'checked=""' : '' }}>
                    <label>Insert poin daftar transaksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[submit_t]" {{ isset(old("perizinan")['submit_t']) ? 'checked=""' : '' }}>
                    <label>Submit batch untuk verifikasi</label>
                  </fieldset>
                </li>
              </ul>
            </fieldset>

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
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-card-center">Perizinan <code>Anggaran</code></h4>
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
              <input id="info_anggaran" type="checkbox" name="perizinan[info_a]" {{ isset(old("perizinan")['info_a']) ? 'checked=""' : '' }}>
              <label>Informasi Anggaran Kegiatan</label>
            </fieldset>
            <ul id="info_anggaran">
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[cari_a]" {{ isset(old("perizinan")['cari_a']) ? 'checked=""' : '' }}>
                    <label >Cari anggaran</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[insert_a]" {{ isset(old("perizinan")['insert_a']) ? 'checked=""' : '' }}>
                    <label>Tambah anggaran</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[update_a]" {{ isset(old("perizinan")['update_a']) ? 'checked=""' : '' }}>
                    <label>Ubah anggaran</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[berkas_a]" {{ isset(old("perizinan")['berkas_a']) ? 'checked=""' : '' }}>
                    <label>Unggah berkas anggaran</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[simpan_a]" {{ isset(old("perizinan")['simpan_a']) ? 'checked=""' : '' }}>
                    <label>Simpan anggaran</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[kirim_a]" {{ isset(old("perizinan")['kirim_a']) ? 'checked=""' : '' }}>
                    <label>Kirim anggaran</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[hapus_a]" {{ isset(old("perizinan")['hapus_a']) ? 'checked=""' : '' }}>
                    <label>Hapus anggaran</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_ia]" {{ isset(old("perizinan")['setuju_ia']) ? 'checked=""' : '' }}>
                    <label>Persetujuan Kanit Kerja</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_iia]" {{ isset(old("perizinan")['setuju_iia']) ? 'checked=""' : '' }}>
                    <label>Persetujuan Renbang</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_iiia]" {{ isset(old("perizinan")['setuju_iiia']) ? 'checked=""' : '' }}>
                    <label>Persetujuan Direksi</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_iva]" {{ isset(old("perizinan")['setuju_iva']) ? 'checked=""' : '' }}>
                    <label>Persetujuan Dekom</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_va]" {{ isset(old("perizinan")['setuju_va']) ? 'checked=""' : '' }}>
                    <label>Persetujuan Ratek</label>
                  </fieldset>
                </li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_via]" {{ isset(old("perizinan")['setuju_via']) ? 'checked=""' : '' }}>
                    <label>Persetujuan RUPS</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_viia]" {{ isset(old("perizinan")['setuju_viia']) ? 'checked=""' : '' }}>
                    <label>Persetujuan FinRUPS</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[setuju_viiia]" {{ isset(old("perizinan")['setuju_viiia']) ? 'checked=""' : '' }}>
                    <label>Persetujuan Risalah RUPS</label>
                  </fieldset>
                </li>
            </ul>    
            <fieldset>
              <input type="checkbox" name="perizinan[riwayat_a]" {{ isset(old("perizinan")['riwayat_a']) ? 'checked=""' : '' }}>
              <label>Riwayat Anggaran Kegiatan</label>
            </fieldset>
          </div>
        </div>
        <div class="card-block">
          <h5>Notifikasi</h5>
          <div class="form-group skin skin-square" id="anggaran">
           <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_ia]" value="1">
              <label>verifikasi Persetujuan Kanit Kerja</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_iia]" value="1">
              <label>verifikasi Persetujuan Renbang</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_iiia]" value="1">
              <label>verifikasi Persetujuan Direksi</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_iva]" value="1">
              <label>verifikasi Persetujuan Dekom</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_va]" value="1">
              <label>verifikasi Persetujuan Ratek</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_via]" value="1">
              <label>verifikasi Persetujuan RUPS</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_viia]" value="1">
              <label>verifikasi Persetujuan FinRUPS</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_viiia]" value="1">
              <label>verifikasi Persetujuan RIsalah RUPS</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_setuju_ixa]" value="1">
              <label>Anggaran Disetujui Persetujuan</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_tolak_a]" value="1">
              <label>Penolakan Persetujuan</label>
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