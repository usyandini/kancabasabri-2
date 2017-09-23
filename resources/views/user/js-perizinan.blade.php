<script type="text/javascript">
  $(document).ready(function() {
    $('select[name="cabang"]').on('change', function() {
      if ($(this).val() !== '00') {
        $('select[name="divisi"]').prop("disabled", true);
        toastr.info("Divisi tidak perlu dipilih jika Kantor Cabang yang dipilih adalah <b>Kantor pusat</b>.", "Kantor Cabang dipilih", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
      } else {
        $('select[name="divisi"]').prop("disabled", false);
      }
    });

    $('select[name="jenis_user"]').on('change', function(){
      $.post('{{ url('/jenis_user/handle') }}', {_token: '{{ csrf_token() }}', id: $(this).val()}, function(e) {
        $('input[type="checkbox"]').iCheck('uncheck');
        $.each(e, function(e) {
          $('input[name="perizinan[' + e + ']"]').iCheck('check');
        })
        calibrateCentang()
      });
    });

    function calibrateCentang() {
      if ($('#notifikasi input').filter(':checked').length > $('#notifikasi input').length/2) {
        $('label#notifikasi').html('Hilangkan centang')
      } else {
        $('label#notifikasi').html('Centang semua')
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
    }

    @if (isset($profile_edit))
    $('input[type="checkbox"]').iCheck('disable')
    $('select[name="jenis_user"]').prop('disabled', true)
    $('label#dropping').html('')
    $('label#transaksi').html('')
    $('label#anggaran').html('')
    $('label#notifikasi').html('')
    $('label#unit_kerja').html('')
    $('label#user').html('')
    $('label#item').html('')
    $('input[type="radio"]').iCheck('disable')
    @else
    calibrateCentang()
    @endif
  })
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
      $('#' +id+ ' input').iCheck('uncheck')
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

  $('.iCheck-helper').click(function() {
      id = $(this).prev().attr('id');
      if(id == "activ_dir_on"){
        if(!$(this).prev().is(':disabled')){
          $(this).prev().iCheck('check');
          changeLDAP('on');
        }
      }else if(id == "activ_dir_off"){
        if(!$(this).prev().is(':disabled')){
          $(this).prev().iCheck('check');
          changeLDAP('off');
        }
      }else{
        check= $('#' +id+ ' input');
        if($(this).prev().is(':checked')){
          check.iCheck('check')
        }else{
          check.iCheck('uncheck')
        }
      }
      
      
  });
  var data_username = {};
  function changeLDAP(type){
    $("#input_user").empty();
    if(type == "on"){
      $("#input_user").append('<select class="form-control" id="username" name="username" placeholder="Username" style="width: 100%;"></select>')
      $("select[name='username']").select2();
      getUsername();
      $("#username").change(function(){
        nama_lengkap = document.getElementById('nama_lengkap');
        username = document.getElementById('username');
        Object.keys(data_username).map(function(key, index) {
            if(key!="count"){

                // console.log(data_username[key]);
              if( typeof data_username[key]["displayname"] == 'undefined'){
                console.log(data_username[key]);
              }
              
              text = data_username[key]["samaccountname"]["0"];
              // if(text == username.value){
              //   nama_lengkap.value = data_username[key]["displayname"]["0"];
              // }
            }
        });
      });
      $('#form_password').css("display", "none");
    }else if(type == "off"){
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
                  if(key!="count"){
                    text = data_username[key]["samaccountname"]["0"];
                    username.options[username.options.length] = new Option(text, text);
                  }
              });
             
          }
      });
  }

  
  
</script>