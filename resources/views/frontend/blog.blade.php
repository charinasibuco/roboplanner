@extends('frontend.layouts.template')

@section('styles')
@section('content')
<div class="banner overview sub-banner-background">
	<div class="row">
		<div class="col-sm-12 description">
			<h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum 
				<br> Blog </h1>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-4">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-primary">
				      <div class="panel-heading">Categories</div>
						<a href="{{ route('blog')}}"><div class="panel-body" style="border: 1px solid #e5e5e5;">All Post</br>
							</div>
						</a>
				      @foreach($category as $category_post)
					      	{{--@if(isset($category_post->Post->first()->status) && $category_post->Post->first()->status == 'Publish')--}}
								<a href="{{ route('category', $category_post->slug)}}"><div class="panel-body" style="border: 1px solid #e5e5e5;">{{ $category_post->title }} </br>
									</div>
								</a>
							{{--@endif--}}
					  @endforeach
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-primary">
				      <div class="panel-heading">Archive</div>
				      @foreach($archive as $a => $key)
							<a href="{{ route('archive', \Carbon\Carbon::parse($a)->format('m-Y'))}}"><div class="panel-body" style="border: 1px solid #e5e5e5;">{{ $a}}</div></a>
					  @endforeach
				    </div>
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="panel panel-default bootstrap-admin-no-table-panel">
	          	<div class="panel-heading">

	            	<div class="text-muted bootstrap-admin-box-title">{{ isset($posts) ? $posts->total() : '' }} Article{{ ( isset($posts) && $posts->total() > 1) ? 's' : ''}}</div>
		</div>
	           	<div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
					@foreach($posts as $post)
						@if($post->status == 'Publish')
						<div class="row" style="padding:20px; position:relative">
							<div class="col-sm-4">
								<img src="http://placehold.it/200x200">
							</div>
							<div class="col-sm-8">
								<h1>{{ $post->title}} </h1>
								<?php 
									$post->contents = strip_tags($post->contents);
									if (strlen($post->contents) > 500) {
									    $stringCut = substr($post->contents, 0, 500);
									    $post->contents = substr($stringCut, 0, strrpos($stringCut, ' ')).'... ';
									}
									echo '<p>'.$post->contents.'</p>';
								?>
								<p><a href="{{ route('post_blog', $post->slug) }}" class="btn btn-primary" style="float:right">Read More</a></p>
							</div>
							<div style="position:absolute;bottom:0;right:0; margin-right:30px">
								<small>{{ $post->created_at->diffForHumans() }}</small>
							</div>
						</div>
						<hr>
						@endif
					@endforeach
					@if($posts->count() == 0)
					<div class="row" style="padding:20px; position:relative; text-align:center">
						<h3>No Article to show</h3>
					</div>
					@endif

						{!! str_replace('/?', '?', $posts->render()) !!}
				</div>
			</div>
		</div>
	</div>
</div>
@section('scripts')
<script type="text/javascript">
$(document).ready(function () {
if($(".banner").length){
	$('div#forNonBannerContainer').removeClass('container');
	$('div#forNonBannerContainer').removeClass('box-padding');
	$('div#forNonBannerRow').removeClass('row');
	$('div#forNonBannerRow').removeClass('content');
	$('div#forNonBannerRow').removeClass('row-box');
}
else{
	$('div#forNonBannerContainer').addClass('container');
	$('div#forNonBannerContainer').addClass('box-padding');
	$('div#forNonBannerRow').addClass('row');
	$('div#forNonBannerRow').addClass('content');
	$('div#forNonBannerRow').addClass('row-box');
}
});
</script>

@stop