<script type="text/javascript">
  $(document).ready(function() {
    // $('select[name="cabang"]').on('change', function() {
    //   if ($(this).val() !== '00') {
    //     $('select[name="divisi"]').prop("disabled", true);
    //     toastr.info("Divisi tidak perlu dipilih jika Kantor Cabang yang dipilih adalah <b>Kantor pusat</b>.", "Kantor Cabang dipilih", { positionClass: "toast-bottom-right", showMethod: "slideDown", hideMethod: "slideUp", timeOut:10e3});
    //   } else {
    //     $('select[name="divisi"]').prop("disabled", false);
    //   }
    // });

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
    }

    @if (isset($profile_edit))
    $('input[type="checkbox"]').iCheck('disable')
    $('select[name="jenis_user"]').prop('disabled', true)
    $('input[name="profile_edit"]').val('true');

    $('label#dropping').html('')
    $('label#transaksi').html('')
    $('label#anggaran').html('')
    $('label#notifikasi').html('')
    $('label#user').html('')
    
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
</script>