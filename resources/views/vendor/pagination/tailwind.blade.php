@if ($paginator->hasPages())
    <nav class="tm-pagination">
        <div class="tm-pagination-inner">

            {{-- Bouton précédent --}}
            @if ($paginator->onFirstPage())
                <span class="tm-page-btn tm-page-disabled">←</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="tm-page-btn">←</a>
            @endif

            {{-- Numéros de pages --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="tm-page-btn tm-page-dots">···</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="tm-page-btn tm-page-active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="tm-page-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Bouton suivant --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="tm-page-btn">→</a>
            @else
                <span class="tm-page-btn tm-page-disabled">→</span>
            @endif

        </div>
    </nav>
@endif