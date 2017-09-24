@extends('frontend.layouts.template')

@section('title', 'Home')
@section('styles')

@section('content')
<div class="banner expert sub-banner-background">
	<div class="row">
		<div class="col-sm-12 description">
			<h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum 
				<br>Team and Experts</h1>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12 text-center">
			<h1>A World Class Team</h1>
			<h3>A team of workaholics cultivating the optimal service for Fox River Capital clients.</h3>
		</div>
	</div>
	<hr>
	<div class="row box-padding center-title image-center">
		<div class="col-sm-4">
			<div class="row circle">
				<div class="round" data-toggle="modal" data-target="#eric"> 
					<img src="{{ asset('images/owner/Eric-square.gif')}}">
					<div style="padding-top:120px; font-size:30px">
						<i class="fa fa-user" aria-hidden="true"></i> 
						View Profile
					</div>
				</div>
			</div>
			<div class="row">
				<p><b>Eric Sajdak, ChFC®</b></p>
				<cite>Partner | CIO | Director of College Planning</cite>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="row circle">
				<div class="round" data-toggle="modal" data-target="#parker"> 
					<img src="{{ asset('images/owner/Parker-square.gif')}}">
					<div style="padding-top:120px; font-size:30px">
						<i class="fa fa-user" aria-hidden="true"></i> 
						View Profile
					</div>
				</div>
			</div>

			<div class="row">
				<p><b>Parker Lenz, AWMA®</b></p>
				<cite>Partner | Director of Wealth Management</cite> 
			</div>
		</div>
		<div class="col-sm-4">
			<div class="row circle">
				<div class="round" data-toggle="modal" data-target="#anthony">
					<img src="{{ asset('images/owner/Tony-square.gif')}}">
					<div style="padding-top:120px; font-size:30px">
						<i class="fa fa-user" aria-hidden="true"></i> 
						View Profile
					</div>
				</div>
			</div>
			<div class="row">
				<p><b>Anthony Hellenbrand, RICP®</b></p>
				<cite>Partner | Director of Retirement Planning</cite>
			</div>
		</div>
	</div>
</div>
<!-- Eric Modal -->
<div id="eric" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content" style="padding:20px 40px 20px 40px">
      	<div class="modal-header text-center">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<div class="row circle">
				<div class="round2"> 
					<img src="{{ asset('images/owner/Eric-square.gif')}}">
				</div>
			</div>
        	<h2 class="modal-title ">Eric Sajdak, ChFC®</h2>
        	<cite>Partner | CIO | Director of College Planning</cite>
      	</div>
      	<div class="modal-body">
	        <p style="text-align:justify">Eric Sajdak is a Partner at Fox River Capital and heads its investment and college planning division. He has earned his Chartered Financial Consultant designation, ChFC® from the American College. Eric has been managing client portfolios and preparing investment research since high school. Prior to working at Fox River Capital, he worked in the financial planning division for a Fortune 500 company. Outside of the office, you can find Eric competing in endurance sports, hitting up the slopes, or watching the Packers. Eric currently lives in Appleton, Wisconsin.</p>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-primary" data-dismiss="modal">CLOSE</button>
    	</div>
    </div>
  </div>
</div>
<!-- Parker  Modal -->
<div id="parker" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content" style="padding:20px 40px 20px 40px">
      	<div class="modal-header text-center">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<div class="row circle">
				<div class="round2"> 
					<img src="{{ asset('images/owner/Parker-square.gif')}}">
				</div>
			</div>
        	<h2 class="modal-title ">Parker Lenz, AWMA®</h2>
        	<cite>Partner | Director of Wealth Management</cite>
      	</div>
      	<div class="modal-body">
	        <p style="text-align:justify">Parker Lenz is a Partner at Fox River Capital. He has earned the Accredited Wealth Management Advisor SM designation, AWMA®, from the College for Financial Planning. During his time pursuing a finance degree at the University of Wisconsin Oshkosh, Parker was a member of a student team that managed a portion of the university‘s endowment through the Managed Endowment Fund. Parker is an accomplished Eagle Scout, and in his spare time, you can find him cycling, boating, or sailing. He currently lives in Appleton, WI.</p>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-primary" data-dismiss="modal">CLOSE</button>
    	</div>
    </div>
  </div>
</div>
<!-- Parker  Modal -->
<div id="anthony" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content" style="padding:20px 40px 20px 40px">
      	<div class="modal-header text-center">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<div class="row circle">
				<div class="round2"> 
					<img src="{{ asset('images/owner/Tony-square.gif')}}">
				</div>
			</div>
        	<h2 class="modal-title ">Anthony Hellenbrand, RICP®</h2>
        	<cite>Partner | Director of Retirement Planning</cite>
      	</div>
      	<div class="modal-body">
	        <p style="text-align:justify">Tony Hellenbrand is a Partner at Fox River Capital. Tony graduated from Michigan Technological University, where he studied finance. Tony's specialty is working with business owners and helping them plan for their succession, exit and retirement. He has the Retirement Income Certified Professional, RICP® designation from the American College. When the market’s closed, Tony likes to shoot sporting clays, fish, and go to Packer and Badger Football games. Tony and his wife, Kristin, live in De Pere, Wisconsin.</p>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-primary" data-dismiss="modal">CLOSE</button>
    	</div>
    </div>
  </div>
</div>
@stop