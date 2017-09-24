@extends('roboplanner.layouts.template')
@section('title', $user->full_name . ' Profile')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="navbar navbar-default bootstrap-admin-navbar-thin">
                <ol class="breadcrumb bootstrap-admin-breadcrumb">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('users') }}">Users</a></li>
                    <li class="active">{{ $user->full_name  }} Profile</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default bootstrap-admin-no-table-panel">
                <div class="panel panel-default bootstrap-admin-no-table-panel">
                    <div class="panel-heading">
                        <div class="text-muted bootstrap-admin-box-title">{{ $user->first_name . ' ' . $user->last_name }} Profile</div>
                    </div>
                    <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading"><i class="fa fa-user"></i>&nbsp;</span>Personal Details</div>
                                    <div class="panel-body">
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="pull-right">Photo</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <img src="{{ asset('images/default_user.png') }}" style="width:200px; height:auto; padding-bottom:10px">
                                                </div>
                                                <div class="col-sm-5">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-9">
                                                    <label for="file-upload">
                                                        <button class="btn">Select Image</button>
                                                    </label>
                                                    <input id="file-upload" type="file"/></br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="pull-right">First Name</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input class="form-control" name="first_name" placeholder="First Name" value="{{ $user->first_name }}" disabled></br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="pull-right">Last Name</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input class="form-control" name="last_name" placeholder="Last Name" value="{{ $user->last_name }}" disabled></br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="pull-right">Age</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input class="form-control" name="age" value="{{ @$metas['age'] }}" disabled></br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="pull-right">Gender</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="gender" disabled>
                                                        <option value="male" >Male</option>
                                                        <option value"female" >Female</option>
                                                    </select></br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4><b>Account Login</b></h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="pull-right">Email</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input class="form-control" name="email" placeholder="Email" value="{{ $user->email }}" disabled></br>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading"><i class="fa fa-building"></i>&nbsp;Account Details</div>
                                    <div class="panel-body">
                                        Details not available

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">

                                    </div>
                                    <div class="col-sm-6">

                                        <a href="{{ route('users')}}"><input type="button" class="btn btn-danger pull-right" value="Cancel"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection