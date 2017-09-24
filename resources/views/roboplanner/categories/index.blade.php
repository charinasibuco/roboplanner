@extends('roboplanner.layouts.template')
@section('title', 'Categories')


@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="navbar navbar-default bootstrap-admin-navbar-thin">
            <ol class="breadcrumb bootstrap-admin-breadcrumb">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="active">Categories</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default bootstrap-admin-no-table-panel">
            <div class="panel panel-default bootstrap-admin-no-table-panel">
                <div class="panel-heading">
                    <div class="text-muted bootstrap-admin-box-title">Categories List</div>
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
                        @can("add_category")<a class="btn btn-primary" title="Add a Category" href="{{ route('category_add')}}"><i class="fa fa-plus"></i> &nbsp;Add Category</a>@endcan
                    </div>
                    <div class="col-sm-6">
                        <form method="get" action="{{ route('category_list')}}">
                            <div class="search form-group" style="float:right">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                                    <input type="text" class="search-form form-control" placeholder="Search" name="search" aria-describedby="basic-addon1" value="{{ $search }}">
                        {{--<span class="input-group-btn clearer">
                            <button class="btn btn-primary" type="button" style="border:none; background-color:transparent; z-index:999; margin-left:-35px; font-size:10px"><a href="{{ route('category_list') }}">X</a></button>
                        </span>--}}
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
                                <th><a href="{{ route('category_list').'?page='.$page_number.'&search='.$search.'&order_by=parent_id&sort='.$sort }}">Parent</a></th>
                                <th><a href="{{ route('category_list').'?page='.$page_number.'&search='.$search.'&order_by=title&sort='.$sort }}">Title</a></th>
                                <th><a href="{{ route('category_list').'?page='.$page_number.'&search='.$search.'&order_by=slug&sort='.$sort }}">Slug</a></th>
                                <th><a href="{{ route('category_list').'?page='.$page_number.'&search='.$search.'&order_by=sort&sort='.$sort }}">Sort</a></th>
                                <th><a href="{{ route('category_list').'?page='.$page_number.'&search='.$search.'&order_by=description&sort='.$sort }}">Description</a></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $row)
                                <tr>
                                    <td>@can("update_category")<a href="{{ route('category_edit', $row->id)}}"><i class="fa fa-lg fa-pencil-square-o"></i></a>@endcan | @can("delete_category")<a href="{{ route('category_delete', $row->id) }}" onclick="return confirm('Are you sure you want to Delete this category?')"><i class="fa fa-lg fa-times"></i></a>@endcan </td>
                                    <td>{{ $row->parent->title or "" }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->slug }}</td>
                                    <td>{{ $row->sort }}</td>
                                    <td>{{ $row->description }}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($categories->count() == 0)
                            <div style="text-align:center; color:#333; font-size:18px">No records to show</div>
                            @if($search)
                                <div style="text-align:center; color:#333; font-size:18px">for {{ $search }}</div>
                            @endif
                        @endif
                    </div>
                    {!! str_replace('/?', '?', $categories->render()) !!}
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
