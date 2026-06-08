@props(['links'])

<nav aria-label="Breadcrumb" class="w-full">
    <ol role="list" class="flex items-center whitespace-nowrap overflow-x-auto py-4">

        @foreach($links as $link)
            <li class="inline-flex items-center">

                @if(!$loop->first)
                    <div class="px-2 select-none">
                        <i data-aether-icon="right-chevron" class="size-3"></i>
                    </div>
                @endif

                @if($link['active'])
                    <span class="text-xs font-bold px-2 truncate max-w-[200px]" aria-current="page">
                        {{ $link['title'] }}
                    </span>
                @else
                    <a href="{{ $link['url'] }}"
                        class="text-xs font-medium px-2 transition-all duration-300 flex items-center gap-1.5 truncate max-w-[200px]">

                        @if($loop->first)
                            <i data-aether-icon="home" class="size-3"></i>
                        @endif

                        {{ $link['title'] }}

                    </a>
                @endif
            </li>
        @endforeach

    </ol>
</nav>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            @foreach($links as $index => $link) {
                    "@type": "ListItem",
                    "position": {
                        {
                            $index + 1
                        }
                    },
                    "name": "{{ $link['title'] }}",
                    "item": "{{ $link['url'] }}"
                } {
                    {
                        !$loop - > last ? ',' : ''
                    }
                }
            @endforeach
        ]
    }
</script>