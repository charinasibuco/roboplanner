@extends('roboplanner.layouts.template')
@section('title', $header)
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="navbar navbar-default bootstrap-admin-navbar-thin">
				<ol class="breadcrumb bootstrap-admin-breadcrumb">
					<li><a href="{{ route('dashboard') }}">Dashboard</a></li>
					<li><a href="{{ route('category_list') }}">Categories</a></li>
					<li class="active">{{ $header }}</li>
				</ol>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default bootstrap-admin-no-table-panel">
				<div class="panel panel-default bootstrap-admin-no-table-panel">
					<div class="panel-heading">
						<div class="text-muted bootstrap-admin-box-title">{{ $header }}</div>
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
						<form action="{{ $action }}" method="post" class="">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="title">Category Title:</label>
										<input class="form-control" id="title" name="title" placeholder="Category Title" value="{{ $category->title or old('title') }}">
									</div>
									<div class="form-group">
										<label for="parent_id">Parent Category:</label>
										<select class="form-control" name="parent_id" id="parent_id">
											<option value="0" selected>None</option>
											@if(count($categories) > 0)
												@foreach($categories as $row)
													<option value="{{ $row->id or "" }}" @if(isset($category->parent_id) && ($category->parent_id == $row->id || old('parent_id') == $row->id)) selected @endif>{{ $row->title or "" }}</option>
												@endforeach
											@endif
										</select>
									</div>
									<div class="form-group">
										<label for="slug">Slug:</label>
										<input class="form-control" id="slug" name="slug" placeholder="Category Slug" value="{{ $category->slug or old('slug') }}">
									</div>
									<div class="form-group">
										<label for="sort">Sort:</label>
										<input type="number" class="form-control" id="sort" name="sort" placeholder="Category Sort" value="{{ $category->sort or old('sort') }}">
									</div>
									<div class="form-group">
										<label for="description">Description:</label>
										<input class="form-control" id="description" name="description" placeholder="Category Description" value="{{ $category->description or old('description') }}">
									</div>

								</div>
								<div class="col-md-6">
									&nbsp;
								</div>
							</div>
							{!! csrf_field() !!}
							<button type="submit" class="btn btn-lg btn-primary" >{{ $header }}</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection