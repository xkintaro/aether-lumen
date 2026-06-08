@extends('layout.default')

@section('content')

    <div class="h-navbar"></div>

    <div class="aether-section-gap"></div>

    {{-- PROJECTS --}}

    <section class="aether-container">

        @php
            $projects = $viewModel->getProjects(3);
        @endphp

        @if($projects->isNotEmpty())

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach($projects as $project)

                    <a href="{{ $project->getPath() }}" class="border border-black flex flex-col p-10">

                        @if($project->getImage())

                            <img src="{{ $project->getImage() }}" loading="lazy" alt="{{ $project->getTitle() }}"
                                class="w-48 h-48 object-cover" />

                        @endif

                        @if($project->getTitle())
                            <h3>
                                {{ $project->getTitle() }}
                            </h3>
                        @endif

                    </a>

                @endforeach

            </div>

        @else
            <x-error-state :title="__('Henüz Proje Eklenmemiş')" :description="__('Şu anda görüntülenecek herhangi bir proje bulunmamaktadır.')" />
        @endif

    </section>

    {{-- PROJECTS END --}}

    <div class="aether-section-gap"></div>

@endsection