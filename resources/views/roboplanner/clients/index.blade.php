@extends('roboplanner.layouts.template')
@section('title', 'Clients')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="navbar navbar-default bootstrap-admin-navbar-thin">
                <ol class="breadcrumb bootstrap-admin-breadcrumb">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="active">Clients</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default bootstrap-admin-no-table-panel">
                <div class="panel panel-default bootstrap-admin-no-table-panel">
                    <div class="panel-heading">
                        <div class="text-muted bootstrap-admin-box-title">Clients List</div>
                    </div>
                    <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                        <div class="row">
                            <div class="col-sm-12">
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6">
                                <form method="get" action="{{ route('clients')}}">
                                    <div class="search form-group" style="float:right">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                                            <input type="text" class="search-form form-control" placeholder="Search" name="search" aria-describedby="basic-addon1" value="{{ $search }}">

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
                                        <th width="15%"></th>
                                        <th width="25%"><a href="{{ route('clients').'?page='.$page_number.'&search='.$search.'&order_by=email&sort='.$sort }}">Email</a></th>
                                        <th width="15%"><a href="{{ route('clients').'?page='.$page_number.'&search='.$search.'&order_by=first_name&sort='.$sort }}">First Name</a></th>
                                        <th width="15%"><a href="{{ route('clients').'?page='.$page_number.'&search='.$search.'&order_by=last_name&sort='.$sort }}">Last Name</a></th>
                                        <th width="13%">Registered</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $row)
                                        <tr>
                                            <td style="text-align:center">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Options
                                                        <span class="caret"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a title="View Profile of {{ $row->full_name  }}" href = "{{ route('client_profile', $row->id) }}"><i class="fa fa-lg fa-user"></i> View Profile</a></li>
                                                        <li><a title="View wealth scores of {{ $row->full_name  }}" href = "{{ route('dashboard_show', $row->id) }}"><i class="fa fa-lg fa-user"></i> View Wealth Score</a></li>

                                                        {{--@can('update_user')--}}
                                                            {{--<li><a title="Edit Client {{ $row->full_name  }}" href = "{{ route('client_edit', $row->id) }}"><i class="fa fa-lg fa-pencil-square-o"></i> Edit</a></li>--}}
                                                        {{--@endcan--}}
                                                        @can('delete_user')
                                                        <li><a title="Delete Client {{ $row->full_name  }}" href = "{{ route('client_destroy', $row->id) }}" onclick="return confirm('Are you sure you want to Delete this user?')"><i class="fa fa-lg fa-user-times"></i> Delete</a></li>
                                                        @endcan
                                                 </ul>
                                                </div>
                                                    <!-- Modal -->
                                                <div id="{{ $row->id  }}_role_modal" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title"><label for="status">Assign Role</label></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('user_assign_role', $row->id) }}" method="post">
                                                                    <select name="role" id="role" class="form-control">
                                                                        <option value="" selected disabled>-Choose Role-</option>
                                                                        @foreach(App\Role::all() as $role)

                                                                            <option value="{{ $role->id  }}" @if($row->Role()->first()->id == $role->id))) selected @endif>{{ $role->name }}</option>
                                                                        @endforeach
                                                                    </select>

                                                                    <br/>
                                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                                    {!! csrf_field() !!}
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->first_name  }}</td>
                                            <td>{{ $row->last_name  }}</td>
                                            <td>{{ ($row->created_at != NULL) ? $row->created_at->format('m/d/y') : ''  }}<br><small>{{ ($row->created_at != NULL) ? $row->created_at->diffForHumans() : ''  }}</small></td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                                @if($users->count() == 0)
                                    <div style="text-align:center; color:#333; font-size:18px">No records to show</div>
                                    @if($search)
                                        <div style="text-align:center; color:#333; font-size:18px">for {{ $search }}</div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


