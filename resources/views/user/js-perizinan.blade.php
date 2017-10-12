<script type="text/javascript">
  var perizinan = ["info_t","info_a","info_u","jenis_u","form_master",
  "pelaporan_anggaran","pelaporan_a_RUPS","pelaporan_usulan_p_p","pelaporan_tindak_lanjut",
  "master_pelaporan_anggaran","master_arahan_a_RUPS","master_usulan_p_p"];
  var input_izin = ["info_transaksi","info_anggaran","info_user","jenis_user","form_master",
  "pelaporan_anggaran","pelaporan_a_RUPS","pelaporan_usulan_p_p","pelaporan_tindak_lanjut",
  "master_pelaporan_anggaran","master_arahan_a_RUPS","master_usulan_p_p"];
  $(document).ready(function() {

    $('select[name="cabang"]').on('change', function() {
      if ($(this).val() !== '00') {
        $('select[name="divisi"]').prop("disabled", true);
        $('select[name="divisi"] option:selected').attr("selected",null);
        $('select[name="divisi"] option[value=00]').attr("selected","selected");
        $('select[name="divisi"]').val('00');
        $('#select2-divisi-container').attr("title","");
        $('#select2-divisi-container').html("");
        // alert($('select[name="divisi"]').val());
        toastr.info("Divisi tidak perlu dipilih jika Kantor Cabang yang dipilih adalah <b>Kantor pusat</b>.", "Kantor Cabang dipilih", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
      } else {
        $('select[name="divisi"]').prop("disabled", false);
      }
    });

    $('select[name="jenis_user"]').on('change', function(){
      $.post("{{ url('/jenis_user/handle') }}", {_token: '{{ csrf_token() }}', id: $(this).val()}, function(e) {
        $('input[type="checkbox"]').iCheck('uncheck');
        $.each(e, function(e) {
          $('input[name="perizinan[' + e + ']"]').iCheck('check');
        })
        calibrateCentang()
      });
    });

    // window.checkDivCab();

    @if (session('success'))
    toastr.info("{!! session('success') !!}", "Update Berhasil", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
    @endif
    @if (isset($profile_edit))
    $('input[type="checkbox"]').iCheck('disable')
    $('select[name="jenis_user"]').prop('disabled', true)
    $('input[name="profile_edit"]').val('true');

    $('label#dropping').html('')
    $('label#pengajuan').html('')
    $('label#transaksi').html('')
    $('label#anggaran').html('')
    $('label#notifikasi').html('')
    $('label#unit_kerja').html('')
    $('label#pelaporan').html('')
    $('label#user').html('')
    $('label#item').html('')
    $('input[type="radio"]').iCheck('disable')
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-red',
      radioClass: 'iradio_square-red',
        increaseArea: '20%' // optional
      });
    @else
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-red',
      radioClass: 'iradio_square-red',
        increaseArea: '20%' // optional
      });

    $('input[name="as_ldap"]').on('ifClicked', function (event) {
      changeLDAP(this.value);
    });
    calibrateCentang();
    @endif

    $('input[type="checkbox"]').on('ifChecked', function (event) {
      calibrateCentang();
    });
    $('input[type="checkbox"]').on('ifUnchecked', function (event) {
      calibrateCentang();
    });

    for(i=0;i<perizinan.length;i++){
      $('input[name="perizinan['+perizinan[i]+']"]').on('ifClicked', function (event) {
        checkChild(this) 
      });
    }
    
  })


  function calibrateCentang() {
    for(i=0;i<input_izin.length;i++){
      if($('#'+input_izin[i]+' input').filter(':checked').length == 0){
        $('input[name="perizinan['+perizinan[i]+']"]').iCheck('uncheck');
      }else{
        $('input[name="perizinan['+perizinan[i]+']"]').iCheck('check');
      }
    }

    if ($('#unit_kerja input').filter(':checked').length > $('#unit_kerja input').length/2) {
      $('label#unit_kerja').html('Hilangkan centang')
    } else {
      $('label#unit_kerja').html('Centang semua')
    }

    if ($('#dropping input').filter(':checked').length > $('#dropping input').length/2) {
      $('label#dropping').html('Hilangkan centang')
    } else {
      $('label#dropping').html('Centang semua')
    }

    if ($('#pengajuan input').filter(':checked').length > $('#pengajuan input').length/2) {
      $('label#pengajuan').html('Hilangkan centang')
    } else {
      $('label#pengajuan').html('Centang semua')
    }

    if ($('#transaksi input').filter(':checked').length > $('#transaksi input').length/2) {
      $('label#transaksi').html('Hilangkan centang')
    } else {
      $('label#transaksi').html('Centang semua')
    }

    if ($('#anggaran input').filter(':checked').length > $('#anggaran input').length/2) {
      $('label#anggaran').html('Hilangkan centang')
    } else {
      $('label#anggaran').html('Centang semua')
    }

    if ($('#user input').filter(':checked').length > $('#user input').length/2) {
      $('label#user').html('Hilangkan centang')
    } else {
      $('label#user').html('Centang semua')
    }

    if ($('#item input').filter(':checked').length > $('#item input').length/2) {
      $('label#item').html('Hilangkan centang')
    } else {
      $('label#item').html('Centang semua')
    }

    if ($('#pelaporan input').filter(':checked').length > $('#pelaporan input').length/2) {
      $('label#pelaporan').html('Hilangkan centang')
    } else {
      $('label#pelaporan').html('Centang semua')
    }
  }

  function checkChild(e) {
    if ($(e).is(':checked')) {
      $('#' +$(e).attr('id')+ ' input').iCheck('uncheck')
    } else {
      $('#' +$(e).attr('id')+ ' input').iCheck('check')
    }
  }
  function checkAll(e) {
    var content = $(e).html()
    if (content == 'Hilangkan centang') {
      $('#' +$(e).attr('id')+ ' input').iCheck('uncheck')
      $(e).html('Centang semua')
    } else {
      $('#' +$(e).attr('id')+ ' input').iCheck('check')
      $(e).html('Hilangkan centang')
    }
  }

  function CheckUnitKerja(id){
    cabang = $('select[name="cabang"]').val();
    divisi = $('select[name="divisi"]').val();
    value =  false;
    if(cabang!=null||divisi!=null){
      unit = cabang+divisi;
      if(cabang == null||$('select[name="cabang"]').is(':disabled')){
        unit ="00"+divisi;
      }else if(divisi == null||$('select[name="divisi"]').is(':disabled')){
        unit =cabang+"00";
      }
      // $('#' +id+ ' input').iCheck('uncheck')
      value = true;
      // $("input[name='perizinan[unit]["+unit+"]'").iCheck('check')
      $("input[name='perizinan[unit_"+unit+"]'").iCheck('check')
    }else{

      alert("Pilih Terlebih dahulu Cabang atau Divisi");
    }
    return value;
  }

  function open_menu(menu){
    if(menu == 'dropping'){
      $( "#modal_menu_dropping" ).modal()
    }else if(menu == 'aju_dropping'){
      $( "#modal_menu_aju_dropping" ).modal()
    }else if(menu == 'transaksi'){
      $( "#modal_menu_transaksi" ).modal()
    }else if(menu == 'anggaran'){
      $( "#modal_menu_anggaran" ).modal()
    }else if(menu == 'pelaporan'){
      $( "#modal_menu_pelaporan" ).modal()
    }else if(menu == 'user'){
      $( "#modal_menu_user" ).modal()
    }else if(menu == 'item'){
      $( "#modal_menu_item" ).modal()
    }
  }

  $('#toogle_unit').click(function() {
      // if(CheckUnitKerja('unit_kerja')){
        $( "#modal_unit" ).modal();
      // }
    });
  var data_username = {};
  function changeLDAP(type){
    $("#input_user").empty();
    // alert("test");
    if(type == 1){
      $("#input_user").append('<select class="form-control" id="username" name="username" placeholder="Username" style="width: 100%;"></select>')
      $("select[name='username']").select2();
      getUsername();
      $("#username").change(function(){
        nama_lengkap = document.getElementById('nama_lengkap');
        email = document.getElementById('email');
        username = document.getElementById('username');
        nama_isi = true;
        email_isi = true;
        Object.keys(data_username).map(function(key, index) {
          if(key!="count"){

            nama_isi = true;
            email_isi = true;
            console.log(data_username[key]);
            if( typeof data_username[key]["displayname"] == 'undefined'){
              nama_isi = false;
            }
            if( typeof data_username[key]["mail"] == 'undefined'){
              email_isi = false;
            }

            text = data_username[key]["samaccountname"]["0"];
            if(text == username.value){
              if(nama_isi)
                nama_lengkap.value = data_username[key]["displayname"]["0"];
              if(email_isi && data_username[key]["mail"]["0"]!="-")
                email.value = data_username[key]["mail"]["0"];
            }
          }
        });
        if(!nama_isi)
          toastr.info("User LDAP tidak mengisi nama lengkap.", "Nama Lengkap Kosong", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});

        if(!email_isi)
          toastr.info("User LDAP tidak mengisi email.", "Email Kosong", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});

      });
      $('#form_password').css("display", "none");
    }else if(type == 0){
      $("#input_user").append('<input type="text" required="" id="username" class="form-control select2" placeholder="Username" name="username" value="{{ old("username") }}">')
      
      $('#form_password').css("display", "block");
    }

  }
  
  function getUsername(){
    $.ajax({
      'async': false, 'type': "GET", 'dataType': 'JSON', 'url': "{{ url('user/ldap/') }}",
      'success': function (data) {
        data_username = data;
        username = document.getElementById('username');

        Object.keys(data_username).map(function(key, index) {
          if(key!="count"&&data_username[key]["dn"]!="Tidak"){
            text = data_username[key]["samaccountname"]["0"];
            username.options[username.options.length] = new Option(text, text);
          }
        });

      }
    });
  }

  
  
</script>