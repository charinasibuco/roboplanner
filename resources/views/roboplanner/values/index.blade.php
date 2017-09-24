@extends('roboplanner.layouts.template')
@section('title', $header)
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="navbar navbar-default bootstrap-admin-navbar-thin">
				<ol class="breadcrumb bootstrap-admin-breadcrumb">
					<li><a href="{{ route('dashboard') }}">Dashboard</a></li>
					<li><a href="{{ route('value_list') }}">Values</a></li>
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
						<div class="text-muted bootstrap-admin-box-title">{{ $header }} &nbsp;<a href="{{ route('value_add') }}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add Values</a></div>
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
						<form action="{{ $action }}" method="post">
							@foreach($values as $value)
								<div class="form-group">
									<label for="{{ $value['slug'] }}">
										<div class="btn-group">
											<a href="{{ route('value_edit',$value['id']) }}" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
											</a>
											<a href="javascript:void(0)" onclick="confirmDelete('{{ route('value_delete',$value['id']) }}')" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i>
											</a>
										</div>
										{{ $value['name'] }}:
									</label>
									<input type="text" class="form-control" name="{{ $value['slug'] }}" id="{{ $value['slug'] }}" value="{{ $value['value'] }}" placeholder="{{ $value['description'] }}">
								</div>
							@endforeach
							{!! csrf_field() !!}
							<input type="submit" class="btn btn-primary" value="{{ $header  }} Values">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
@section('scripts')
	<script type="text/javascript" src="{{ asset('js/lib/jquery.validate.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/extensions/bootbox.min.js') }}"></script>
	<script>
		$("form").validate();

		confirmDelete = function($post){
			bootbox.confirm({
				message: "Are you sure you want to delete this Value?",
				callback: function (result) {
					if(result){
						window.location.href = $post;
					}
					console.log('This was logged in the callback: ' + result);
				}
			});
		};
	</script>

@endsection