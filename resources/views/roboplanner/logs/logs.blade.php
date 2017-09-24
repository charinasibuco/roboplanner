@extends('roboplanner.layouts.template')
@section('title', 'Logs')
@section('styles')
    {{--<link rel="stylesheet" href="{{ asset('css/jquery.steps.css')  }}">--}}
    <link rel="stylesheet" href="{{ asset("js/jquery-confirm/css/jquery-confirm.css") }}">
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="navbar navbar-default bootstrap-admin-navbar-thin">
                <ol class="breadcrumb bootstrap-admin-breadcrumb">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="active">Logs</li>
                </ol>
            </div>
        </div>
    </div>
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ Session::get('message') }}
        </div>
    @elseif(count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <li style="list-style:none">{{ $error }}</li>
            </div>
        @endforeach
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default bootstrap-admin-no-table-panel">
                <div class="panel panel-default bootstrap-admin-no-table-panel">
                    <div class="panel-heading">
                        <div class="text-muted bootstrap-admin-box-title">Logs List</div>
                    </div>
                    <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                        <div class="row">
                            <div class="col-sm-6">

                            </div>
                            <div class="col-sm-6">
                                <form method="get" action="{{ route('logs')}}">
                                    <div class="search form-group" style="float:right">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                                            <input type="text" class="search-form form-control" placeholder="Search" name="search" aria-describedby="basic-addon1" value="{{ $search }}">
                                           {{-- <span class="input-group-btn clearer">
                                                <button class="btn btn-primary" type="button" style="border:none; background-color:transparent; z-index:999; margin-left:-35px; font-size:10px"><a href="{{ route('users')}}">X</a></button>
                                            </span>--}}
                                            <span class="input-group-btn">
                                                <button class="btn btn-secondary" type="submit">Go</button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <table width="100%" class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th width="10%"></th>
                                        <th width="25%"><a href="{{ route('logs').'?page='.$page_number.'&search='.$search.'&order_by=first_name&sort='.$sort }}">User</a></th>
                                        <th width="50%"><a href="{{ route('logs').'?page='.$page_number.'&search='.$search.'&order_by=log&sort='.$sort }}">Log Description</a></th>
                                        <th width="15%">Log Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logs as $row)
                                        <tr>

                                            <td style="text-align:center">
                                                @if($row->user)
                                                <div class="dropdown">
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Options
                                                        <span class="caret"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a title="View Profile of {{ $row->user->full_name  }}" href = "{{ route('user_logs', $row->user->id) }}">
                                                                <i class="fa fa-lg fa-user"></i>View Logs for {{ $row->user->full_name  }}
                                                            </a>
                                                        </li>

                                                        @can('delete_user')
                                                        @if(Auth::user()->id != $row->id)
                                                            <li>
                                                                <a title="Delete Log of {{ $row->user->full_name  }}" href = "{{ route('delete_log', $row->id) }}" class="delete_confirmation">
                                                                    <i class="fa fa-lg fa-user-times"></i> Delete Log</a>
                                                            </li>
                                                        @endif
                                                        @endcan
                                                    </ul>
                                                </div>
                                                @endif
                                            </td>
                                            <td>{{ $row->user->full_name  }}</td>
                                            <td>{{ $row->log  }}. <small>{{ $row->updated_at->diffForHumans() }}</small></td>
                                            <td>{{ $row->updated_at->format('m/d/Y') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                                @if($logs->count() == 0)
                                    <div style="text-align:center; color:#333; font-size:18px">No records to show</div>
                                    @if($search)
                                        <div style="text-align:center; color:#333; font-size:18px">for {{ $search }}</div>
                                    @endif
                                @endif
                                {{ $logs->appends(['search' => $search])->links() }}
                                {{--{!! str_replace('/?', '?', $logs->render()) !!}--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset("js/jquery-confirm/js/jquery-confirm.js") }}"></script>
    <script>
        //        $.confirm();
        $('.delete_confirmation').on('click',function(){
            var x = confirm('Are you sure you want to delete this Log?');
            if(x){
                return true;
            }
            return false;
        });
    </script>
@stop

