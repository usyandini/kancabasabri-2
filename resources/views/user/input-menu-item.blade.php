<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <label class="text-primary" onclick="checkAll(this)" id="item"></label>
      </div>
    </div>
    <div class="card-body">
      <div class="card-block">
        <h5>Aksi</h5>
        <div class="form-group skin skin-square" id="item">
          <fieldset >
            <input id="info_transaksi" type="checkbox"  name="perizinan[manajemen_i_t]" {{ isset(old('perizinan')['manajemen_i_t']) ? 'checked=""' : '' }} >
            <label>Manajemen Item Transaksi</label>
          </fieldset>
          <fieldset>
            <input type="checkbox" name="perizinan[manajemen_i]" {{ isset(old('perizinan')['manajemen_i']) ? 'checked=""' : '' }}>
            <label>Manajemen Item</label>
          </fieldset>
          <fieldset>
            <input type="checkbox" name="perizinan[manajemen_a_m]" {{ isset(old('perizinan')['manajemen_a_m']) ? 'checked=""' : '' }}>
            <label>Manajemen Alasan Menolak</label>
          </fieldset>
          <fieldset>
            <input type="checkbox" name="perizinan[manajemen_p_p]" {{ isset(old('perizinan')['manajemen_p_p']) ? 'checked=""' : '' }}>
            <label>Manajemen Program Prioritas</label>
          </fieldset>
          <fieldset>
            <input type="checkbox" name="perizinan[manajemen_a_RUPS]" {{ isset(old('perizinan')['manajemen_a_RUPS']) ? 'checked=""' : '' }}>
            <label>Manajemen Arahan RUPS</label>
          </fieldset>
        </div>
      </div>
    </div>
  </div>
</div>