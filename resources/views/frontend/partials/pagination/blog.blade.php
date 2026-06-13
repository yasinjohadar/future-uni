@if ($paginator->hasPages())
    <nav class="blog-pagination" aria-label="ترقيم الصفحات">
        <ul class="blog-pagination__list">
            @if ($paginator->onFirstPage())
                <li class="blog-pagination__item blog-pagination__item--disabled">
                    <span class="blog-pagination__link" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                </li>
            @else
                <li class="blog-pagination__item">
                    <a class="blog-pagination__link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="الصفحة السابقة">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="blog-pagination__item blog-pagination__item--dots">
                        <span class="blog-pagination__dots">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="blog-pagination__item blog-pagination__item--active" aria-current="page">
                                <span class="blog-pagination__link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="blog-pagination__item">
                                <a class="blog-pagination__link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="blog-pagination__item">
                    <a class="blog-pagination__link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="الصفحة التالية">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @else
                <li class="blog-pagination__item blog-pagination__item--disabled">
                    <span class="blog-pagination__link" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
