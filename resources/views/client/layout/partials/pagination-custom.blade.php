@if ($paginator->hasPages())
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="pagination-wrap">
                <ul>
                    @if ($paginator->onFirstPage())
                        <li class="disabled"><a href="#">Trước</a></li>
                    @else
                        <li><a href="{{ $paginator->previousPageUrl() }}">Trước</a></li>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <li>
                                    <a class="{{ $page == $paginator->currentPage() ? 'active' : '' }}"
                                        href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <li><a href="{{ $paginator->nextPageUrl() }}">Tiếp</a></li>
                    @else
                        <li class="disabled"><a href="#">Tiếp</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif