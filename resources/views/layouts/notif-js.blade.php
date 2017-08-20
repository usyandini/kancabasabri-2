<script type="text/javascript">
    // function getNotif() {
    //     $.get('{{ url('/notification') }}', function(e){
    //         if(e.totalUnread == 0) {
    //             $('#unread').hide();
    //             $('.notifCount').text('');
    //         } else {   
    //             $('#unread').show();
    //             $('.notifCount').text(e.totalUnread);
    //         }
    //         if (e.total == 0) {
    //             // $('#notifList, notifList2, #notifSection').hide();
    //             $('#notifList, notifList2, #notifSection').html(
    //                 '<a href="#" class="media list-group-item">'+
    //                     '<span>'+
    //                         'Tidak ada notifikasi'+
    //                     '</span>'+
    //                 '</a>');
    //         } else {
    //             $('#notifList, notifList2, #notifSection').show();
    //             $('#notifList, notifList2, #notifSection').html('');
    //         }
    //         e.notif.forEach(function(val) {
    //             $('#notifList, notifList2').append(''+
    //                 '<a href="{{ url('notification') }}/'+val.id+'" class="media list-group-item">'+
    //                     '<span>'+
    //                         val.content+
    //                         (val.is_read == 0 ? ' <span class="label label-danger">Baru</span>' : '')+
    //                         '<br><small class="text-muted">'+val.date+'</small>'+
    //                     '</span>'+
    //                 '</a>');
    //         })
            
    //     });
    //     setTimeout("getNotif()", 10000);
    // }

    // $(document).ready(function() {
    //     getNotif();
    // });
    function getNotif() {
        $.get('{{ url('/notification') }}', function(e){
            if(e.totalUnread == 0) {
                $('#unread').hide();
                $('#unreadCount').text('');
            } else {   
                $('#unread').show();
                $('#unreadCount').text(e.totalUnread);
            }
            if (e.total == 0) {
                // $('#notifList, notifList2, #notifSection').hide();
                $('#notifList, notifList2, #notifSection').html(
                    '<a href="#" class="media list-group-item">'+
                        '<span>'+
                            'Tidak ada notifikasi'+
                        '</span>'+
                    '</a>');
            } else {
                $('#notifList, notifList2, #notifSection').show();
                $('#notifList, notifList2, #notifSection').html('');
            }
            e.notifications.forEach(function(val) {
                $('#notifList, notifList2').append(''+
                    '<a href="{{ url('notification/redirect') }}/'+ val.id +'" class="list-group-item">' +
                        '<div class="media">' +
                          '<div class="media-left valign-middle"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div>' +
                          '<div class="media-body">' +
                            '<p class="notification-text font-small-3 text-muted">'+ val.wording +'</p>' +
                            '<small>' +
                              '<time datetime="" class="media-meta text-muted">'+ val.time_dif +' ('+ val.time +')</time>' +
                            '</small>' +
                            (val.is_read == 0 ? '<span class="tag tag-danger float-xs-right">BARU</span>' : '')+
                          '</div>' +
                        '</div>' +
                    '</a>');
            })
            
        });
        setTimeout("getNotif()", 10000);
    }

    $(document).ready(function() {
        getNotif();
    });
</script>