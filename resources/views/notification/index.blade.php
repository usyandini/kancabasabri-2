                @extends('layouts.app')

                @section('additional-vendorcss')
                <style type="text/css">
                .hide {
                	display: none;
                }
            </style>
            @endsection
            @section('content')
            <div class="content-header row">
            	<div class="content-header-left col-md-6 col-xs-12 mb-2">
            		<h3 class="content-header-title mb-0">Notifikasi</h3>
            	</div>
            </div>
            <div class="row">
            	<section id="select-inputs">
            		<div class="row">
                        <div class="col-md-3">
                            <div>
                                <div class="card-body collapse in">
                                    <div class="card-block">
                                        <a class="btn btn-sm btn-secondary" href="{{ url('notification/mark_all') }}"><i class="fa fa-check"></i> Tandai semua dibaca</a>
                                        {{-- <a class="btn btn-sm btn-secondary" href="{{ url('notification/del_all') }}"><i class="fa fa-times"></i> Hapus semua</a> --}}
                                    </div>
                                </div>  
                            </div>
                        </div>
                        @foreach ($notification_all as $notif)
                        <div class="col-xs-10 offset-md-1">
                            <div class="card">
                                <div class="card-body collapse in">                         
                                    <a href="{{ url('notification/redirect').'/'.$notif['id'] }}">
                                        <div class="card-block">
                                            {!! $notif['wording'] !!}<br>
                                            <span class="font-small-2">{!! $notif['time_dif'] !!} ({!! $notif['time'] !!})</span>
                                            @if ($notif['is_read'] == 0)
                                            <span class="tag tag-danger float-xs-right">BARU</span>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </section>
                </div>
            </div>
            @endsection

            @section('customjs')
            <!-- BEGIN PAGE VENDOR JS-->
            <script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
            <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
            <script src="{{ asset('app-assets/vendors/js/tables/jsgrid/jquery.validate.min.js') }}" type="text/javascript"></script>
            <!-- END PAGE VENDOR JS-->
            <!-- BEGIN PAGE LEVEL JS-->
            <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script> 
            @endsection