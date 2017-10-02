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
              <input id="info_transaksi" type="checkbox"  name="perizinan[pelaporan_anggaran]" {{ isset($user->perizinan['pelaporan_anggaran']) ? 'checked=""' : '' }} >
              <label>Pelaporan Anggaran Kegiatan</label>
            </fieldset>
            <fieldset>
              <input type="checkbox" name="perizinan[pelaporan_a_RUPS]" {{ isset($user->perizinan['pelaporan_a_RUPS']) ? 'checked=""' : '' }}>
              <label>Arahan RUPS</label>
            </fieldset>
            <fieldset>
              <input id="form_master"type="checkbox" name="perizinan[form_master]" {{ isset($user->perizinan['form_master']) ? 'checked=""' : '' }}>
              <label>Form Master</label>
            </fieldset>
            <ul id="form_master">
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[master_pelaporan_anggaran]" {{ isset($user->perizinan['master_pelaporan_anggaran']) ? 'checked=""' : '' }}>
                    <label >Pelaporan Anggaran Kegiatan</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[master_arahan_a_RUPS]" {{ isset($user->perizinan['master_arahan_a_RUPS']) ? 'checked=""' : '' }}>
                    <label>Arahan RUPS</label>
                  </fieldset>
                </li>
                <li>
                  <fieldset>
                    <input type="checkbox" name="perizinan[master_usulan_p_p]" {{ isset($user->perizinan['master_usulan_p_p']) ? 'checked=""' : '' }}>
                    <label>Usulan Program Prioritas</label>
                  </fieldset>
                </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>