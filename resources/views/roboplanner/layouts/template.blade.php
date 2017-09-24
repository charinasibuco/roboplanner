<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fox River Robo @yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/font-awesome-4.5.0/css/font-awesome.min.css')  }}">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.icon-large.min.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/app.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/main.css')  }}">
    <link rel="stylesheet" media="screen" href="{{ asset('admin/css/bootstrap-theme.min.css') }}">
    <!-- Bootstrap Admin Theme -->
    <link rel="stylesheet" media="screen" href="{{ asset('admin/css/bootstrap-admin-theme.css') }}">
    <style>
        div{
            word-wrap: break-word;
            hyphens: auto;
        }

        div table{
            table-layout:fixed;
            width: 100% !important;
        }
        .bootstrap-admin-navbar-under-small{
            padding: 14px;
        }
        .navbar-brand{
            margin-top: -30px;
        }
        nav{
            box-shadow: 0 8px 6px -6px #999;
            background-color: #FFF;
        }
    </style>
    @yield('styles')
    <script src="{{ asset('js/lib/modernizr-2.6.2.min.js') }}"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ asset('admin/js/html5shiv.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body class="bootstrap-admin-with-small-navbar">
<nav class="navbar navbar-fixed-top bootstrap-admin-navbar-under-small" role="navigation">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".main-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/truvize-logo2.png') }}" alt="TruVize" /></a>
                </div>
                <div class="collapse navbar-collapse main-navbar-collapse">
                    {{--{!! Menu::get('TopMenu')->asUl(['class' => 'nav navbar-nav navbar-right']) !!}--}}
                    <ul class="nav navbar-nav navbar-right">
                        @include(config('laravel-menu.views.bootstrap-items'), array('items' => $TopMenu->roots()))
{{--                        @include('roboplanner.layouts.custom-menu-items', array('items' => $TopMenu->roots()))--}}
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </div>
    </div><!-- /.container -->
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-2 bootstrap-admin-col-left">
            {!! Menu::get('AdminMenu')->asUl(['class' => 'nav navbar-collapse collapse bootstrap-admin-navbar-side']) !!}
{{--            {{ Menu::get('AdminMenu')->asUl(['class' => 'nav navbar-collapse collapse bootstrap-admin-navbar-side']) }}--}}
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h1>@yield('title')</h1>
                    </div>
                </div>
            </div>
            {{--<div class="row">--}}
                {{--<div class="col-lg-12">--}}
                    {{--<div class="alert alert-success bootstrap-admin-alert">--}}
                        {{--<button type="button" class="close" data-dismiss="alert">×</button>--}}
                        {{--<h4>Success</h4>--}}
                        {{--The operation completed successfully--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="row">
                <div class="col-lg-12">@yield('content')</div>
            </div>

        </div>

    </div>
</div>

<script src="{{ asset('js/lib/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('js/lib/jquery-ui.1.10.3.min.js') }}"></script>

<script src="{{ asset('js/all.js') }}"></script>
{{--<script type="text/javascript" src="{{ asset('admin/js/twitter-bootstrap-hover-dropdown.min.js') }}"></script>--}}
@yield('scripts')
</body>