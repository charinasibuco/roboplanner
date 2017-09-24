@extends('roboplanner.layouts.template')
@section('title', 'Taxes')
@section('styles')
    <style>
        .table th, .table td{
            font-size: 11px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="navbar navbar-default bootstrap-admin-navbar-thin">
                <ol class="breadcrumb bootstrap-admin-breadcrumb">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="active">Taxes</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default bootstrap-admin-no-table-panel">
                <div class="panel panel-default bootstrap-admin-no-table-panel">
                    <div class="panel-heading">
                        <div class="text-muted bootstrap-admin-box-title">Tax List</div>
                    </div>
                    <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
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
                        <div class="col-sm-6">
                            @can("create_tax")<a title="Add a New Tax" class="btn btn-primary" href="{{ route('tax_create')}}"><i class="fa fa-plus"></i> &nbsp;Create New Tax</a>@endcan
                        </div>
                        <div class="col-sm-6">
                            <form method="get" action="{{ route('taxes')}}">
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
                        <div class="col-sm-12">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Action</th>
                                    <th><a href="{{ route('taxes').'?page='.$page_number.'&search='.$search.'&order_by=tax_rate&sort='.$sort }}">Tax Rate</a></th>
                                    <th><a href="{{ route('taxes').'?page='.$page_number.'&search='.$search.'&order_by=single_filters_to&sort='.$sort }}">Single Filers</a></th>
                                    <th><a href="{{ route('taxes').'?page='.$page_number.'&search='.$search.'&order_by=married_filling_jointly_to&sort='.$sort }}">Married Filing Jointly</a></th>
                                    <th><a href="{{ route('taxes').'?page='.$page_number.'&search='.$search.'&order_by=married_filling_separately_to&sort='.$sort }}">Married Filing Separately</a></th>
                                    <th><a href="{{ route('taxes').'?page='.$page_number.'&search='.$search.'&order_by=head_of_household_to&sort='.$sort }}">Head of Household</a></th>
                                    <th><a href="{{ route('taxes').'?page='.$page_number.'&search='.$search.'&order_by=due_date&sort='.$sort }}">Due Date</a></th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($taxes as $row)
                                    <tr>
                                        <td>@can("edit_tax")<a href="{{ route('tax_edit', $row->id)}}"><i class="fa fa-lg fa-pencil-square-o"></i></a>@endcan | @can("delete_tax")<a href="{{ route('tax_delete', $row->id) }}" onclick="return confirm('Are you sure you want to Delete this Tax?')"><i class="fa fa-lg fa-times"></i></a>@endcan </td>
                                        <td>{{ $row->tax_rate }}</td>
                                        <td>{{ $row->single_filters }}</td>
                                        <td>{{ $row->married_filling_jointly }}</td>
                                        <td>{{ $row->married_filling_separately }}</td>
                                        <td>{{ $row->head_of_household }}</td>
                                        <td>{{ $row->due_date->format('m/d/Y') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            @if($taxes->count() == 0)
                                <div style="text-align:center; color:#333; font-size:18px;">No records to show</div>
                                @if($search)
                                    <div style="text-align:center; color:#333; font-size:18px">for {{ $search }}</div>
                                @endif
                            @endif
                        </div>
                        {!! str_replace('/?', '?', $taxes->render()) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection