@extends('frontend.layouts.template')

@section('title', 'Home')
@section('styles')

@section('content')
<div class="banner book sub-banner-background">
	<div class="row">
		<div class="col-sm-12 description">
			<h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum 
				<br> Book </h1>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12 text-center">
			<h1>Books Written by the <br>Fox River Capital Team</h1>
		</div>
	</div>
	<div class="row row-box">
		<div class="col-sm-4">
			<div class="text-center">
				<h2>The College Funding Blueprint</h2>
				<div class="horizontal-line"></div>
				<br>
			<cite>By Eric Sajdak, ChFC®</cite>
			</div>
			<p>The College Funding Blueprint is a result of asking one simple question, “How would a family’s financial situation change if there were able to make college a financial success rather than a financial burden?” This book was created as the answer to that question. It is a collection of knowledge and wisdom from a nationally recognized financial team. Decades of research and experience went into discovering and implementing the concepts and strategies in this book.</p>
		</div>
		<div class="col-sm-4 image-center">
			<img src="{{ asset('images/books/the_college_funding2.png')}}" height="400" width="auto">
		</div>
		<div class="col-sm-4 image-center" id="subscribe">
			<form style="padding:30px" class="blue-background white-font">
				<label>Subscribe to be the First to Get
				Exclusive Access to the Knowledge Center</label>
				<cite>All subscribers will get access to the first 3 chapters of both Conversations that Count and The College Funding Blueprint!  You will also become first in line and get notified of all up and coming webinars, new whitepapers, and much, much more.  Subscribers will also get a special gift for subscribing! </cite><br><br>
				<label>Join the team today!</label>
				<input class="form-control" placeholder="Name"><br>
				<input class="form-control" placeholder="Email"><br>
				{{-- <input class="btn btn-subscribe square" value="SEND"> --}}
				<button class="btn btn-subscribe square">SEND</button>
			</form>
		</div>
	</div>
</div>
<div class="container-fluid ">
	<div class="row row-box" style="padding-left: 10%;padding-right: 10%;">
		<div class="col-sm-4 image-center">
			<img src="{{ asset('images/owner/Eric-square.gif')}}" width="200" height="auto">
			<h2 class="text-center">Author: Eric Sajdak, ChFC®</h2>
			<p>Eric Sajdak is a Partner at Fox River Capital and heads its college planning division. The experiences and situations that him and his team faced led to Eric writing this book to solve the college crisis that so many families are faced with. He has earned his Chartered Financial Consultant designation, ChFC® from the American College.</p>
		</div>
		<div class="col-sm-4">
			<h2>Inside the Book, You'll Learn:</h2>
			<ul class="fa-ul">
			  <li><i class="fa-li fa fa-check"></i>How you can get a sale (discount) off your college bill</li><br>
			  <li><i class="fa-li fa fa-check"></i>The conversion strategy so you can, "have your cake and eat it too"</li><br>
			  <li><i class="fa-li fa fa-check"></i>A recent law change that will massively affect college planning</li><br>
			  <li><i class="fa-li fa fa-check"></i>The fastest way to eliminate college debt</li><br>
			  <li><i class="fa-li fa fa-check"></i>The most optimal college planning strategy</li><br>
			  <li><i class="fa-li fa fa-check"></i>The Triple Deke Strategy</li><br>
			  <li><i class="fa-li fa fa-check"></i>Ways you can get student loan debt forgiven</li><br>
			  <li><i class="fa-li fa fa-check"></i>And much, much more.....</li><br>
			</ul>
		</div>
	</div>
</div>
<div class="container">
	<div class="col-sm-8">
	<hr>
	</div>
	<div class="col-sm-4"></div>
</div>
</div>
<div class="container">
	<div class="row row-box">
		<div class="col-sm-4">
			<div class="text-center">
				<h2>Conversations that Count</h2>
				<div class="horizontal-line"></div>
				<br>
				<cite>By Tony Hellenbrand, RICP®</cite>
			</div>
			<p>This is not a “get rich quick” book. This book is the result of over a decade spent managing investment portfolios for large institutions and high net worth investors from Scottsdale, AZ to Greenwich, CT and planning retirements for real clients in the real world. It is the distilled 20% of questions that yield 80% of results. </p>
		</div>
		<div class="col-sm-4 image-center">
			<img src="{{ asset('images/books/conversations_that_count2.png')}}" height="400" width="auto">
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row row-box" style="padding-left: 10%;padding-right: 10%;">
		<div class="col-sm-4 image-center">
			<img src="{{ asset('images/owner/Tony-square.gif')}}" width="200" height="auto">
			<h2 class="text-center">Author: Tony Hellenbrand, RICP®</h2>
			<p>Tony Hellenbrand is a Partner at Fox River Capital. Tony graduated from Michigan Technological University, where he studied finance. Tony's specialty is working with business owners and helping them plan for their succession, exit, and retirement. He has the Retirement Income Certified Professional, RICP® designation from the American College. When the market’s closed, Tony likes to shoot sporting clays, fish, and go to Packer and Badger Football games. </p>
		</div>
		<div class="col-sm-4">
			<h2>Inside the Book, You'll Learn:</h2>
			<ul class="fa-ul">
			  <li><i class="fa-li fa fa-check"></i>The only part of your financial plan you’re 100% sure to use</li><br>
			  <li><i class="fa-li fa fa-check"></i>How to save $1,200 in the next 12 months</li><br>
			  <li><i class="fa-li fa fa-check"></i>How to get the most out of your largest retirement asset (that no one thinks of)</li><br>
			  <li><i class="fa-li fa fa-check"></i>How to protect yourself from the government's "Nuclear" tax option</li><br>
			  <li><i class="fa-li fa fa-check"></i>How to calculate the total costs of your investment portfolio</li><br>
			  <li><i class="fa-li fa fa-check"></i>How to access your 401(k) before 59 1/2</li><br>
			  <li><i class="fa-li fa fa-check"></i>Find out who your advisor is really working for</li><br>
			  <li><i class="fa-li fa fa-check"></i>And much, much more.....</li><br>
			</ul>
		</div>
		<div class="col-sm-4 image-center" id="subscribe2">
			<form style="padding:30px" class="blue-background white-font">
				<label>Subscribe to be the First to Get
				Exclusive Access to the Knowledge Center</label>
				<cite>All subscribers will get access to the first 3 chapters of both Conversations that Count and The College Funding Blueprint!  You will also become first in line and get notified of all up and coming webinars, new whitepapers, and much, much more.  Subscribers will also get a special gift for subscribing! </cite><br><br>
				<label>Join the team today!</label>
				<input class="form-control" placeholder="Name"><br>
				<input class="form-control" placeholder="Email"><br>
				{{-- <input class="btn btn-subscribe square" value="SEND"> --}}
				<button class="btn btn-subscribe square">SEND</button>
			</form>
		</div>
	</div>
</div>
@stop