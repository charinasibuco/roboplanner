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
					<form action="{{ $action }}" method="post">
						<div class="form-group">
							<label for="name">Name: </label><input class="form-control" type="text" name="name" id="name" value="{{ $name }}" required>
						</div>
						<div class="form-group">
							<label for="description">Description: </label><input class="form-control" type="text" name="description" id="description" value="{{ $description }}">
						</div>
						<div class="form-group">
							<label for="value">Value: </label><input class="form-control" type="text" name="value" id="value" value="{{ $value }}">
						</div>
						{!! csrf_field() !!}
						<input type="submit" class="btn btn-primary" value="{{ $header }}">
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection
@section('scripts')
	<script type="text/javascript" src="{{ asset('js/lib/jquery.validate.js') }}"></script>
	<script>
		// $(document).ready(function(){
		// 	$.get($get_values,function($data){
		// 		$values = JSON.parse($data);
		// 		$.each($values,function($index,$value){
					
		// 		});
		// 	});
		// });
		$unique_name = "{{  route('check_unique_name') }}";
		$header = "{{ $header }}";
		$id = "{{ $id or '' }}";
		$token = "{{ csrf_token() }}";
		$("form").validate({
			rules: {
				name: {
					remote: {
						type: "POST",
						url: $unique_name,
						dataType: "json",
						data: {
							name:function(){
								return $("input[name='name']").val();
							},
							header: function(){
								return $header;
							},
							id: function(){
								return $id;
							},
							_token: function(){
								return $token;
							}
						}
					}
				}
			},
			messages: {
				name:{
					remote: "Name is already Taken."
				}
			}
		});
	</script>

@endsection