<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="PIXINVENT">
        <title>Aplikasi Anggaran dan Belanja PT. Asabri (Persero)</title>
        <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/feather/style.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/flag-icon-css/css/flag-icon.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/pace.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/custom.css') }}">
        <!-- END VENDOR CSS-->
        <!-- BEGIN STACK CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/app.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.min.css') }}">
        <!-- END STACK CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/horizontal-menu.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-overlay-menu.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/login-register.min.css') }}">
        <!-- END Page Level CSS-->
        <!-- BEGIN Custom CSS-->
        {{-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"> --}}
        <!-- END Custom CSS-->
    </head>
    <body data-open="click" data-menu="horizontal-menu" data-col="1-column" class="horizontal-layout horizontal-menu 1-column  blank-page blank-page">
        <div class="app-content container center-layout mt-2">
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body"><section class="flexbox-container">
                        <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1  box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header no-border">
                                    <div class="card-title text-xs-center">
                                        <div class="p-1"><img src="{{ asset('app-assets/images/asabri-logo.png') }}" width="50%"><h2 class="brand-text">SELAMAT DATANG</h2></div>
                                    </div>
                                    <h3 class="card-subtitle text-muted text-xs-center"><span>Aplikasi Anggaran dan Belanja</span></h3>
                                </div>
                                <div class="card-body collapse in">
                                    <div class="card-block">
                                        @if($errors->all())
                                        <div class="alert alert-danger">
                                            @foreach($errors->all() as $err)
                                                {!! $err.'<br>' !!}
                                            @endforeach
                                        </div>
                                        @endif
                                        <form class="form-horizontal form-simple" method="POST" action="{{ url('login') }}" novalidate>
                                        	{{ csrf_field() }}
                                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                                <input type="text" name="username" value="{{ old('email', $default = null) }}" class="form-control form-control-lg input-lg" id="user-name" placeholder="Username anda" required>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" name="password" class="form-control form-control-lg input-lg" id="user-password" placeholder="Masukkan password" required>
                                                <div class="form-control-position">
                                                    <i class="fa fa-key"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group row">
                                                <div class="col-md-6 col-xs-12 text-xs-center text-md-left">
                                                    <fieldset>
                                                        <input type="checkbox" id="remember-me" class="chk-remember" name="remember">
                                                        <label for="remember-me"> Ingat Saya</label>
                                                    </fieldset>
                                                </div>
                                            </fieldset>
                                            <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="ft-unlock"></i> Masuk</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="">
                                        <p class="float-sm-right text-xs-center m-0">
                                        	<span class="float-md-left d-xs-block d-md-inline-block">Copyright  &copy; 2017 <a href="https://gumcode.net" target="_blank" class="text-bold-800 grey darken-2">Gumcode </a></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>

        <!-- BEGIN VENDOR JS-->
        <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
        <!-- BEGIN VENDOR JS-->
        <!-- BEGIN PAGE VENDOR JS-->
        <script type="text/javascript" src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
        <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}" type="text/javascript"></script>
        <!-- END PAGE VENDOR JS-->
        <!-- BEGIN STACK JS-->
        <script src="{{ asset('app-assets/js/core/app-menu.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('app-assets/js/core/app.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}" type="text/javascript"></script>
        <!-- END STACK JS-->
        <!-- BEGIN PAGE LEVEL JS-->
        <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
        <script src="{{ asset('app-assets/js/scripts/forms/form-login-register.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL JS-->
    </body>
</html>