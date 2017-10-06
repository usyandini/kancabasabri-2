<div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <label class="text-primary" onclick="checkAll(this)" id="pelaporan"></label>
        </div>
      </div>
      <div class="card-body">
        <div class="card-block">
          <h5>Aksi</h5>
          <div class="form-group skin skin-square" id="pelaporan">
            <fieldset >
              <input id="pelaporan_anggaran" type="checkbox"  name="perizinan[pelaporan_anggaran]" {{ isset($user->perizinan['pelaporan_anggaran']) ? 'checked=""' : '' }} >
              <label>Pelaporan Anggaran Kegiatan</label>
            </fieldset>
            <ul id="pelaporan_anggaran">
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[cari_pelaporan_anggaran]" {{ isset($user->perizinan['cari_pelaporan_anggaran']) ? 'checked=""' : '' }}>
                    <label >Pencarian Pelaporan Anggaran Kegiatan</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[tambah_pelaporan_anggaran]" {{ isset($user->perizinan['tambah_pelaporan_anggaran']) ? 'checked=""' : '' }}>
                    <label >Tambah Pelaporan Anggaran Kegiatan</label>
                  </fieldset>
                </li>
            </ul>
            <fieldset>
              <input id="pelaporan_a_RUPS" type="checkbox" name="perizinan[pelaporan_a_RUPS]" {{ isset($user->perizinan['pelaporan_a_RUPS']) ? 'checked=""' : '' }}>
              <label>Arahan RUPS</label>
            </fieldset>
            <ul id="pelaporan_a_RUPS">
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[cari_pelaporan_a_RUPS]" {{ isset($user->perizinan['cari_pelaporan_a_RUPS']) ? 'checked=""' : '' }}>
                    <label >Pencarian Arahan RUPS</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[tambah_pelaporan_a_RUPS]" {{ isset($user->perizinan['tambah_pelaporan_a_RUPS']) ? 'checked=""' : '' }}>
                    <label >Tambah Arahan RUPS</label>
                  </fieldset>
                </li>
            </ul>
            <fieldset>
              <input id="pelaporan_usulan_p_p" type="checkbox" name="perizinan[pelaporan_usulan_p_p]" {{ isset($user->perizinan['pelaporan_usulan_p_p']) ? 'checked=""' : '' }}>
              <label>Usulan Program Prioritas</label>
            </fieldset>
            <ul id="pelaporan_usulan_p_p">
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[cari_pelaporan_usulan_p_p]" {{ isset($user->perizinan['cari_pelaporan_usulan_p_p']) ? 'checked=""' : '' }}>
                    <label >Pencarian Usulan Program Prioritas</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[tambah_pelaporan_usulan_p_p]" {{ isset($user->perizinan['tambah_pelaporan_usulan_p_p']) ? 'checked=""' : '' }}>
                    <label >Tambah Usulan Program Prioritas</label>
                  </fieldset>
                </li>
            </ul>
            <fieldset>
              <input type="checkbox" name="perizinan[pelaporan_tindak_lanjut]" {{ isset($user->perizinan['pelaporan_tindak_lanjut']) ? 'checked=""' : '' }}>
              <label>Tindak Lanjut Temuan</label>
            </fieldset>
            <fieldset>
              <input id="form_master"type="checkbox" name="perizinan[form_master]" {{ isset($user->perizinan['form_master']) ? 'checked=""' : '' }}>
              <label>Form Master</label>
            </fieldset>
            <ul id="form_master">
                <li>
                  <fieldset>
                    <input id="master_pelaporan_anggaran" type="checkbox" name="perizinan[master_pelaporan_anggaran]" {{ isset($user->perizinan['master_pelaporan_anggaran']) ? 'checked=""' : '' }}>
                    <label >Pelaporan Anggaran Kegiatan</label>
                  </fieldset>
                  <ul id="master_pelaporan_anggaran">
                      <li>
                        <fieldset>
                          <input type="checkbox" name="perizinan[cari_master_pelaporan_anggaran]" {{ isset($user->perizinan['cari_master_pelaporan_anggaran']) ? 'checked=""' : '' }}>
                          <label >Pencarian Usulan Program Prioritas</label>
                        </fieldset>
                      </li>
                      <li>
                        <fieldset>
                          <input type="checkbox" name="perizinan[tambah_master_pelaporan_anggaran]" {{ isset($user->perizinan['tambah_master_pelaporan_anggaran']) ? 'checked=""' : '' }}>
                          <label >Tambah Usulan Program Prioritas</label>
                        </fieldset>
                      </li>
                  </ul>
                </li>
                <li>
                  <fieldset>
                    <input id="master_arahan_a_RUPS" type="checkbox" name="perizinan[master_arahan_a_RUPS]" {{ isset($user->perizinan['master_arahan_a_RUPS']) ? 'checked=""' : '' }}>
                    <label>Arahan RUPS</label>
                  </fieldset>
                  <ul id="master_arahan_a_RUPS">
                      <li>
                        <fieldset>
                          <input type="checkbox" name="perizinan[cari_master_arahan_a_RUPS]" {{ isset($user->perizinan['cari_master_arahan_a_RUPS']) ? 'checked=""' : '' }}>
                          <label >Pencarian Arahan RUPS</label>
                        </fieldset>
                      </li>
                      <li>
                        <fieldset>
                          <input type="checkbox" name="perizinan[tambah_master_arahan_a_RUPS]" {{ isset($user->perizinan['tambah_master_arahan_a_RUPS']) ? 'checked=""' : '' }}>
                          <label >Tambah Arahan RUPS</label>
                        </fieldset>
                      </li>
                  </ul>
                </li>
                <li>
                  <fieldset>
                    <input id="master_usulan_p_p" type="checkbox" name="perizinan[master_usulan_p_p]" {{ isset($user->perizinan['master_usulan_p_p']) ? 'checked=""' : '' }}>
                    <label>Usulan Program Prioritas</label>
                  </fieldset>
                  <ul id="master_usulan_p_p">
                      <li>
                        <fieldset>
                          <input type="checkbox" name="perizinan[cari_master_usulan_p_p]" {{ isset($user->perizinan['cari_master_usulan_p_p']) ? 'checked=""' : '' }}>
                          <label >Pencarian Usulan Program Prioritas</label>
                        </fieldset>
                      </li>
                      <li>
                        <fieldset>
                          <input type="checkbox" name="perizinan[tambah_master_usulan_p_p]" {{ isset($user->perizinan['tambah_master_usulan_p_p']) ? 'checked=""' : '' }}>
                          <label >Tambah Usulan Program Prioritas</label>
                        </fieldset>
                      </li>
                  </ul>
                </li>
            </ul>
          </div>

        </div>
        <div class="card-block">
          <h5>Notifikasi</h5>
          <div class="form-group skin skin-square" id="pelaporan">
            <fieldset >
              <input type="checkbox" name="perizinan[notif_ajukan_p_a]" {{ isset($user->perizinan['notif_ajukan_p_a']) ? 'checked=""' : '' }}>
              <label>Pengajuan Pelaporan Anggaran Kegiatan</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_ajukan_a_RUPS]" {{ isset($user->perizinan['notif_ajukan_a_RUPS']) ? 'checked=""' : '' }}>
              <label>Pengajuan Arahan RUPS</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[notif_ajukan_usulan_p_p]" {{ isset($user->perizinan['notif_ajukan_usulan_p_p']) ? 'checked=""' : '' }}>
              <label>Pengajuan Usulan Program Prioritas</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_ajukan_master_p_a]" {{ isset($user->perizinan['notif_ajukan_master_p_a']) ? 'checked=""' : '' }}>
              <label>Pengajuan Form Master Pelaporan Anggaran Kegiatan</label>
            </fieldset>
            <fieldset >
              <input type="checkbox" name="perizinan[notif_ajukan_master_a_RUPS]" {{ isset($user->perizinan['notif_ajukan_master_a_RUPS']) ? 'checked=""' : '' }}>
              <label>Pengajuan Form Master Arahan RUPS</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[notif_ajukan_master_usulan_p_p]" {{ isset($user->perizinan['notif_ajukan_master_usulan_p_p']) ? 'checked=""' : '' }}>
              <label>Pengajuan Form Master Usulan Program Prioritas</label>
            </fieldset>
           </div>
        </div>
      </div>
    </div>
  </div>