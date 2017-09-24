@foreach($items as $item)
  <li @if($item->hasChildren())  style="padding-right:60px; " @endif class="{{$item->class}}">
      <a href="{!! $item->url() !!}">{!! $item->title !!} </a>
      @if($item->hasChildren())
        <ul>
              @include('frontend.layouts.footer', array('items' => $item->children()))
        </ul> 
      @endif
  </li>
@endforeach
