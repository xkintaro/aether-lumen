@php
    $linksCollection = collect($links);
    $activeLink = $linksCollection->firstWhere('isActive', true);
    $otherLinks = $linksCollection->where('isActive', false);
    $targetId = 'dropdown-lang-' . ($uniqueId ?? uniqid());
@endphp

@if ($activeLink)
    <div class="relative group inline-block w-fit">
        <button data-aether-trigger="ui-control" data-aether-target="{{ $targetId }}"
            class="flex items-center gap-2 px-3 py-2 border border-black bg-white hover:bg-gray-50 transition-colors cursor-pointer text-sm font-medium">

            <img src="{{ asset('flags/' . strtolower($activeLink->code) . '.svg') }}" loading="lazy"
                alt="{{ $activeLink->code }}" class="size-5 rounded-full border border-black object-cover" />
            <span class="uppercase">{{ strtoupper($activeLink->code) }}</span>
            <i data-aether-icon="down-chevron" class="size-4 ml-1"></i>

        </button>

        <div id="{{ $targetId }}" data-aether-click-outside
            class="hidden absolute top-full left-0 mt-1 w-full min-w-max bg-white border border-black shadow-md z-50 overflow-hidden">

            <div class="flex flex-col">
                @foreach ($otherLinks as $link)
                    <a href="{{ $link->url }}"
                        class="flex items-center gap-2 px-3 py-2 border-b border-black last:border-b-0 last:border-none hover:bg-gray-100 transition-colors">
                        <img src="{{ asset('flags/' . strtolower($link->code) . '.svg') }}" loading="lazy"
                            alt="{{ $link->code }}" class="size-5 rounded-full border border-black object-cover" />
                        <span class="font-medium uppercase text-sm">{{ strtoupper($link->code) }}</span>
                    </a>
                @endforeach
            </div>

        </div>
    </div>
@endif