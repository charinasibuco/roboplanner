@foreach($menus as $node)
    <li {{ $node->children ? 'class="dropdown"' : '' }}>
        <a href="{{ $node->children ?  '#' : $node->url }}" title="{{ $node->title }}">{{ $node->title }}  @if($node->children)<b class="caret"></b>@endif</a>

        {{--<a href="{{ $node->filters }}">{{ trans('property.'.$node->name) }}</a> <span class="count @unless($node->isRoot()) pull-right @endif">(6)</span>--}}
        @if($node->children)
            <ul class="dropdown-menu">
                @include('frontend.layouts.menu', ['menus' => $node->children])
            </ul>
        @endif
    </li>
@endforeach