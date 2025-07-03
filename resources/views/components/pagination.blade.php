<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center mt-8">
    <ul class="inline-flex items-center space-x-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li>
                <span class="px-3 py-2 rounded-lg bg-gray-200 text-gray-400 cursor-not-allowed">&laquo;</span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-3 py-2 rounded-lg bg-white border border-gray-300 text-blue-600 hover:bg-blue-50 hover:text-blue-700 shadow transition">&laquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li><span class="px-3 py-2 text-gray-400">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li>
                            <span class="px-3 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow">{{ $page }}</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}" class="px-3 py-2 rounded-lg bg-white border border-gray-300 text-blue-600 hover:bg-blue-50 hover:text-blue-700 shadow transition">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-3 py-2 rounded-lg bg-white border border-gray-300 text-blue-600 hover:bg-blue-50 hover:text-blue-700 shadow transition">&raquo;</a>
            </li>
        @else
            <li>
                <span class="px-3 py-2 rounded-lg bg-gray-200 text-gray-400 cursor-not-allowed">&raquo;</span>
            </li>
        @endif
    </ul>
</nav>
