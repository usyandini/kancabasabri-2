            @extends('layouts.app')
            
            @section('additional-vendorcss')
            <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/charts/morris.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/unslider.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/weather-icons/climacons.min.css') }}">
            @endsection
            @section('content')
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-xs-12 mb-2">
                        <h3 class="content-header-title mb-0">Dashboard</h3>
                    </div>
                </div>
                <div class="content-body">
                    
                    <!--Recent Orders & Monthly Salse -->
                    <div class="row match-height">
                        <div class="col-xl-8 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Notification</h4>
                                    
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/Recent Orders & Monthly Salse -->
                    <!-- Basic Horizontal Timeline -->
                    <div class="row match-height">
                        <div class="col-xl-8 col-lg-30">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"></h4>
                                    
                                </div>
                                <div class="card-body collapse in">
                                    <div class="card-block">
                                        <div class="card-text">
                                            <section class="cd-horizontal-timeline">
                                                <div class="timeline">
                                                    <div class="events-wrapper">
                                                        <div class="events" height="100">
                                                            
                                                            <span class="filling-line" aria-hidden="true"></span>
                                                        </div>
                                                        <!-- .events -->
                                                    </div>
                                                    <!-- .events-wrapper -->
                                                    
                                                    <!-- .cd-timeline-navigation -->
                                                </div>
                                                <!-- .timeline -->
                                                
                                                <!-- .events-content -->
                                            <!--</section>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Basic Horizontal Timeline -->
                </div>
                @endsection

                @section('customjs')
                <!-- BEGIN PAGE VENDOR JS-->
                <script src="{{ asset('app-assets/vendors/js/charts/raphael-min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/charts/morris.min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/extensions/unslider-min.js') }}" type="text/javascript"></script>
                <script src="{{ asset('app-assets/vendors/js/timeline/horizontal-timeline.js') }}" type="text/javascript"></script>
                <!-- END PAGE VENDOR JS-->
                <!-- BEGIN PAGE LEVEL JS-->
                <script src="{{ asset('app-assets/js/scripts/pages/dashboard-ecommerce.min.js') }}" type="text/javascript"></script>
                <!-- END PAGE LEVEL JS-->
                @endsection