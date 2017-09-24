@extends('frontend.layouts.template')

@section('title', 'Home')
@section('styles')

@section('content')
@foreach($pages as $page)
<div class="banner overview sub-banner-background">
	<div class="row">
		<div class="col-sm-12 description">
			<h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum 
				<br> {{ $page->title }} </h1>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-4">{!! htmlspecialchars_decode($page->content) !!}</div>
		<div class="col-sm-4">{!! htmlspecialchars_decode($page->content) !!}</div>
		<div class="col-sm-4">{!! htmlspecialchars_decode($page->content) !!}</div>
	</div>
</div>
@endforeach
@section('scripts')
<script type="text/javascript">

</script>
@stop