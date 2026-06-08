@if ($item->hasChildren)

    <div data-aether-ui="accordion-group" class="w-full">

        <button type="button" data-aether-trigger="accordion" data-aether-target="mobile-{{ $item->targetId }}"
            class="w-full justify-between flex items-center gap-3 px-3 py-2.5 cursor-pointer group">

            <span>{{ $item->title }}</span>
            <i data-aether-icon="down-chevron"
                class="size-4 group-aria-expanded:rotate-180 transition-transform duration-300"></i>

        </button>

        <div id="mobile-{{ $item->targetId }}" data-aether-ui="accordion-panel">

            <div class="border-l border-black ml-4 pl-2 my-1 space-y-1">

                <a href="{{ $item->computedUrl }}"
                    class="w-full justify-between flex items-center gap-3 px-3 py-2.5 cursor-pointer">

                    <span>{{ $item->title }}</span>

                    <i data-aether-icon="right-arrow" class="size-4"></i>

                </a>

                @foreach ($item->combinedChildren as $child)
                    @include('layout.offcanvas-item', ['item' => $child])
                @endforeach

            </div>

        </div>

    </div>

@else

    <a href="{{ $item->computedUrl }}" class="w-full justify-between flex items-center gap-3 px-3 py-2.5 cursor-pointer">

        <span>{{ $item->title }}</span>

    </a>

@endif