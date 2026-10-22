@if($paginator->hasPages())
    <nav class="pager" aria-label="Pagination">
        @if($paginator->onFirstPage())
            <span class="off" aria-disabled="true"><svg class="icon"><use href="#i-arrow-l"/></svg></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page"><svg class="icon"><use href="#i-arrow-l"/></svg></a>
        @endif

        @foreach($elements as $element)
            @if(is_string($element))
                <span class="off">{{ $element }}</span>
            @endif
            @if(is_array($element))
                @foreach($element as $page => $url)
                    @if($page == $paginator->currentPage())
                        <span class="on" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page"><svg class="icon"><use href="#i-arrow"/></svg></a>
        @else
            <span class="off" aria-disabled="true"><svg class="icon"><use href="#i-arrow"/></svg></span>
        @endif
    </nav>
@endif
