@extends('roboplanner.layouts.template')
@section('title', 'Page')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/style.css')  }}">
<link href="{{ asset('css/bootstrap-toggle.css')}}" rel="stylesheet">
<style type="text/css">
  .navbar-default{
    background-color:none !important;
    border-bottom: none !important;
    padding: 0 !important;
  }
  .btn-primary:hover, .btn-default:hover{
    background-position:0;
  }   
</style>
@stop
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="navbar navbar-default bootstrap-admin-navbar-thin">
				<ol class="breadcrumb bootstrap-admin-breadcrumb">
					<li><a href="{{ route('dashboard') }}">Dashboard</a></li>
					<li><a href="{{ route('page') }}">Pages</a></li>
				</ol>
			</div>
		</div>
	</div>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#main">Main</a></li>
    <li><a data-toggle="tab" href="#template">Meta</a></li>
  </ul>
   &nbsp;
    @if(Session::has('message'))
      <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          {{ Session::get('message') }}
      </div>
    @elseif(count($errors) > 0)
      @foreach ($errors->all() as $error)
          <div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <li style="list-style:none">{{ $error }}</li>
          </div>
      @endforeach
    @endif
<form class="form" action="{{ $action }}" method="post">
  <div class="tab-content" style="padding-top:30px">
    <div id="main" class="tab-pane fade in active">
      <div class="row">
        <div class="col-sm-12">
          <div class="row">
              <div class="col-sm-6">
                <label>Title:</label>
                <input class="form-control" name="title" placeholder="Please Enter Title" value="{{ $title }}"><br>
              </div>
              <div class="col-sm-6">
                <label>Parent Page:</label>
                <select class="form-control" name="parent_id" id="parent_name">
                  <option value=""></option>
                  @foreach($pages as $page)
                    <option value="{{$page->id}}" {{ ($parent_id == $page->id) ? 'selected="selected"' : ''}} {{($parent_id == 0)? (isset($title) ? 'disabled' : ' ') : ' '}}>{{ $page->title}}</option >
                  @endforeach
                </select> 
              </div>
            </div>
            &nbsp;
            <div class="row">
              <div class="col-sm-12">
                <label>Content:</label>
                <textarea placeholder="Put Content here" name="content" id="mytextarea">{{ $content }}
                </textarea>
              </div>
            </div>
        </div>
      </div>
      <div class="pull-right" style="margin-top:30px">
        <a href="{{ route('page')}}">
          <button type="button" class="btn btn-warning"> Cancel</button>
        </a>
        <a data-toggle="tab" href="#template" id="next">
          <button type="button" class="btn btn-primary">Next &raquo;</button>
        </a>
      </div>
    </div>
    <div id="template" class="tab-pane fade">
      <div class="row">
        {{-- <div class="col-sm-6">
          <label>Template:</label>
          <select class="form-control" name="template">
            <option>--Please Select Template--</option>
            <option value="single_column" {{($template == 0) ? 'selected="selected"' : ''}}>Single Column Template</option>
            <option value="two_column" {{($template == 1) ? 'selected="selected"' : ''}}>Two Column Template</option>
            <option value="three_column" {{($template == 2) ? 'selected="selected"' : ''}}>Three Column Template</option>
          </select>
        </div> --}}
        <div class="col-sm-12">
          <label>Meta Title:</label>
          <input class="form-control" name="meta_title" value="{{ $meta_title}}">
        </div>
      </div>
        &nbsp;
      <div class="row">  
        <div class="col-sm-12">
          <label>Meta Keywords:</label>
          <input class="form-control" name="keywords" value="{{ $keywords }}">
        </div>
      </div>
      &nbsp;
      <div class="row"> 
        <div class="col-sm-6">
          <label>Meta Description:</label>
          <textarea class="form-control" name="description">{{ $description }}</textarea>
        </div>
        <div class="col-sm-6">
          <label>Status: </label><br>
          <?php 
          $parent_name        = $pages->where('id',$parent_id)->first();
          ?>
          <input type="checkbox" data-toggle="toggle" data-on="Published" data-off="Hidden" data-onstyle="primary" data-offstyle="warning" value="{{ $status }}">
          <input type="checkbox" name="status" id="status" value="{{ $status }}" checked="checked" style="display:none">
        </div>
      </div>
      &nbsp;
      <div class="row">
        <div class="col-sm-6">
          <label>Order:</label>
          <input class="form-control" name="order" value="{{ $order}}" placeholder="Choose Order">
        </div>
        <div class="col-sm-6">
          <label>Slug: &nbsp;<span id="display_slug"></span></label>
          <input value="" id="slug_id" name="display_slug" style="display:none">
          <input name="slug" id="slug_field" class="form-control" placeholder="please-enter-slug" value="{{ $slug }}">
        </div>
      </div>
      &nbsp;
      <div class="row">
        <div class="col-sm-12">
          <div class="pull-right" style="margin-top:30px">
            {{ csrf_field() }}
            <a href="{{ route('page')}}">
              <button type="button" class="btn btn-warning"> Cancel</button>
            </a>
            <input type="submit" class="btn btn-success" value="Submit">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('js/bootstrap-toggle.js')}}"></script>
    <script src="{{ asset('tinymce.4.3.2/tinymce.min.js')}}"></script>
    <script>
      jQuery(document).ready(function() {
        //js for WYSIWYG
        tinymce.init({
          selector: '#mytextarea',
          relative_urls: false,
          height: 200,
          plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons paste textcolor responsivefilemanager"
          ],
          toolbar: "image media responsivefilemanager styleselect bold italic backcolor bullist outdent indent alignleft link emoticons",
          image_advtab: true,
          filemanager_title: "Responsive Filemanager",
          external_filemanager_path: "/filemanager/",
          filemanager_access_key:"{{ session('ACCESS_KEY') }}",
          external_plugins: {"filemanager": "{{ URL::to('/') }}/filemanager/plugin.min.js"},
          codemirror: {
          indentOnInit: true, // Whether or not to indent code on init.
          path: 'CodeMirror'
          }
        });
      });
      //pill tab
      $('.nav-tabs a').click(function(){
      $(this).tab('show');
      });
      $('#next').click(function(){
       $('.nav-tabs a[href="#template"]').tab('show');
      });
      $('#prev').click(function(){
       $('.nav-tabs a[href="#main"]').tab('show');
      })
      // Select tab by name
      $('.nav-tabs a[href="#main"]').tab('show');
      $('.nav-tabs a:first').tab('show');

      
      $(document).ready(function(e) {
        if($('#status').val() == 'published')
        {
          $('div[data-toggle^=toggle]').addClass('btn-primary');
          $('div[data-toggle^=toggle]').removeClass('btn-warning');
          $('div[data-toggle^=toggle]').removeClass('off');
        }
        else{
          $('div[data-toggle^=toggle]').removeClass('btn-primary');
          $('div[data-toggle^=toggle]').addClass('btn-warning');
          $('div[data-toggle^=toggle]').addClass('off');
          $('#status').val('hidden');
        }
      });

      $(document).on('change', 'div[data-toggle^=toggle]', function(e) {
        var $checkbox = $(this).find('input[type=checkbox]')
        if($('div[data-toggle^=toggle]').hasClass('off')){
            // $checkbox.val('hidden')
             $('#status').val('hidden')
        }
        else{
            // $checkbox.val('published')
             $('#status').val('published')
        }
      });
      
      $(function(){
        var parent =  $('#parent_name :selected').text();
        parent = parent.replace(/\s+/g, '-').toLowerCase();
        //$('#display_slug').text(parent +'/');
        // $('#slug_id').val(parent +'/');

            $('#parent_name').on('change', function() {
              var parent =  $('#parent_name :selected').text();
              parent = parent.replace(/\s+/g, '-').toLowerCase();
              $('#display_slug').text(parent +'/');
              $('#slug_field').val('');
              $('#slug_id').val(parent +'/');
            });

            if(!$('input#slug_field').val())
            {
              $('form').submit(function(){
                  $('#slug_field').val($('#slug_id').val() + $('#slug_field').val());
                  return true;
              });
            }
            else{
                $('form').submit(function(){
                  $('#slug_field').val($('#slug_field').val());
                  return true;
              });
            }
      });
      </script>
@stop