@props([
    'title' => __('Veri Bulunamadı'),
    'description' => null,
    'image' => asset('system/20260227153522919.webp'),
])

<div class="py-12 md:py-24 px-4 border border-black flex flex-col justify-center items-center text-center">

    <img
        src="{{ $image }}"
        alt="{{ $title }}"
        loading="lazy"
        class="size-24 md:size-36 xl:size-48 rounded-full aspect-square object-cover mb-4">

    <h4>
        {{ $title }}
    </h4>

    @if($description)
        <p class="mt-2">
            {{ $description }}
        </p>
    @endif

    <div class="mt-4">
        {{ $slot }}
    </div>

</div>