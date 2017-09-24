@extends('roboplanner.layouts.template')
@section('title', 'Dashboard')
@section('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/wealth_score.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/action_steps.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.idealforms.css')  }}">
    <style>
        .results {
            height: 300px;
        }
        #illustrative_plan caption{
            font-weight: bold;
            text-align: center;
        }
        #illustrative_plan td, #illustrative_plan th{padding: 3px}
        #illustrative_plan{
            width: 1800px !important;
        }

    </style>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" media="screen" href="{{ asset('admin/dashboard/css/bootstrap.min.css') }}">
    <link rel="stylesheet" media="screen" href="{{ asset('admin/dashboard/css/bootstrap-theme.min.css') }}">

    <!-- Bootstrap Admin Theme -->
    <link rel="stylesheet" media="screen" href="{{ asset('admin/dashboard/css/bootstrap-admin-theme.css') }}">
    {{--<link rel="stylesheet" media="screen" href="{{ asset('admin/dashboard/css/bootstrap-admin-theme-change-size.css') }}">--}}

    <!-- Vendors -->
    <link rel="stylesheet" media="screen" href="{{ asset('admin/dashboard/vendors/easypiechart/jquery.easy-pie-chart.css') }}">
    <link rel="stylesheet" media="screen" href="{{ asset('admin/dashboard/vendors/easypiechart/jquery.easy-pie-chart_custom.css') }}">




@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="navbar navbar-default bootstrap-admin-navbar-thin">
                <ol class="breadcrumb bootstrap-admin-breadcrumb">
                    <li class="active">Dashboard</li>

                </ol>
            </div>
        </div>
    </div>
    {{--<div class="container">--}}
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default bootstrap-admin-no-table-panel">
                    <div class="panel-heading">
                        <div class="text-muted bootstrap-admin-box-title">Statistics</div>
                        <div class="pull-right"><span class="badge">View More</span></div>
                    </div>
                    <div class="bootstrap-admin-panel-content bootstrap-admin-no-table-panel-content collapse in">
                        <div class="col-md-3">
                            <div class="easyPieChart" data-percent="73" style="width: 110px; height: 110px; line-height: 110px;">73%<canvas width="110" height="110"></canvas></div>
                            <div class="chart-bottom-heading"><span class="label label-info">Visitors</span></div>
                        </div>
                        <div class="col-md-3">
                            <div class="easyPieChart" data-percent="53" style="width: 110px; height: 110px; line-height: 110px;">53%<canvas width="110" height="110"></canvas></div>
                            <div class="chart-bottom-heading"><span class="label label-info">Page Views</span></div>
                        </div>
                        <div class="col-md-3">
                            <div class="easyPieChart" data-percent="83" style="width: 110px; height: 110px; line-height: 110px;">83%<canvas width="110" height="110"></canvas></div>
                            <div class="chart-bottom-heading"><span class="label label-info">Users</span></div>
                        </div>
                        <div class="col-md-3">
                            <div class="easyPieChart" data-percent="13" style="width: 110px; height: 110px; line-height: 110px;">13%<canvas width="110" height="110"></canvas></div>
                            <div class="chart-bottom-heading"><span class="label label-info">Orders</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="text-muted bootstrap-admin-box-title">Users</div>
                        <div class="pull-right"><span class="badge">{{ count($users) }}</span></div>
                    </div>
                    <div class="bootstrap-admin-panel-content">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="25%">First Name</th>
                                    <th width="25%">Last Name</th>
                                    <th width="40%">Username</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td style="word-wrap: break-word">{{ $user->email }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="text-muted bootstrap-admin-box-title">Clients</div>
                        <div class="pull-right"><span class="badge">{{ count($clients) }}</span></div>
                    </div>
                    <div class="bootstrap-admin-panel-content">
                        <table width="100%" class="table table-striped">
                            <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th width="25%">First Name</th>
                                <th width="25%">Last Name</th>
                                <th width="40%">Username</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td>{{ $client->user_id }}</td>
                                    <td>{{ $client->first_name }}</td>
                                    <td>{{ $client->last_name }}</td>
                                    <td>{{ $client->email }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="text-muted bootstrap-admin-box-title">Logs Panel</div>
                        {{--<div class="pull-right"><span class="badge">0</span></div>--}}
                    </div>
                    <div class="panel-body">
                        @if(count($logs) > 0)
                            <table width="100%" class="table table-striped">
                                <thead>
                                <tr>
                                    <th width="70%">Log</th>
                                    <th width="30%">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs as $log)
                                <tr>
                                    <td><a href="{{ route('user_logs', $log->user->id) }}">{{ $log->log }}</a><br><small>{{ $log->updated_at->diffForHumans() }}</small></td>
                                    <td valign="top">{{ $log->updated_at->format('m/d/Y') }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="no-data">
                                Sorry, no data to display
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
   {{-- </div>--}}

@endsection
@section('scripts')

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="{{ asset('admin/dashboard/js/twitter-bootstrap-hover-dropdown.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/dashboard/vendors/easypiechart/jquery.easy-pie-chart.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            // Easy pie charts
            $('.easyPieChart').easyPieChart({animate: 1000});
        });
    </script>
@endsection

