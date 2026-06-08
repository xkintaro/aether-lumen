@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-center gap-2">
        @if ($paginator->onFirstPage())
            <span
                class="size-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-400 cursor-not-allowed opacity-50"
                aria-disabled="true">
                <i data-aether-icon="left-arrow" class="size-4"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="size-10 flex items-center justify-center rounded-full border border-black text-black hover:bg-black hover:text-white hover:border-black transition-all duration-300"
                aria-label="@lang('pagination.previous')">
                <i data-aether-icon="left-arrow" class="size-4"></i>
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="size-10 flex items-center justify-center text-gray-400 font-bold"
                    aria-disabled="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page"
                            class="size-10 flex items-center justify-center rounded-full bg-black text-white border border-black font-bold">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="size-10 flex items-center justify-center rounded-full border border-black text-black hover:bg-black hover:text-white hover:border-black transition-all duration-300"
                            aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="size-10 flex items-center justify-center rounded-full border border-black text-black hover:bg-black hover:text-white hover:border-black transition-all duration-300"
                aria-label="@lang('pagination.next')">
                <i data-aether-icon="right-arrow" class="size-4"></i>
            </a>
        @else
            <span
                class="size-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-400 cursor-not-allowed opacity-50"
                aria-disabled="true">
                <i data-aether-icon="right-arrow" class="size-4"></i>
            </span>
        @endif
    </nav>
@endif