@extends('frontend.layouts.template')

@section('title', 'Home')
@section('styles')

@section('content')
<div class="banner overview sub-banner-background">
	<div class="row">
		<div class="col-sm-12 description">
			<h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum 
				<br> White Paper </h1>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12 text-center">
			<h2>Our Latest Whitepapers</h2>
		</div>
	</div>
	<div class="row box-padding" id="book">
		<div class="col-sm-4">
			<div class="content-box image-center faid-in-left">
				<div class="row">
					<div class="image-center">
						<img src="{{ asset('images/whitepaper/investment_secrets_of_the_wealthy.png')}}">
					</div>
				</div>
				<div class="row">
					<h3 class="text-center">Investment Secrets of the Wealthy</h3>
					<div class="arrow">
						<div class="row">
							<img src="{{ asset('images/drop-down.png')}}" title="Click for Details">
							<hr>
						</div>
						<div class="row" id="content" style="display:none">
							<p>The Investment Secrets socof the Wealthy is all about decoding the habits and secrets of the world's best investors.  In this whitepaper we discuss concepts like strategic diversification, how to profit in bear markets, and how to unhitch your investments from the crowd.  If you're an investor, this guide is a must for achieving investment success.</p>
						</div>
					</div>
				</div>
				<div class="row">
					<a href="{{ route('preview_investment_secret')}}" target="_blank">
						<button class="btn btn-primary">VIEW PDF
						<i class="fa fa-eye" aria-hidden="true"></i>
						</button>
					</a>
					<a href="//storage.googleapis.com/instapage-user-media/8b404141/7146653-0-Investment-Secrets-o.pdf" target="_blank">
						<button class="btn btn-success">DOWNLOAD PDF 
						<i class="fa fa-cloud-download" aria-hidden="true">	</i>
						</button>
					</a>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="content-box image-center fade-in">
				<div class="row">
					<div class="image-center">
						<img src="{{ asset('images/whitepaper/social_security_guide.png')}}">
					</div>
				</div>
				<div class="row">
					<h3 class="text-center">Social Security Guide</h3>
					
					<div class="arrow">
						<div class="row">
							<img src="{{ asset('images/drop-down.png')}}">
							<hr>
						</div>
						<div class="row" id="content" style="display:none">
							<p>Think Social Security is broke?  Think again.  This guide dives deep into one of your largest assets in retirement and explores how you can recieve the highest benefit from Social Security. Timing Social Security properly could mean a 76% higher benefit each and every year for the rest of your life.</p>
						</div>
					</div>
				</div>
				<div class="row">
					<a href="{{ route('social_security_guide')}}" target="_blank">
						<button class="btn btn-primary">VIEW PDF
						<i class="fa fa-eye" aria-hidden="true"></i>
						</button>
					</a>
					<a href="//storage.googleapis.com/instapage-user-media/8b404141/7146128-0-social-security-guid.pdf" target="_blank">
						<button class="btn btn-success">DOWNLOAD PDF 
						<i class="fa fa-cloud-download" aria-hidden="true">	</i>
						</button>
					</a>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="content-box image-center faid-in-right">
				<div class="row">
					<div class="image-center">
						<img src="{{ asset('images/whitepaper/the_mutual_fund_fantasy.png')}}">
					</div>
				</div>
				<div class="row">
					<h3 class="text-center">The Mutual Fund Fantasy</h3>
					<div class="arrow">
						<div class="row">
							<img src="{{ asset('images/drop-down.png')}}">
							<hr>
						</div>
						<div class="row" id="content" style="display:none">
							<p>The Mutual Fund Fantasy was written to expose the unfortunate reality of investing in mutual funds.  High fees, poor performance, and investor deception define an overwhelming number of mutual funds.  If you're an investor that is investing in mutual funds, have invested in them, or are debating about investing, this is a must-read.</p>
						</div>
					</div>
				</div>
				<div class="row">
					<a href="{{ route('the_mutual_fund')}}" target="_blank">
						<button class="btn btn-primary">VIEW PDF
						<i class="fa fa-eye" aria-hidden="true"></i>
						</button>
					</a>
					<a href="//storage.googleapis.com/instapage-user-media/8b404141/7146168-0-The-Mutual-Fund-Fant.pdf" target="_blank">
						<button class="btn btn-success">DOWNLOAD PDF 
						<i class="fa fa-cloud-download" aria-hidden="true">	</i>
						</button>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2">
		</div>
		<div class="col-sm-4">
			<div class="content-box image-center" id="left">
				<div class="row">
					<div class="image-center">
						<img src="{{ asset('images/whitepaper/protecting_your_assets_from_the_nursing_home.png')}}">
					</div>
				</div>
				<div class="row" id="book">
					<h3 class="text-center">Protecting Your Ass(ets) from the Nursing Home</h3>
					<div class="arrow">
						<div class="row">
							<img src="{{ asset('images/drop-down.png')}}">
							<hr>
						</div>
						<div class="row" id="content" style="display:none">
							<p>With the cost of a private room in a nursing home being over $70,000 per year, long-term care has moved to being a top priority for retirees.  The U.S. Government estimates that almost 70% of retirees will need some form of a long-term care at some point in life.  If you have any interest in securing a safe retirement, this whitepaper on long-term care is for you.</p>
						</div>
					</div>
				</div>
				<div class="row">
					<a href="{{ route('protecting_your_asset')}}" target="_blank">
						<button class="btn btn-primary">VIEW PDF
						<i class="fa fa-eye" aria-hidden="true"></i>
						</button>
					</a>
					<a href="//storage.googleapis.com/instapage-user-media/8b404141/7146143-0-protecting-your-ass-.pdf" target="_blank">
						<button class="btn btn-success">DOWNLOAD PDF 
						<i class="fa fa-cloud-download" aria-hidden="true">	</i>
						</button>
					</a>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="content-box image-center" id="right">
				<div class="row">
					<div class="image-center">
						<img src="{{ asset('images/whitepaper/the_bear_market_survival_guide.png')}}">
					</div>
				</div>
				<div class="row" id="book">
					<h3 class="text-center">The Bear Market Survival <br>Guide</h3>
					<div class="arrow">
						<div class="row">
							<img src="{{ asset('images/drop-down.png')}}">
							<hr>
						</div>
						<div class="row" id="content" style="display:none">
							<p>How did your portfolio handle the recession of '08?  What about the tech bubble of the early 2000's?  If your like most investors, your portfolio didn't fare well.  The reason?  You haven't implemented the right tools and strategies to protect your portfolio.  Download the Bear Market Survival guide today to learn how you can protect and profit from the next bear market.  Yes, I said even profit.</p>
						</div>
					</div>
				</div>
				<div class="row">
					<a href="{{ route('bear_market_survival')}}" target="_blank">
						<button class="btn btn-primary">VIEW PDF
						<i class="fa fa-eye" aria-hidden="true"></i>
						</button>
					</a>
					<a href="//storage.googleapis.com/instapage-user-media/8b404141/7146208-0-Bear-Market-Survival.pdf" target="_blank">
						<button class="btn btn-success">DOWNLOAD PDF 
						<i class="fa fa-cloud-download" aria-hidden="true">	</i>
						</button>
					</a>
				</div>
			</div>
		</div>
		<div class="col-sm-2">
		</div>
	</div>
</div>
@stop