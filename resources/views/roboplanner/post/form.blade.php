@extends('roboplanner.layouts.template')
@section('title', 'Post')
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
					<li><a href="{{ route('post') }}">Post</a></li>
				</ol>
			</div>
		</div>
	</div>
  <div class="col-sm-8">
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
  <div class="tab-content" style="padding:30px 30px 0 0; border-right: solid 1px #ccc;">
    <div id="main" class="tab-pane fade in active">
      <div class="row">
        <div class="col-sm-12">
          <div class="row">
              <div class="col-sm-12">
                <label>Title:</label>
                <input class="form-control" name="title" placeholder="Please Enter Title" value="{{ $title }}" id="title"><br>
              </div>
            </div>
            &nbsp;
            <div class="row">
              <div class="col-sm-12">
                <label>Content:</label>
                <textarea placeholder="Put Content here" name="contents" id="mytextarea">{{ $contents }}
                </textarea>
              </div>
            </div>
        </div>
      </div>
    </div>
    <div id="template" class="tab-pane fade">
      <div class="row">
        <div class="col-sm-12">
          <label>Meta Title:</label>
          <input class="form-control" name="meta_title" value="{{ $meta_title }}" id="meta_title">
        </div>
      </div>
        &nbsp;
      <div class="row">  
        <div class="col-sm-12">
          <label>Meta Keywords:</label>
          <input class="form-control" name="meta_keywords" value="{{ $meta_keywords}}">
        </div>
      </div>
      &nbsp;
      <div class="row"> 
        <div class="col-sm-6">
          <label>Meta Description:</label>
          <textarea class="form-control" name="meta_description">{{ $meta_description }}</textarea>
        </div>
        <div class="col-sm-6">
          <label>Slug: &nbsp;<span id="display_slug"></span></label>
          <input value="{{ $slug }}" id="slug_id" style="display:none">
          <input name="slug" id="slug_field" class="form-control" placeholder="please-enter-slug" value="{{ $slug }}">
        </div>
      </div>
      &nbsp;
      <div class="row">
      </div>
      &nbsp;
    </div>
</div>
</div>
<div class="col-sm-4">
  <div class="row" style="padding-top:110px">
  </div>
  <div class="row">
    <div class="col-sm-6">
      <label>Status: </label><br>
      <input type="checkbox" data-toggle="toggle" data-on="Publish" data-off="Hidden" data-onstyle="primary" data-offstyle="warning" value="{{ $status }}" @if($status == 'Publish') checked="checked" @endif >
      <input type="checkbox" name="status" id="status" value="Publish" @if($status == 'Publish') checked="checked" @endif style="visibility: hidden">
    </div>
  </div>
  &nbsp;
  <div class="row">
    <div class="col-sm-12">
      <label>Category Lists</label><br>
      @if($categories->count() != 0)
        @foreach($categories as $category)
          <label><input type="checkbox" name="category[]" @if(in_array($category->id, $postCategory)) checked="checked"  @endif value="{{ $category->id}}"> &nbsp;{{ $category->title }}
          </label></br>
        @endforeach
      @else
         <p>No Category to Show </p>
      @endif
    </div>
  </div>
</div>
 <div class="row" style="">
    <div class="col-sm-12">
      <div class="pull-right" style="margin-top:30px">
        {{ csrf_field() }}
        <a href="{{ route('post')}}"><button type="button" class="btn btn-warning">Cancel</button></a>
        <input type="submit" class="btn btn-success" value="Submit">
      </div>
    </div>
  </div>
 </form>
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
        @if($status == 'Publish')
          $('div[data-toggle^=toggle]').addClass('btn-primary');
          $('div[data-toggle^=toggle]').removeClass('btn-warning');
          $('div[data-toggle^=toggle]').removeClass('off');
        @else
          $('div[data-toggle^=toggle]').removeClass('btn-primary');
          $('div[data-toggle^=toggle]').addClass('btn-warning');
          $('div[data-toggle^=toggle]').addClass('off');
          $('#status').val('Hidden');
        @endif
      });

      $(document).on('change', 'div[data-toggle^=toggle]', function(e) {
        var $checkbox = $(this).find('input[type=checkbox]')
        if($('div[data-toggle^=toggle]').hasClass('off')){
            // $checkbox.val('hidden')
             $('#status').val('Hidden').prop('checked', true);

        }
        else{
            // $checkbox.val('published')
          $('#status').val('Publish').prop('checked', true);
        }
      });
      
      $(function(){
        var parent =  $('#parent_name :selected').text();
        parent = parent.replace(/\s+/g, '-').toLowerCase();
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

        //Get Title value to set on Meta title field and slug
        $("#title").keyup(function(){
            var meta_title = $('#meta_title').val(this.value);
            $('#slug_field').val((this.value).replace(/\s+/g, '-').toLowerCase());
            
        });
      </script>
@stop