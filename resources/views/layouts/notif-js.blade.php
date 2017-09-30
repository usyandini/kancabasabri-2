<script type="text/javascript">
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
                var link = '<a href="{{ url('notification/redirect') }}/'+ val.id +'" class="list-group-item">';
                var link2 = '</a>';
                if(val.type == 17||val.type == 19||val.type == 21||val.type == 23||val.type == 25||val.type == 27||val.type == 29){
                    if({{Gate::check('notif_ubah_a')?1:0}}){
                        var link_con = true;
                        if(val.type == 17&&{{Gate::check('notif_setuju_iia')?1:0}}){
                            link_con = false;
                        }

                        if(val.type == 19&&{{Gate::check('notif_setuju_iiia')?1:0}}){
                            link_con = false;
                        }

                        if(val.type == 21&&{{Gate::check('notif_setuju_iva')?1:0}}){
                            link_con = false;
                        }

                        if(val.type == 23&&{{Gate::check('notif_setuju_va')?1:0}}){
                            link_con = false;
                        }

                        if(val.type == 25&&{{Gate::check('notif_setuju_via')?1:0}}){
                            link_con = false;
                        }

                        if(val.type == 27&&{{Gate::check('notif_setuju_viia')?1:0}}){
                            link_con = false;
                        }

                        if(val.type == 29&&{{Gate::check('notif_setuju_viiia')?1:0}}){
                            link_con = false;
                        }

                        if(link_con){
                            link='';
                            link2='';
                        }
                    }
                }else if(val.type == 12){
                    @if(Gate::check('notif_ubah_d')&&!Gate::check('notif_setuju_p2_d'))
                    link='';
                    link2='';
                    @endif
                }else if(val.type == 4){
                    @if(Gate::check('notif_ubah_t')&&!Gate::check('notif_setuju2_t'))
                    link='';
                    link2='';
                    @endif
                }
                
                $('#notifList, notifList2').append(''+
                     link+
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
                    link2);
            })
            
        });
        setTimeout("getNotif()", 10000);
    }

    $(document).ready(function() {
        getNotif();
    });
</script>