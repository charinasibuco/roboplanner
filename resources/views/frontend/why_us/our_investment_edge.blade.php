@extends('frontend.layouts.template')

@section('title', 'Home')
@section('styles')

@section('content')
<div class="banner overview sub-banner-background">
	<div class="row">
		<div class="col-sm-12 description">
			<h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum 
				<br> Overview</h1>
		</div>
	</div>
</div>
<div class="container">
	<div class="row row-box">
		<div class="col-sm-6">
			{{-- <img src="" class="image-holder" align="center"> --}}
			{{-- <div class="image-description">text</div> --}}
			<img src="http://placehold.it/479x293">
		</div>
		<div class="col-sm-6">
			<h1>Overview</h1>
			<p>Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero, non dignissim ipsum leo in lectus.</p>
			<br>
			<h3>Overview</h3>
			<p>Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero,</p>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row computer-background sub-banner banner-text row-shadow">
		<div class="col-sm-2"></div>
		<div class="col-sm-8 top">
			<p class="big-title white-font shadow">Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis</p>
		</div>
		<div class="col-sm-2"></div>
	</div>
</div>
<div class="container">
	<div class="row row-box">
		<div class="col-sm-6">
			<h1>Overview</h1>
			<p>Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero, non dignissim ipsum leo in lectus.</p>
			<br>
			<h3>Overview</h3>
			<p>Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero,</p>
		</div>
		<div class="col-sm-6">
			<img src="http://placehold.it/479x293">
			{{-- <div class="image-description">text</div> --}}
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row blue-background row-shadow text-center">
		<div class="col-sm-12 box-padding white-font">
			<div class="row">
				<h1>Lorem ipsum dolor sit amet, Etiam rutrum nisi euuris nulla</h1>
			</div>
			<div class="row">
				<div class="col-sm-4 box-padding">
				<div class="row">
					<i class="fa fa-square-o" aria-hidden="true"></i>
				</div>
					<div class="row">
						<h3>Lorem ipsum dolor sit amet.</h3>
						<p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
					</div>
				</div>
				<div class="col-sm-4 box-padding">
					<div class="row">
						<i class="fa fa-square-o" aria-hidden="true"></i>
					</div>
					<div class="row">
						<h3>Lorem ipsum dolor sit amet.</h3>
						<p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
					</div>
				</div>
				<div class="col-sm-4 box-padding">
					<div class="row">
						<i class="fa fa-square-o" aria-hidden="true"></i>
					</div>
					<div class="row">
						<h3>Lorem ipsum dolor sit amet.</h3>
						<p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row box-padding">
		<div class="col-sm-12 center-title">
			<h1>Quisque elementum eget mi non mattis. Interdum et malesuada fames</h1>
			<h3>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</h3>
		</div>
	</div>
	<hr>
	<div class="row box-padding center-title">
		<div class="col-sm-3">
			<div class="round"> 
				<img src="{{ asset('images/default_user.png')}}">
			</div>
			<p>FirstName LastName</p>
			<cite>Position</cite>
		</div>
		<div class="col-sm-3">
			<div class="round">
				<img src="{{ asset('images/default_user.png')}}">
			</div>
			<p>FirstName LastName</p>
			<cite>Position</cite>
		</div>
		<div class="col-sm-3">
			<div class="round">
				<img src="{{ asset('images/default_user.png')}}">
			</div>
			<p>FirstName LastName</p>
			<cite>Position</cite>
		</div>
		<div class="col-sm-3">
			<div class="round">
				<img src="{{ asset('images/default_user.png')}}">
			</div>
			<p>FirstName LastName</p>
			<cite>Position</cite>
		</div>
	</div>
</div>
@stop