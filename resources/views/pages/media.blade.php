@extends('layout.default')

@section('content')

    <div class="h-navbar"></div>

    <div class="aether-section-gap"></div>

    {{-- INTRO VIDEO --}}
    <section class="aether-container">

        <button data-src="{{ rvf('documents.intro_video') }}" data-fancybox>
            <i data-aether-icon="play" class="size-12"></i>
        </button>

    </section>

    <div class="aether-section-gap"></div>

    {{-- NEWS --}}

    <section class="aether-container">

        @php
            $news = $viewModel->getNews();
        @endphp

        @if($news->isNotEmpty())

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach($news as $item)

                    <a href="{{ $item->getPath() }}" class="flex flex-col gap-4 border border-black p-10">

                        {{-- Image --}}
                        @if($item->getImage())
                            <img src="{{ $item->getImage() }}" loading="lazy" alt="{{ $item->getTitle() }}"
                                class="w-48 h-48 object-cover" />
                        @endif

                        {{-- Title --}}
                        <h3>
                            {{ $item->getTitle() }}
                        </h3>

                        {{-- Date --}}
                        @if($item->getCreatedDate())
                            <span class="text-lg">
                                {{ $item->getCreatedDate() }}
                            </span>
                        @endif

                        {{-- Excerpt --}}
                        @if($item->getExcerpt())
                            <p class="line-clamp-3">
                                {{ $item->getExcerpt() }}
                            </p>
                        @endif

                    </a>

                @endforeach

            </div>

        @else
            <x-error-state :title="__('Henüz Haber Eklenmemiş')" :description="__('Şu anda görüntülenecek herhangi bir haber bulunmamaktadır.')" />
        @endif

    </section>

    {{-- NEWS END--}}

    <div class="aether-section-gap"></div>

    {{-- PHOTOS --}}

    <section class="aether-container scroll-mt-navbar" id="@lang('Fotoğraflar')">

        @php
            $photos = $viewModel->getPhotos();
        @endphp

        @if($photos->isNotEmpty())

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach($photos as $photo)

                    <a href="{{ $photo->getImage() }}" data-fancybox="media-photo-gallery" data-caption="{{ $photo->getTitle() }}"
                        class="border border-black cursor-zoom-in">

                        <img src="{{ $photo->getImage() }}" loading="lazy" alt="{{ $photo->getTitle() }}"
                            class="aspect-video w-full object-cover" />

                    </a>

                @endforeach

            </div>

        @else
            <x-error-state :title="__('Henüz Fotoğraf Eklenmemiş')" :description="__('Galeride şu an için görüntülenecek fotoğraf bulunmamaktadır.')" />
        @endif

    </section>

    {{-- PHOTOS END --}}

    <div class="aether-section-gap"></div>


    {{-- VIDEOS --}}

    <section class="aether-container scroll-mt-navbar" id="@lang('Videolar')">

        @php
            $videos = $viewModel->getVideos();
        @endphp

        @if($videos->isNotEmpty())

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach($videos as $video)

                    <a href="{{ $video->getVideo() }}" data-fancybox="media-video-gallery" data-caption="{{ $video->getTitle() }}"
                        class="border border-black cursor-zoom-in">

                        <img src="{{ $video->getImage() }}" loading="lazy" alt="{{ $video->getTitle() }}"
                            class="aspect-video w-full object-cover" />

                    </a>

                @endforeach

            </div>

        @else
            <x-error-state :title="__('Henüz Video Eklenmemiş')" :description="__('Galeride şu an için görüntülenecek video bulunmamaktadır.')" />
        @endif

    </section>

    {{-- VIDEOS END--}}

    <div class="aether-section-gap"></div>

@endsection