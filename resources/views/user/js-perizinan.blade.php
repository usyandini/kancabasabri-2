<script type="text/javascript">
  $(document).ready(function() {
    if ($('#notifikasi input').filter(':checked').length > $('#notifikasi input').length/2) {
      $('label#notifikasi').html('Hilangkan centang')
    } else {
      $('label#notifikasi').html('Centang semua')
    }

    if ($('#transaksi input').filter(':checked').length > $('#transaksi input').length/2) {
      $('label#transaksi').html('Hilangkan centang')
    } else {
      $('label#transaksi').html('Centang semua')
    }

    if ($('#anggaran input').filter(':checked').length > $('#anggaran input').length/2) {
      console.log('tes')
      $('label#anggaran').html('Hilangkan centang')
    } else {
      $('label#anggaran').html('Centang semua')
    }

    if ($('#user input').filter(':checked').length > $('#user input').length/2) {
      console.log('tes')
      $('label#user').html('Hilangkan centang')
    } else {
      $('label#user').html('Centang semua')
    }
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