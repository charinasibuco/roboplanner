@foreach($items as $item)
  <li @if($item->hasChildren()) class="dropdown"  @endif class="{{ $item->class}}">
      <a href="{!! $item->url() !!}" style="display:inline-block">{!! $item->title !!} </a>
      @if($item->hasChildren())<b class="caret"></b>
        <ul class="dropdown-menu">
              @include('frontend.layouts.custom-menu-items', array('items' => $item->children()))
        </ul> 
      @endif
  </li>
@endforeach

