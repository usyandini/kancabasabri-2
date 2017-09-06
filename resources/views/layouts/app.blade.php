<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading" style="">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="PIXINVENT">
        <title>Aplikasi Anggaran dan Belanja PT. Asabri (Persero)</title>
        <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/ico/favicon.ico') }}">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/feather/style.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/flag-icon-css/css/flag-icon.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/pace.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-callout.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/toastr.min.css') }}">
        @yield('additional-vendorcss')
        <!-- END VENDOR CSS-->
        <!-- BEGIN STACK CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/jquery-ui.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/app.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.min.css')}}">
        <!-- END STACK CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-overlay-menu.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/simple-line-icons/style.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/timeline.min.css') }}">
        <!-- link(rel='stylesheet', type='text/css', href='../../../app-assets/css#{rtl}/pages/users.css')-->
        <!-- END Page Level CSS-->
        <!-- BEGIN Custom CSS-->
        {{-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"> --}}
        <!-- END Custom CSS-->
    </head>
    <body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns  fixed-navbar" style="">
        <!-- - var navbarShadow = true-->
        <!-- navbar-fixed-top-->
        <nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-light bg-gradient-x-grey-blue">
            <div class="navbar-wrapper">
                <div class="navbar-header">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="ft-menu font-large-1"></i></a></li>
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="navbar-brand">
                                <img src="{{ asset('app-assets/images/asabri-logo.png', $secure = null) }}" width="45%" align="middle" hspace="30%">
                            </a>
                        </li>
                        <li class="nav-item hidden-md-up float-xs-right">
                            <a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="fa fa-ellipsis-v"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-container content container-fluid">
                    <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
                        <ul class="nav navbar-nav">
                            <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="ft-menu"></i></a></li>
                            <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-link-expand"><i class="ficon ft-maximize"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav float-xs-right">
                            <li class="dropdown dropdown-notification nav-item">
                              <a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="ficon ft-bell"></i>
                                <span class="tag tag-pill tag-default tag-danger tag-default tag-up" id="unreadCount"></span>
                              </a>
                              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right"  style="width: 500px;">
                                <li class="dropdown-menu-header">
                                  <h6 class="dropdown-header m-0">
                                    <span class="grey darken-2">Notifications</span>
                                  </h6>
                                </li>
                                <li class="list-group scrollable-container" id="notifList">
                                </li>
                                <li class="dropdown-menu-footer"><a href="javascript:void(0)" class="dropdown-item text-muted text-xs-center">Read all notifications</a></li>
                              </ul>
                            </li>
                            <li class="dropdown dropdown-user nav-item">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                                    <span class="avatar avatar-online">
                                        <img src="{{ asset('app-assets/images/empty-profile-grey.jpg', $secure = null) }}" alt="avatar"><i></i></span>
                                    <span class="user-name">{{ Auth::user()->name }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-divider"></div><a href="{{ url('logout', $parameters = [], $secure = null) }}" class="dropdown-item"><i class="ft-power"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- ////////////////////////////////////////////////////////////////////////////-->
        <div data-scroll-to-active="true" class="main-menu menu-fixed menu-light menu-accordion menu-shadow">
            <div class="main-menu-content">
                <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
                    <li class="navigation-header">
                    </li>
                    <li class="navigation-header">
                        <span >Menu Utama</span><i data-toggle="tooltip" data-placement="right" data-original-title="General"
                                               class=" ft-minus"></i>
                    </li>
                    <li class="nav-item {{ checkActiveMenu('dropping') }}"><a href="{{ url('/dropping', $parameters = [], $secure = null) }}"><i class="ft-box"></i><span data-i18n="" class="menu-title">Dropping</span></a>
                    </li>
                    <li class="nav-item has-sub {{ checkOpenedMenu('transaksi') }}"><a href=""><i class="ft-layout"></i><span data-i18n="" class="menu-title">Transaksi</span></a>
                        <ul class="menu-content">
                            <li class="is-shown {{ checkActiveMenu('transaksi') }}"><a href="{{ url('/transaksi', $parameters = [], $secure = null) }}" class="menu-item">Informasi Transaksi</a>
                            {{--<li class="is-shown {{ checkActiveMenu('persetujuan') }}"><a href="{{ url('/transaksi/persetujuan', $parameters = [], $secure = null) }}" class="menu-item">Persetujuan Transaksi</a>
                            <li class="is-shown {{ checkActiveMenu('verifikasi') }}"><a href="{{ url('/transaksi/verifikasi', $parameters = [], $secure = null) }}" class="menu-item">Verifikasi Transaksi</a>--}}
                        </ul>
                    </li>
                    @if(\Auth::user()->is_admin)
                        <li class="nav-item has-sub {{ checkActiveMenu('user') }}"><a href=""><i class="ft-user"></i><span data-i18n="" class="menu-title">Manajemen User</span></a>
                        <ul class="menu-content">
                            <li class="is-shown {{ checkActiveMenu('user') }}"><a href="{{ url('/user', $parameters = [], $secure = null) }}" class="menu-item">Informasi User</a>
                            <li class="is-shown {{ checkActiveMenu('create') }}"><a href="{{ url('/user/create', $parameters = [], $secure = null) }}" class="menu-item">Tambah User</a>
                            <li class="is-shown {{ checkActiveMenu('persetujuan') }}"><a href="{{ url('/user', $parameters = [], $secure = null) }}" class="menu-item">Informasi Cabang dan Divisi</a>
                        </ul>
                    @endif
                </ul>
            </div>
        </div>
        <div class="app-content content container-fluid">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
        <!-- ////////////////////////////////////////////////////////////////////////////-->

        <footer class="footer footer-static footer-dark navbar-border" style="">
            <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
                <span class="float-md-left d-xs-block d-md-inline-block">Copyright &copy; 2017 <a href="https://gumcode.net/"
                                                                                                  target="_blank" class="text-bold-800 grey darken-2">Gumcode </a>, All rights
                    reserved. </span>
                <span class="float-md-right d-xs-block d-md-inline-block">Hand-crafted & Made with <i class="ft-heart pink"></i></span>
            </p>
        </footer>
        <!-- BEGIN VENDOR JS-->
        <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('app-assets/vendors/js/ui/jquery-ui.min.js') }}"></script>
        <!-- BEGIN VENDOR JS-->
        <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
        @yield('customjs')
        <!-- BEGIN STACK JS-->
        <script src="{{ asset('app-assets/js/core/app-menu.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('app-assets/js/core/app.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
        <script src="{{ asset('app-assets/js/scripts/extensions/toastr.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}" type="text/javascript"></script>
        <!-- END STACK JS-->
        @extends('layouts.notif-js')
    </body>
</html>