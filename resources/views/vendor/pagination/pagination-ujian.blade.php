@if ($paginator->hasPages())
    <ul class="pagination-layout1 margin-t-20">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span>
                    <i class="fa fa-angle-left"></i>
                </span>
            </li>
        @else
            <li class="click">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><span><i class="fa fa-angle-left"></i></span></a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @if($paginator->currentPage() > 3)
            <li class="hidden-xs"><a href="{{ $paginator->url(1) }}"> <span>1</span></a></li>
        @endif
        @if($paginator->currentPage() > 4)
            <li class="disabled hidden-xs"><span>...</span></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $paginator->url($i) }}"><span>{{ $i }}</span></a></li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="disabled hidden-xs"><span>...</span></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="hidden-xs"><a href="{{ $paginator->url($paginator->lastPage()) }}"><span>{{ $paginator->lastPage() }}</span></a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="click">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><span><i class="fa fa-angle-right"></i></span></a>
            </li>
        @else
            <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span>
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>
        @endif
    </ul>
@endif
