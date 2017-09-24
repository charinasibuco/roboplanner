@extends('frontend.layouts.template')

	@section('title', $page->meta_title != '' ? $page->meta_title : $page->title)
	@section('meta_title',$page->meta_title)
	@section('keywords', $page->keywords)
	@section('description', $page->description)
	@section('styles')
	@section('content')
		<div id="forNonBannerContainer">
    		<div id="forNonBannerRow">
				{!! htmlspecialchars_decode($page->content) !!}
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