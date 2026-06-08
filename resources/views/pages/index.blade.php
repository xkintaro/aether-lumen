@extends('layout.default')

@section('content')

     <div class="h-navbar"></div>

     {{-- SLIDER --}}

     @php
          $sliders = $viewModel->getSliders();
     @endphp

     <style>
          .swiper-pagination-bullet {
               width: 12px;
               height: 12px;
               background: rgba(0, 0, 0, 0.5);
               opacity: 1;
               transition: all 0.3s ease;
          }

          .swiper-pagination-bullet-active {
               background: #000;
               width: 30px;
               border-radius: 6px;
          }
     </style>

     <div class="swiperMain swiper w-full h-[70vh] border-b border-black">

          <div class="swiper-wrapper">

               @forelse($sliders as $slider)

                    <div class="swiper-slide">

                         <div class="relative w-full h-full flex">

                              {{-- COVER IMAGE/VIDEO --}}
                              @if($slider->getBgVideo())

                                   <video autoplay loop muted playsinline
                                        class="absolute inset-0 w-full h-full object-cover pointer-events-none">
                                        <source src="{{ $slider->getBgVideo() }}" type="video/mp4">
                                   </video>

                              @elseif($slider->getBgImage())

                                   <img src="{{ $slider->getBgImage() }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                        fetchpriority="{{ $loop->first ? 'high' : 'auto' }}"
                                        class="absolute inset-0 w-full h-full object-cover" alt="{{ $slider->getTitle() }}" />

                              @endif

                              {{-- OVERLAY --}}
                              <div class="absolute inset-0"></div>

                              <div class="relative z-10 flex flex-col gap-2 justify-center items-center w-full h-full">

                                   <p data-swiper-parallax="-400">
                                        {{ sprintf('%02d', $loop->iteration) }}/{{ sprintf('%02d', $loop->count) }}
                                   </p>

                                   @if($slider->getSubtitle())
                                        <p data-swiper-parallax="-300">
                                             {!! nl2br(e($slider->getSubtitle())) !!}
                                        </p>
                                   @endif

                                   @if($slider->getTitle())
                                        <p data-swiper-parallax="-200">
                                             {!! nl2br(e($slider->getTitle())) !!}
                                        </p>
                                   @endif

                                   {{-- BUTTONS PREV/NEXT --}}
                                   <div class="flex gap-2">

                                        <div
                                             class="main-prev size-12 p-2 flex justify-between items-center border border-black rounded-full cursor-pointer">
                                             <i data-aether-icon="left-chevron" class="size-full"></i>
                                        </div>

                                        <div
                                             class="main-next size-12 p-2 flex justify-between items-center border border-black rounded-full cursor-pointer">
                                             <i data-aether-icon="right-chevron" class="size-full"></i>
                                        </div>

                                   </div>

                              </div>

                         </div>

                    </div>

               @empty
                    <div class="swiper-slide">
                         <div class="flex items-center justify-center h-full w-full italic">
                              @lang("Slider verisi bulunamadı.")
                         </div>
                    </div>
               @endforelse

          </div>

          <div class="swiper-pagination"></div>

     </div>

     {{-- SLIDER END --}}

     <div class="aether-section-gap"></div>

     {{-- BREADCRUBS --}}

     <div class="aether-container">
          {{ $viewModel->getBreadcrumbs() }}
     </div>

     {{-- BREADCRUBS END --}}

     <div class="aether-section-gap"></div>

     {{-- TEST --}}

     <div class="aether-container">
          <p class="truncate max-w-[1200px]">
               {{ $viewModel->getGallery() }}
          </p>
     </div>

     <div class="aether-section-gap"></div>

     <div class="aether-container">
          <p class="truncate max-w-[1200px]">
               {{ $viewModel->getGallery(0) }}
          </p>
     </div>

     <div class="aether-section-gap">

          <div class="aether-container">

               @php
                    $page = $viewModel->getModel();
               @endphp

               <p>
                    {{ $viewModel->getModel() }}
               </p>

               <hr class="my-12" />

               <p>
                    {{ $page->title }}
               </p>

               <hr class="my-12" />

               <p>
                    {{ $page->getTranslatedAttribute('title') }}
               </p>


          </div>

     </div>

     {{-- TEST END --}}

     <div class="aether-section-gap"></div>

     {{-- PRODUCTS --}}

     <section class="aether-container">

          @php
               $categories = $viewModel->getRootCategories();
          @endphp

          @if($categories->isNotEmpty())

               <div class="swiper swiperProducts w-full">

                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

                         @foreach($categories as $category)

                              <a href="{{ $category->getPath() }}" class="border border-black flex flex-col p-10">

                                   @if ($category->getImage())
                                        <img src="{{ $category->getImage() }}" loading="lazy" alt="{{ $category->getName() }}"
                                             class="w-48 h-48 object-cover" />
                                   @endif

                                   @if ($category->getName())
                                        <h3>
                                             {{ $category->getName() }}
                                        </h3>
                                   @endif

                              </a>

                         @endforeach

                    </div>

               </div>

          @else
               <x-error-state :title="__('Henüz Ürün Eklenmemiş')" :description="__('Şu anda görüntülenecek herhangi bir Ürün bulunmamaktadır.')" />
          @endif

     </section>

     {{-- PRODUCTS END --}}

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

     {{-- BRANDS --}}

     <div class="aether-container">

          @php
               $brands = $viewModel->getBrands();
          @endphp


          @if($brands->isNotEmpty())

               <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

                    @foreach($brands as $brand)

                         <div class="border border-black flex flex-col p-10">

                              @if($brand->getImage())

                                   <img src="{{ $brand->getImage() }}" loading="lazy" alt="{{ $brand->getName() }}"
                                        class="w-48 h-48 object-cover" />

                              @endif

                              @if($brand->getName())
                                   <h3>
                                        {{ $brand->getName() }}
                                   </h3>
                              @endif

                         </div>

                    @endforeach

               </div>

          @else
               <x-error-state :title="__('Henüz Marka Eklenmemiş')" :description="__('Şu anda görüntülenecek herhangi bir Marka bulunmamaktadır.')" />
          @endif
     </div>

     {{-- BRANDS END --}}

     <div class="aether-section-gap"></div>

     {{-- FAQS --}}

     @php
          $faqs = $viewModel->getFaqs();
     @endphp

     @if($faqs->isNotEmpty())
          <div class="aether-container">
               <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    @foreach($faqs as $faq)
                         <div class="border border-black flex flex-col gap-3 p-10">
                              @if($faq->getQuestion())
                                   <h3>
                                        {{ $faq->getQuestion() }}
                                   </h3>
                              @endif

                              <hr />

                              @if($faq->getAnswer())
                                   <p>
                                        {{ $faq->getAnswer() }}
                                   </p>
                              @endif
                         </div>
                    @endforeach
               </div>
          </div>
     @else
          <x-error-state :title="__('Henüz SSS Eklenmemiş')" :description="__('Şu anda görüntülenecek herhangi bir SSS bulunmamaktadır.')" />
     @endif

     {{-- FAQS END --}}


     <div class="aether-section-gap"></div>

@endsection