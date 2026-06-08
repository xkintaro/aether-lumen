@extends('layout.default')

@section('content')

    <div class="h-navbar"></div>

    <div class="aether-section-gap"></div>


    {{-- BLOG --}}

    <section class="aether-container">

        @php
            $blogs = $viewModel->getBlogs();
        @endphp

        @if($blogs->isNotEmpty())

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach($blogs as $blog)

                    <a href="{{ $blog->getPath() }}" class="flex flex-col gap-4 border border-black p-10">

                        {{-- Image --}}
                        @if($blog->getImage())
                            <img src="{{ $blog->getImage() }}" loading="lazy" alt="{{ $blog->getTitle() }}"
                                class="w-48 h-48 object-cover" />
                        @endif

                        {{-- Title --}}
                        <h3>
                            {{ $blog->getTitle() }}
                        </h3>

                        {{-- Date --}}
                        @if($blog->getCreatedDate())
                            <span class="text-lg">
                                {{ $blog->getCreatedDate() }}
                            </span>
                        @endif

                        {{-- Excerpt --}}
                        @if($blog->getExcerpt())
                            <p class="line-clamp-3">
                                {{ $blog->getExcerpt() }}
                            </p>
                        @endif

                    </a>

                @endforeach

            </div>

        @else
            <x-error-state :title="__('Henüz Blog Yazısı Eklenmemiş')" :description="__('Şu anda görüntülenecek herhangi bir blog yazısı bulunmamaktadır.')" />
        @endif

    </section>

    {{-- BLOG END--}}

    <div class="aether-section-gap"></div>

@endsection