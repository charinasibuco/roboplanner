@extends('frontend.layouts.template')

@section('title', 'Home')
@section('styles')

@section('content')
<div class="banner overview sub-banner-background">
	<div class="row">
		<div class="col-sm-12 description">
			<h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum 
				<br>Portfolio</h1>
		</div>
	</div>
</div>
<div class="container">
	<div class="row row-box">
		<div class="col-sm-6">
			<h1>Portfolio</h1>
			<p>Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero, non dignissim ipsum leo in lectus.</p>
		</div>
		<div class="col-sm-6">
			<img src="http://placehold.it/700x293">
		</div>
	</div>
{{-- </div>
<div class="container-fluid"> --}}
	<hr>
	<div class="row center-title">
		<div class="col-sm-12 box-padding">
			<div class="row">
				<h1>Lorem ipsum dolor sit amet, Etiam rutrum nisi euuris nulla</h1>
			</div>
			<div class="row">
				<div class="col-sm-3 box-padding round-holder">
					<div class="row">
						{{-- <i class="fa fa-square-o" aria-hidden="true"></i> --}}
						<div class="round-small image-center">
							<img src="{{ asset('images/home_finance_offer_icon_2.png')}}" >
						</div>
					</div>
					<div class="row">
						<h3>Lorem ipsum dolor sit amet.</h3>
						<p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
						<button class="btn btn-primary">Read More >></button>
					</div>
				</div>
				<div class="col-sm-3 box-padding round-holder">
					<div class="row">
						<div class="round-small image-center">
							<img src="{{ asset('images/bank_2.png')}}" >
						</div>
					</div>
					<div class="row">
						<h3>Lorem ipsum dolor sit amet.</h3>
						<p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
						<button class="btn btn-primary">Read More >></button>
					</div>
				</div>
				<div class="col-sm-3 box-padding round-holder">
					<div class="row">
						<div class="round-small image-center">
							<img src="{{ asset('images/Bar-graph-arrow-2.png')}}" >
						</div>
					</div>
					<div class="row">
						<h3>Lorem ipsum dolor sit amet.</h3>
						<p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
						<button class="btn btn-primary">Read More >></button>
					</div>
				</div>
				<div class="col-sm-3 box-padding round-holder">
					<div class="row">
						<div class="round-small image-center">
							<img src="{{ asset('images/money-bag-2.png')}}" >
						</div>
					</div>
					<div class="row">
						<h3>Lorem ipsum dolor sit amet.</h3>
						<p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
						<button class="btn btn-primary">Read More >></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row box-padding">
		<div class="col-sm-12 center-title">
			<h1>Quisque elementum eget mi non mattis. Interdum et malesuada fames</h1>
			<h3>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</h3>
		</div>
	</div>
</div>
@stop