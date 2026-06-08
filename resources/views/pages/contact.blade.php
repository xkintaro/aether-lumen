@extends('layout.default')

@section('content')

    <div class="h-navbar"></div>

    <div class="aether-section-gap"></div>

    {{-- Contact --}}
    <section class="aether-container">

        @if(session('message'))
            <div class="w-full mb-8 p-4 bg-green-100 border border-green-400 text-green-700 flex items-center gap-3">
                <i data-aether-icon="check-circle" class="size-6 text-green-600"></i>
                <div>
                    <h4 class="font-bold">@lang("Başarılı!")</h4>
                    <p>{{ session('message') }}</p>
                </div>
            </div>
        @endif

        <form action="{{ route('contact.ContactForm', ['locale' => $locale]) }}" method="POST" class="flex flex-col gap-5">
            @csrf

            <div class="flex flex-col gap-1">
                <input name="name" id="name" type="text" value="{{ old('name') }}" placeholder="@lang('Ad')"
                    class="border border-black p-3 @error('name') border-red-500 @enderror" autocomplete="off" required />
                @error('name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <input name="surname" id="surname" type="text" value="{{ old('surname') }}" placeholder="@lang('Soyad')"
                    class="border border-black p-3 @error('surname') border-red-500 @enderror" autocomplete="off"
                    required />
                @error('surname')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <input name="phone" id="phone" type="tel" value="{{ old('phone') }}" placeholder="@lang('Telefon')"
                    class="border border-black p-3 @error('phone') border-red-500 @enderror" autocomplete="off" required />
                @error('phone')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <input name="email" id="email" type="email" value="{{ old('email') }}" placeholder="@lang('E-Posta')"
                    class="border border-black p-3 @error('email') border-red-500 @enderror" autocomplete="off" required />
                @error('email')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <input name="subject" id="subject" type="text" value="{{ old('subject') }}" placeholder="@lang('Konu')"
                    class="border border-black p-3 @error('subject') border-red-500 @enderror" autocomplete="off"
                    required />
                @error('subject')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <textarea name="message" id="message" placeholder="@lang('Mesajınız')"
                    class="border border-black p-3 @error('message') border-red-500 @enderror" autocomplete="off"
                    required>{{ old('message') }}</textarea>
                @error('message')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>


            @if (setting('contact-information.recaptcha-status') == "aktif")
                <div class="flex flex-col gap-1">
                    <div class="g-recaptcha brochure__form__captcha"
                        data-sitekey="{{ setting('contact-information.recaptcha-site-key') }}">
                    </div>
                    @error('recaptcha')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <button type="submit" class="border border-black p-3 w-fit flex items-center gap-2">
                @lang("Gönder")
                <i data-aether-icon="right-send" class="size-4"></i>
            </button>
        </form>

    </section>

    <div class="aether-section-gap"></div>

    <section class="aether-container">

        @if(setting('contact-information.address'))

            <div>

                <h2>@lang("Adres")</h2>

                <a href="{{ setting('contact-information.google-maps-link') }}" target="_blank">
                    {!! nl2br(setting('contact-information.address')) !!}
                </a>

            </div>

        @endif
    </section>

    <div class="aether-section-gap"></div>

    {{-- Google Maps --}}
    <section class="w-full">
        <style>
            iframe {
                width: 100% !important;
                height: 450px !important;
            }
        </style>
        {!! setting('contact-information.google-maps-iframe') !!}
    </section>

    <div class="aether-section-gap"></div>

@endsection