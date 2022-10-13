<div class="d-flex justify-content-end mt-4 ">
    <nav aria-label="Paginator" class="shadow p-1 rounded bg-white">
        <ul class="pagination m-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <a class="page-link text-darker" href="#"><i class="fa-solid fa-angles-left fa-sm"></i></a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link text-dark" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="@lang('pagination.previous')"><i class="fa-solid fa-angles-left fa-sm"></i></a>
                </li>
            @endif



            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @php
                    if (is_string($element)) {
                        continue;
                    }
                @endphp

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if (abs($page - $paginator->currentPage()) <= 2)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span
                                        class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link text-dark"
                                        href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach



            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link text-dark" href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="@lang('pagination.next')"><i class="fa-solid fa-angles-right fa-sm"></i></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link text-darker" aria-hidden="true"><i
                            class="fa-solid fa-angles-right fa-sm"></i></span>
                </li>
            @endif
        </ul>
    </nav>
</div>
