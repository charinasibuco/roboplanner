@extends('roboplanner.layouts.template')
@section('title', 'Post')
@section('styles')
<style type="text/css">
.dropdown-menu {
  top:40px;
}
</style>
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
      <div class="navbar navbar-default bootstrap-admin-navbar-thin">
        <ol class="breadcrumb bootstrap-admin-breadcrumb">
          <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="active">Post</li>
        </ol>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default bootstrap-admin-no-table-panel">
          <div class="panel-heading">
            <div class="text-muted bootstrap-admin-box-title">Post</div>
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
              <div class="row">
                <div class="col-sm-6">
                  <a href="{{ route('post_create')}}" class="btn btn-primary"><i class="fa fa-file-text" aria-hidden="true"></i> &nbsp; Create Post</a>
                </div>
                <div class="col-sm-6">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  
                </div>
              </div>
              {{--{{ $posts->render() }}--}}
              <div class="row">
                <div class="col-sm-12">
                  <table width="100%" class="table table-striped table-hover">
                    <thead>
                    <tr>
                      <th width="15%"></th>
                      <th width="50%">Title</th>
                      <th width="10%">Status</th>
                      <th width="15%">Created</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                      <tr>
                        <td class="dropdown">
                          <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                            Options<span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a href="{{ route('post_edit', $post->id)}}">Edit</a></li>
                            <li><a href ="{{ route('post_delete', $post->id)}}"class="delete_confirmation" href="" onclick="return confirm('Are you sure you want to Delete this Post?')">Delete</a></li>
                          </ul>
                        </td>
                        <td>
                          {{$post->title}}<br>
                          <small><strong>Category: </strong> @foreach($post->Categories as $category)
                            {{ $category->title}} </br>
                            @endforeach</small>
                        </td>


                        <td> {{$post->status}} </td>
                        <td> {{$post->created_at->format('m/d/Y')}} <br><small>{{$post->created_at->diffForHumans()}}</small> </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                  @if($posts->count() == 0)
                    <div style="text-align:center; color:#333; font-size:18px">No records to show</div>
                  {{--   @if($search)
                      <div style="text-align:center; color:#333; font-size:18px">for {{ $search }}</div>
                    @endif --}}
                  @endif
                  {!! str_replace('/?', '?', $posts->render()) !!}
                </div>
              </div>
          </div>
        </div>
    </div>
  </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/application.js') }}"></script>
@stop