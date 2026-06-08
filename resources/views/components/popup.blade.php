@props(['popups'])

@if($popups && $popups->isNotEmpty())

    <div id="popup-queue-wrapper" data-total="{{ $popups->count() }}">

        @foreach($popups as $index => $popupViewModel)
            @php
                $model = $popupViewModel->getModel();
                $delay = 500;
                $popupId = "global-popup-{$index}";

                $video = $popupViewModel->getVideo();
                $image = $popupViewModel->getImage();
                $title = $popupViewModel->getTitle();
                $content = $popupViewModel->getContent();
                $btnText = $popupViewModel->getActionText();
                $link = $popupViewModel->getActionLink();
            @endphp

            <div id="{{ $popupId }}" class="hidden fixed inset-0 z-popup flex justify-center items-center p-4"
                data-aether-scroll-lock data-aether-click-outside data-queue-index="{{ $index }}" data-delay="{{ $delay }}">

                <div class="absolute inset-0 backdrop-blur-xl transition-opacity duration-500 ease-out opacity-0 popup-backdrop"
                    data-target="{{ $popupId }}"></div>

                <div
                    class="relative w-full max-w-5xl transition-all duration-500 ease-out transform scale-95 opacity-0 popup-content border border-black bg-white rounded-xl shadow-2xl max-h-[90%] overflow-auto flex flex-col md:flex-row ">

                    <button type="button"
                        class="manual-close-btn absolute top-4 right-4 z-50 p-2 rounded-full cursor-pointer border border-black"
                        data-aether-trigger="ui-control" data-target="{{ $popupId }}">
                        <i data-aether-icon="close" class="size-5"></i>
                    </button>

                    <div
                        class="w-full md:w-1/2 relative flex justify-center items-center overflow-hidden h-full min-h-[350px] md:min-h-[600px]">

                        @if(!empty($video))

                            <video class="absolute inset-0 w-full h-full object-cover" muted loop playsinline
                                controlsList="nodownload">
                                <source src="{{ $video }}" type="video/mp4">
                            </video>

                        @elseif(!empty($image))

                            @if($link && $link != '#')
                                <a href="{{ $link }}" target="_blank" class="block w-full h-full">
                            @endif

                                <img src="{{ $image }}" alt="{{ $title }}" loading="lazy"
                                    class="absolute inset-0 w-full h-full object-cover transition-all duration-700 hover:scale-105 hover:blur-xs" />

                                @if($link && $link != '#')
                                    </a>
                                @endif

                        @endif

                    </div>

                    @if(!empty($title) || !empty($content) || (!empty($btnText) && $link != '#'))
                        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center h-full text-left gap-3 md:gap-6">

                            <div class="space-y-4">

                                @if($title)
                                    <h3>
                                        {{ $title }}
                                    </h3>
                                @endif

                                @if($content)
                                    <div class="text-base md:text-lg leading-relaxed">
                                        {!! $content !!}
                                    </div>
                                @endif

                            </div>

                            @if($link && $link != '#' && $btnText)

                                <div class="pt-2">

                                    <a href="{{ $link }}" target="_blank" class="w-full md:w-fit justify-center">
                                        {{ $btnText }}
                                        <i data-aether-icon="right-arrow"></i>
                                    </a>

                                </div>

                            @endif

                        </div>

                    @endif

                </div>

            </div>

        @endforeach

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const STORAGE_KEY = 'site_popups_last_seen';

            const EXPIRATION_TIME = 60 * 60 * 1000; // 1 hours

            const lastSeen = localStorage.getItem(STORAGE_KEY);
            const now = new Date().getTime();

            if (lastSeen && (now - lastSeen < EXPIRATION_TIME)) {
                return;
            }

            if (typeof AetherUI === 'undefined') {
                console.error('AetherUI Library Error');
                return;
            }

            const originalHas = AetherUI._has;
            AetherUI._has = function (el, name) {
                if (!el) return false;
                return originalHas.call(this, el, name);
            };

            if (!AetherUI.initialized) {
                AetherUI.init();
            }

            const wrapper = document.getElementById('popup-queue-wrapper');
            if (!wrapper) return;

            const totalPopups = parseInt(wrapper.dataset.total) || 0;
            let currentIndex = 0;
            const popupPrefix = 'global-popup-';

            triggerNextPopup();
            localStorage.setItem(STORAGE_KEY, now.toString());

            document.addEventListener('aether:open', (e) => {
                const targetId = e.target.id;
                if (targetId && targetId.startsWith(popupPrefix)) {
                    const modal = e.target;
                    const backdrop = modal.querySelector('.popup-backdrop');
                    const content = modal.querySelector('.popup-content');

                    const video = modal.querySelector('video');
                    if (video) {
                        video.currentTime = 0;
                        video.play().catch(err => console.log('Autoplay Blocked:', err));
                    }

                    requestAnimationFrame(() => {
                        if (backdrop) backdrop.classList.remove('opacity-0');
                        if (content) {
                            content.classList.remove('scale-95', 'opacity-0');
                            content.classList.add('scale-100', 'opacity-100');
                        }
                    });
                }
            });

            document.querySelectorAll('.manual-close-btn, .popup-backdrop').forEach(el => {
                el.addEventListener('click', function (e) {
                    const targetId = this.dataset.target;
                    animateAndClose(targetId);
                });
            });

            function animateAndClose(popupId) {
                const modal = document.getElementById(popupId);
                if (!modal) return;

                const backdrop = modal.querySelector('.popup-backdrop');
                const content = modal.querySelector('.popup-content');

                if (backdrop) backdrop.classList.add('opacity-0');
                if (content) {
                    content.classList.remove('scale-100', 'opacity-100');
                    content.classList.add('scale-95', 'opacity-0');
                }

                setTimeout(() => {
                    AetherUI.close(popupId);
                }, 500);
            }

            document.addEventListener('aether:close', (e) => {
                const targetId = e.target.id;

                if (targetId && targetId.startsWith(popupPrefix)) {
                    const video = e.target.querySelector('video');
                    if (video) video.pause();

                    currentIndex++;
                    triggerNextPopup();
                }
            });

            function triggerNextPopup() {
                if (currentIndex >= totalPopups) return;

                const popupId = popupPrefix + currentIndex;
                const modal = document.getElementById(popupId);

                if (modal) {
                    const delay = parseInt(modal.dataset.delay) || 500;
                    setTimeout(() => {
                        AetherUI.open(popupId);
                    }, delay);
                }
            }
        });
    </script>
@endif