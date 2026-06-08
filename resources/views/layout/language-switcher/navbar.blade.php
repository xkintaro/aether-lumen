@php
    $linksCollection = collect($links);
    $activeLink = $linksCollection->firstWhere('isActive', true);
    $otherLinks = $linksCollection->where('isActive', false);
    $targetId = 'navbar-lang-' . ($uniqueId ?? uniqid());
@endphp

@if ($activeLink)
    <div class="relative group hidden xl:block">
        <button data-aether-trigger="ui-control" data-aether-target="{{ $targetId }}"
            class="px-2 py-2 inline-flex items-center text-sm font-medium hover:underline uppercase cursor-pointer">

            <div class="flex items-center gap-1.5 border border-black rounded-full p-0.5 pr-2">
                <img src="{{ asset('flags/' . strtolower($activeLink->code) . '.svg') }}" loading="eager"
                    alt="{{ $activeLink->code }}" class="size-5 rounded-full object-cover" />
                <span class="font-bold text-xs">{{ strtoupper($activeLink->code) }}</span>
            </div>

        </button>

        <div id="{{ $targetId }}" data-aether-click-outside
            class="hidden absolute top-full right-0 mt-2 w-36 bg-white border border-black shadow-xl origin-top-right z-[calc(var(--navbar-z)+1)] overflow-hidden">
            
            <div class="flex flex-col">
                @foreach ($links as $link)
                    <a href="{{ $link->url }}" class="flex items-center justify-between p-3 border-b border-black last:border-b-0 hover:bg-gray-100 transition-colors {{ $link->isActive ? 'bg-gray-50' : '' }}">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('flags/' . strtolower($link->code) . '.svg') }}" loading="lazy"
                                alt="{{ $link->code }}" class="size-5 rounded-full border border-black object-cover" />
                            <span class="font-medium uppercase text-sm">{{ strtoupper($link->code) }}</span>
                        </div>
                        @if($link->isActive)
                            <div class="size-2 bg-black rounded-full"></div>
                        @endif
                    </a>
                @endforeach
            </div>

        </div>
    </div>
@endif
