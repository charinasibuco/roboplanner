@extends('frontend.layouts.template')

@section('title', 'Home')
@section('styles')

@section('content')
<div class="banner overview sub-banner-background">
	<div class="row">
		<div class="col-sm-12 description">
			<h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum 
				<br> Security </h1>
		</div>
	</div>
</div>
<div class="container">
	<div class="row box-padding">
		<div class="col-sm-3">
			<div class="content-box image-center">
				<div class="row">
					<div class="image-center">
						<img src="{{ asset('images/bulb.png')}}">
					</div>
				</div>
				<div class="row">
					<h3 class="text-center">Consectetuer Adipiscing</h3>
					<p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
				</div>
				<div class="arrow">
					<div class="row">
						<img src="{{ asset('images/drop-down.png')}}">
					</div>
					<div class="row" id="content" style="display:none">
						<hr>
						<p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="content-box image-center">
				<div class="row">
					<div class="image-center">
						<img src="{{ asset('images/clock.png')}}">
					</div>
				</div>
				<div class="row">
					<h3 class="text-center">Consectetuer Adipiscing</h3>
					<p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
				</div>
				<div class="arrow">
					<div class="row">
						<img src="{{ asset('images/drop-down.png')}}">
					</div>
					<div class="row" id="content" style="display:none">
						<hr>
						<p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="content-box image-center">
				<div class="row">
					<div class="image-center">
						<img src="{{ asset('images/globe.png')}}">
					</div>
				</div>
				<div class="row">
				<h3 class="text-center">Consectetuer Adipiscing</h3>
				<p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
				</div>
				<div class="arrow">
					<div class="row">
						<img src="{{ asset('images/drop-down.png')}}">
					</div>
					<div class="row" id="content" style="display:none">
						<hr>
						<p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="content-box image-center">
				<div class="row">
					<div class="image-center">
						<img src="{{ asset('images/bulb.png')}}">
					</div>
				</div>
				<div class="row">
				<h3 class="text-center">Consectetuer Adipiscing</h3>
				<p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
				</div>
				<div class="arrow">
					<div class="row">
						<img src="{{ asset('images/drop-down.png')}}">
					</div>
					<div class="row" id="content" style="display:none">
						<hr>
						<p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row row-box">
		<div class="col-sm-6">
			<h1>Ipsum dolor sit amet ipsum </h1>
			<p style="text-align:justify">Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero, non dignissim ipsum leo in lectus.</p>
			<button class="btn  btn-primary pull-right"> READ MORE</button>
		</div>
		<div class="col-sm-6">
			<h1>Ipsum dolor sit amet ipsum </h1>
			<p style="text-align:justify">Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero, non dignissim ipsum leo in lectus.</p>
			<button class="btn  btn-primary pull-right"> READ MORE</button>
		</div>
	</div>
</div>
<div class="river sub-banner banner-text">
	<div class="col-sm-2"></div>
	<div class="col-sm-8 top">
		<p class="big-title white-font shadow">Ipsum dolor sit amet ipsum laoreet. Quisque elementum eget mi non mattis</p>
	</div>
	<div class="col-sm-2"></div>
</div>
@stop