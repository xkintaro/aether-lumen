@php
    $linksCollection = collect($links);
    $activeLink = $linksCollection->firstWhere('isActive', true);
    $otherLinks = $linksCollection->where('isActive', false);
    $targetId = 'acc-lang-' . ($uniqueId ?? uniqid());
@endphp

<div data-aether-ui="accordion-group" class="w-full">
    <button data-aether-trigger="accordion" data-aether-target="{{ $targetId }}"
        class="w-full flex items-center cursor-pointer justify-between px-3 py-2 border border-black bg-transparent text-sm group">

        <div class="flex items-center gap-2">
            @if ($activeLink)
                <img src="{{ asset('flags/' . strtolower($activeLink->code) . '.svg') }}" loading="lazy"
                    alt="{{ $activeLink->code }}" class="size-5 rounded-full border border-black object-cover" />

                <span class="font-medium uppercase">{{ strtoupper($activeLink->code) }}</span>
            @endif
        </div>

        <i data-aether-icon="down-chevron"
            class="size-4 text-xs fill-current group-aria-expanded:rotate-180 transition-transform duration-300"></i>
    </button>

    <div id="{{ $targetId }}" data-aether-ui="accordion-panel"
        class="hidden overflow-hidden transition-all duration-300">

        <div class="pl-10 pr-2 py-1 space-y-1 border-l border-black ml-5 mt-1">
            @foreach ($otherLinks as $link)
                <a href="{{ $link->url }}" class="flex items-center gap-2 py-1.5 text-sm transition-colors">

                    <img src="{{ asset('flags/' . strtolower($link->code) . '.svg') }}" loading="lazy"
                        alt="{{ $link->code }}" class="size-5 rounded-full border border-black object-cover" />

                    <span class="font-medium uppercase">{{ strtoupper($link->code) }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>