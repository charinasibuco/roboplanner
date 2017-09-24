@extends('frontend.layouts.template')

@section('title', 'Home')
@section('styles')

@section('content')
<div class="banner overview sub-banner-background">
	<div class="row">
		<div class="col-sm-12 description">
			<h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum 
				<br> Webinar </h1>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-6" style="padding:30px 50px 30px 50px">
			<div class="row">
				<h1>The Latest Webinars</h1>
			</div>
			<div class="row">
				<iframe width="100%" height="500px" src="https://www.youtube.com/embed/zui6xUrztFs" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="row">
				<h2 class="text-center" style="padding:0 50px 0 50px">The Fox River Wealth Wheel Introductory Webinar</h2>
				<div class="horizontal-line"></div>
				<p style="min-height:160px">The Wealth Wheel is a concept developed by the Fox River Capital team to act as a comprehensive guide to help families through the lifecycle of their financial careers.  Many families think they have a comprehensive financial plan when all they truly have is a set of tactics.  Gain peace of mind today by watching and implementing the Wealth Wheel.</p>
			</div>
			<div class="row">
				<h2>Interested in dominating your finances?</h2>
				<cite>What if making one simple hour, one simple decision could change the trajectory of your financial life?  Are you bold enough to make that decision?  You tell me.</cite> <br> <br>
				<button class="btn btn-primary" data-toggle="modal" data-target="#form">It's Time for a Change</button>
			</div>
			<!-- Modal -->
			<div id="form" class="modal fade" role="dialog">
			  <div class="modal-dialog">
			    <!-- Modal content-->
			    <div class="modal-content blue-background" style="padding:20px 40px 20px 40px">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal">&times;</button>
			        	<h2 class="modal-title text-center white-font">Let's Get in Touch</h2>
			      	</div>
			      	<div class="modal-body">
				        <form style="padding:20px">
				        	<input class="form-control" value="" placeholder="Name"><br>
				        	<input class="form-control" value="" placeholder="Email">
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-warning" data-dismiss="modal">CANCEL</button>
			        	<input type="submit" class="btn btn-subscribe square" value="SEND">
			    	</div>
			    		</form>
			    </div>
			  </div>
			</div>
		</div>
		<div class="col-sm-6" style="padding:30px 50px 30px 50px">
			<div class="row">
				<h1>College Planning Webinars</h1>
			</div>
			<div class="row">
				<iframe width="100%" height="500px" src="https://www.youtube.com/embed/-3f8-XRHfSc" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="row">
				<h2 class="text-center" style="padding:0 50px 0 50px">The College Funding Blueprint Webinar</h2>
				<div class="horizontal-line"></div>
				<p style="min-height:160px">The College Funding Blueprint is a book written by Fox River Capital's Director of College Planning, Eric Sajdak ChFC®.  This webinar goes through each section of the book explaining key points and concepts.  It shows strategies for maximizing your child's financial aid package, graduating debt-free, and stretching your family's dollar the furthest.  All of things work in unison to help may college your family's greatest investment!</p>
			</div>
			<div class="row">
				<h2>I Want to Dominate College</h2>
				<cite>I want to my family to leave college debt free.  I want it to be my family's best investment.  College is one of my biggest headaches and that needs to change.</cite> <br> <br>
				<button class="btn btn-primary" data-toggle="modal" data-target="#form">It's Time for a Change</button>
			</div>
		</div>
	</div>
</div>
@stop