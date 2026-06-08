@extends('layout.default')

@section('content')

    <div class="h-navbar"></div>

    <div class="aether-section-gap"></div>

    {{-- BREADCRUBS --}}

    <div class="aether-container">
        {{ $viewModel->getBreadcrumbs() }}
    </div>

    {{-- BREADCRUBS END --}}

    <div class="aether-section-gap"></div>

    {{-- COUNTERS --}}

    <section class="aether-container">

        @php
            $counters = $viewModel->getCounters(4);
        @endphp

        @if($counters->isNotEmpty())
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">

                @foreach($counters as $counter)

                    <div class="border border-black flex flex-col p-10">

                        @if($counter->getIcon())
                            <div class="size-10">
                                <i data-aether-icon="{{ $counter->getIcon() }}"></i>
                            </div>
                        @endif

                        @if($counter->getValue())
                            <p>

                                <span data-countup="{{ $counter->getValue() }}">
                                    {{ $counter->getValue() }}
                                </span>
                                +

                            </p>
                        @endif

                        @if($counter->getTitle())
                            <p>
                                {{ $counter->getTitle() }}
                            </p>
                        @endif

                    </div>

                @endforeach

            </div>
        @else
            <x-error-state :title="__('Henüz Sayaç Eklenmemiş')" :description="__('Şu anda görüntülenecek herhangi bir Sayaç bulunmamaktadır.')" />
        @endif

    </section>

    {{-- COUNTERS END --}}

    <div class="aether-section-gap"></div>

    {{-- CERTIFICATES --}}

    <section class="aether-container">

        @php
            $certificates = $viewModel->getCertificates();
        @endphp

        @if($certificates->isNotEmpty())

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                @foreach($certificates as $certificate)

                    <a href="{{ $certificate->getFile() }}" data-fancybox="certificates"
                        data-caption="{{ $certificate->getTitle() }}" class="cursor-zoom-in" data-type="pdf">

                        <img src="{{ $certificate->getImage() }}" loading="lazy" alt="{{ $certificate->getTitle() }}"
                            class="object-cover w-full aspect-3/4 border border-black" />

                    </a>

                @endforeach

            </div>

        @else
            <x-error-state :title="__('Henüz Sertifika Eklenmemiş')" :description="__('Şu anda görüntülenecek herhangi bir Sertifika bulunmamaktadır.')" />
        @endif

    </section>

    {{-- CERTIFICATES END --}}

    <div class="aether-section-gap"></div>

    {{-- TESTIMONIALS --}}

    <section class="aether-container">

        @php
            $testimonials = $viewModel->getTestimonials();
        @endphp

        @if($testimonials->isNotEmpty())

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                @foreach($testimonials as $item)

                    <div class="flex flex-col justify-between border border-black p-5">

                        <div class="mb-4 flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i data-aether-icon="star"
                                    class="size-4 {{ $i <= $item->getRating() ? 'text-yellow-500 fill-current' : 'text-gray-500' }}"></i>
                            @endfor
                        </div>

                        <div class="mb-6 flex-1">
                            <p class="text-sm line-clamp-4 italic">
                                "{{ $item->getComment() }}"
                            </p>
                        </div>

                        <div class="flex items-center gap-4 pt-4 border-t border-black">

                            <img src="{{ $item->getImage() }}" alt="{{ $item->getName() }}" loading="lazy"
                                class="size-10 rounded-full object-cover border border-black">

                            <div>
                                <p class="font-bold text-sm">{{ $item->getName() }}</p>
                                <p class="text-xs">{{ $item->getCompany() }}</p>
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else
            <x-error-state :title="__('Henüz Hiç Müşteri Yorumu Yok')" :description="__('Şu anda görüntülenecek herhangi bir Müşteri Yorumu bulunmamaktadır.')" />
        @endif

    </section>

    {{-- TESTIMONIALS END --}}

    <div class="aether-section-gap"></div>

@endsection