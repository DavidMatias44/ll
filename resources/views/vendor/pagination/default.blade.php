@if ($paginator->hasPages())
    <nav class="paginator">
        <ul>
            @if ($paginator->onFirstPage())
                <li><span>&lsaquo;<span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}">&lsaquo;</a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}">&rsaquo;</a></li>
            @else
                <li><span>&rsaquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
