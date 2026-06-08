@extends('layout.default')

@section('content')

    <div class="h-navbar"></div>

    <div class="aether-section-gap"></div>

    {{-- REFERENCES --}}

    <section class="aether-container">

        @php
            $references = $viewModel->getReferences();
        @endphp

        @if($references->isNotEmpty())

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach($references as $reference)

                    <a href="{{ $reference->getPath() }}" class="border border-black flex flex-col p-10">

                        @if($reference->getImage())

                            <img src="{{ $reference->getImage() }}" loading="lazy" alt="{{ $reference->getTitle() }}"
                                class="w-48 h-48 object-cover" />

                        @endif

                        @if($reference->getTitle())
                            <h3>
                                {{ $reference->getTitle() }}
                            </h3>
                        @endif

                    </a>

                @endforeach

            </div>

        @else
            <x-error-state :title="__('Henüz Referans Eklenmemiş')" :description="__('Şu anda görüntülenecek herhangi bir referans bulunmamaktadır.')" />
        @endif

    </section>

    {{-- REFERENCES END --}}

    <div class="aether-section-gap"></div>

@endsection