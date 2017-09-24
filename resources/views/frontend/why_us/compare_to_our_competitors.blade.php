@extends('frontend.layouts.template')

@section('title', 'Home')
@section('styles')

@section('content')
<div class="banner overview sub-banner-background">
	<div class="row">
		<div class="col-sm-12 description">
			<h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum 
				<br>Tax Efficient Investing</h1>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h2 class="text-center">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h2>
		</div>
	</div>
	<div class="row box-padding">
		<div class="col-sm-4">
			<div class="content-box">
				<div class="row">
					<div class="image-center">
						<img src="{{ asset('images/bulb.png')}}">
					</div>
				</div>
				<div class="row">
					<h3 class="text-center">Consectetuer Adipiscing</h3>
					<p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="content-box">
				<div class="row">
					<div class="image-center">
						<img src="{{ asset('images/clock.png')}}">
					</div>
				</div>
				<div class="row">
					<h3 class="text-center">Consectetuer Adipiscing</h3>
					<p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="content-box">
				<div class="row">
					<div class="image-center">
						<img src="{{ asset('images/globe.png')}}">
					</div>
				</div>
				<div class="row">
				<h3 class="text-center">Consectetuer Adipiscing</h3>
				<p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row box-padding">
		<div class="row">
			<div class="col-sm-6">
				<h1>Tax Efficient Investing</h1>
			</div>
			<div class="col-sm-6">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-12">
						<img src="http://placehold.it/479x300" style="float:left; width:100%">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 text-center">
						<p class="sub-title">Ipsum dolor sit ipsum dololor</p>
						<p style="font-size:20px">Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit.</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-12">
						<img src="http://placehold.it/479x300" style="float:left; width:100%">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 text-center">
						<p class="sub-title">Ipsum dolor sit ipsum dololor</p>
						<p style="font-size:20px">Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row river sub-banner banner-text row-shadow">
		<div class="col-sm-2"></div>
		<div class="col-sm-8 top">
			<p class="big-title white-font shadow">Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis</p>
			<button class="btn btn-primary">READ MORE</button>
		</div>
		<div class="col-sm-2"></div>
	</div>
	<div class="row box-padding">
		<div class="col-sm-12 center-title">
			<h1>Quisque elementum eget mi non mattis. Interdum et malesuada fames</h1>
			<h3>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</h3>
		</div>
	</div>
</div>
@stop