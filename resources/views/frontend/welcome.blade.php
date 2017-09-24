@extends('frontend.layouts.template')

@section('title', 'SignUP')


@section('content')
    <div class="container">
        <br/> <br/> <br/> <br/>
        <div class="row">
            <div class="col-md-12">
                <center>
                    <h3>You have registered successfully. Thank you for using Fox River!</h3>
                    <h4>Please Login to see your Wealth Score.</h4>
                    <a href="{{ route('login')}}"><button class="btn btn-success">LOGIN</button></a>
                </center>
            </div>
        </div>
        <br/> <br/> <br/> <br/>
        <br/> <br/> <br/> <br/>
    </div>
@stop
