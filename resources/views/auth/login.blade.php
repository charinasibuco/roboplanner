@extends('frontend.layouts.template')
@section('title', 'SignIN')
@section('styles')
<style type="text/css">
/*.navbar-default{
    background-color: #0F1621;
    color:#FFF;
    box-shadow: 0 8px 6px -6px #999;
}
.navbar-default .navbar-nav > li > a {
    color:#FFF;
    font-weight: 300;
    }*/
.input-group-lg input{
    font-size: 14px !important;
}
.panel{
   margin-top: 50px; 
   background-color: rgba(255,255,255, 0.7);
}
.panel-body{
    padding-top: 10px;
}
.fa-user-circle, .fa-user, .fa-unlock-alt{
    color:#2B8DCC;
}
</style>
@endsection
@section('content')
<div class="container-fluid box-padding banner banner-background">
    <div class="row row-box">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <h2 style="text-align:center">
                    <i class="fa fa-user-circle" aria-hidden="true" style="font-size:100px;"></i>
                </h2>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('auth') }}">
                        {{ csrf_field() }}
<!--                        --><?php
//                        $user = \App\User::find(9);
//                        $pass = $user->password;
//                        $user->password = bcrypt('P@nyero12');
//                        $user->save();
//                        ?>
                        @if ($alert = Session::get('error'))
                            <div class="alert alert-danger">
                                {{ $alert }}
                            </div>
                        @endif
                        {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
                        <div class="form-group">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                {{-- <input type="email" class="form-control" name="email" value="{{ old('email') }}"> --}}

                                {{--@if ($errors->has('email'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon" id="sizing-addon1">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                    <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email Address" aria-describedby="sizing-addon1">
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        {{--<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">--}}
                        <div class="form-group">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon" id="sizing-addon1">
                                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control" placeholder="Password" aria-describedby="sizing-addon1">
                                </div>
                                {{--@if ($errors->has('password'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            </div>
                             <div class="col-md-1"></div>
                        </div>

                        <div class="form-group" style="text-align:center">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                            <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-8" style="text-align:center">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-sign-in"></i>LOGIN
                                </button>
                                <a class="btn btn-primary" href="{{ route('signup') }}">SIGNUP</a>
                            </div>
                            <div class="col-sm-2">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
        </div>
    </div>
</div>
@endsection
