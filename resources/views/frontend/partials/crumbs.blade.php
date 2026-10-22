{{-- $trail: ['Label' => url, ..., 'Current page' => null] --}}
<nav class="crumbs" aria-label="Breadcrumb">
    @foreach($trail as $label => $href)
        @if(!$loop->first)<svg class="icon" aria-hidden="true"><use href="#i-chev-r"/></svg>@endif
        @if($href && !$loop->last)
            <a href="{{ $href }}">{{ $label }}</a>
        @else
            <span aria-current="page">{{ $label }}</span>
        @endif
    @endforeach
</nav>
