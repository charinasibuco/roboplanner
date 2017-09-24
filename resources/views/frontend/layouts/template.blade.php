<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fox River Robo @yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="meta_title" content="@yield('meta_title')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="description" content="@yield('description')">
    <link rel="stylesheet" href="{{ asset('css/font-awesome-4.7.0/css/font-awesome.min.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/app.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/main.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/style.css')  }}">
    {{-- <link href='https://fonts.googleapis.com/css?family=Open+Sans:100,400,300,700' rel='stylesheet' type='text/css'> --}}
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    @yield('styles')
    <script src="{{ asset('js/lib/modernizr-2.6.2.min.js') }}"></script>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed pull-right" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="banner-text" id="login-small">
                    <button class="btn btn-primary btn-nav pull-right" style="margin-right:10px ">Login</button>
                </div>
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- <img src="{{ asset('images/truvize-4.png')}}" class="logo"> --}}
                    <img src="{{ asset('images/truvize-logo2.png')}}" class="logo">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                     {{--@include('frontend.layouts.menu', ['menus' => $menus])--}}
                    {{--@if(Auth::check())--}}
                    {{--<li><a href="{{ route('login') }}">Login</a></li>--}}
                    {{--<li><a href="{{ route('signup') }}">Signup</a></li>--}}
                    {{--@else--}}
                        {{--<li><a href="{{ route('dashboard') }}">My Account</a></li>--}}
                    {{--@endif--}}
                    @include('frontend.layouts.custom-menu-items', array('items' => $FrontMenu->roots()))
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
<div style="background-color:#00649f; padding:10px 0 10px 0">
    <div class="container">
        <div class="row white-font" style="text-align:left">
            <div class="col-sm-6">
                <p>Questions? Visit Support Center, or get in touch:</p>
            </div>
            <div class="col-sm-3">
                <p><i class="fa fa-phone" aria-hidden="true"></i></i> (920) 903-1701</p>
            </div>
            <div class="col-sm-3">
                <p><i class="fa fa-envelope" aria-hidden="true"></i> Contact@FoxRiverCapital.com</p>
            </div>
        </div>
    </div>
</div>
<a  href="#top" class="back-to-top" title="Back to Top">
  <i class="fa fa-chevron-up" aria-hidden="true"></i>
</a>
<div class="footer-background">
    <div class="container">
        <div class="row footer-details">
           <div class="col-sm-12">
                <img src="{{ asset('images/truvize_white.png')}}">
                <p>TruVize is a branch of Fox River Capital, a Registered Investment Advisor state registered in Wisconsin. Fox River Capital or TruVize does not provide tax or legal advice. All information and data on this site is for informational purposes only and should not be considered professional financial investment advice. Fox River Capital makes no representations as to the accuracy, completeness, suitability, or validity, of any information. Fox River Capital will not be liable for any errors, omissions, or any losses, injuries, or damages arising from its display or use. All information is provided as is with no warranties, and confers no rights. No client or prospective client should assume that any information presented and/or made available here serves as the receipt of, or a substitute for, personalized individual advice from the advisor or any other investment professional. Past performance is not indicative of future results. Please contact a licensed professional before making any investment decisions.</p>
           </div>
        </div>
    </div>
</div>
{{--<div class="blue-background" style="padding:25px;">
</div>--}}
    <script src="{{ asset('js/lib/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery-ui.1.10.3.min.js') }}"></script>

    <script src="{{ asset('js/all.js') }}"></script>
    <script src="{{ asset('js/application.js') }}"></script>
    <script src="{{ asset('js/typed.js')}}"></script>
    <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
    <script>
      tinymce.init({
        selector: '#mytextarea'
      });
      </script>
    @yield('scripts')
</body>