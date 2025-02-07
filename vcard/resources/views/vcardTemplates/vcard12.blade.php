<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    @if (checkFeature('seo'))
        @if ($vcard->meta_description)
            <meta name="description" content="{{ $vcard->meta_description }}">
        @endif
        @if ($vcard->meta_keyword)
            <meta name="keywords" content="{{ $vcard->meta_keyword }}">
        @endif
    @else
        <meta name="description" content="{{ $vcard->description }}">
        <meta name="keywords" content="">
    @endif
    <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png">
    <meta property="og:image" content="{{ $vcard->cover_url }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if (checkFeature('seo') && $vcard->site_title && $vcard->home_title)
        <title>{{ $vcard->home_title }} | {{ $vcard->site_title }}</title>
    @else
        <title>{{ $vcard->name }} | {{ getAppName() }}</title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('pwa/1.json') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/vcard12.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css') }}">
    @if ($vcard->font_family || $vcard->font_size || $vcard->custom_css)
        <style>
            @if (checkFeature('custom-fonts'))
                @if ($vcard->font_family)
                    body {
                        font-family: {{ $vcard->font_family }};
                    }
                @endif
                @if ($vcard->font_size)
                    div>h4 {
                        font-size: {{ $vcard->font_size }}px !important;
                    }
                @endif
            @endif
            @if (isset(checkFeature('advanced')->custom_css))
                {!! $vcard->custom_css !!}
            @endif
        </style>
    @endif
</head>

<body>
    <div class="container p-0">
        @include('vcards.password')
        <div class="main-content mx-auto w-100 overflow-hidden bg-gray-200">
            {{-- support banner --}}
            @if ((isset($managesection) && $managesection['banner']) || empty($managesection))
                @if (isset($banners->title))
                    <div class="support-banner d-flex align-items-center justify-content-center">
                        <button type="button" class="text-start banner-close"><i
                                class="fa-solid fa-xmark"></i></button>
                        <div class="">
                            <h1 class="text-center support_heading">{{ $banners->title }} </h1>
                            <p class="text-center text-dark support_text">{{ $banners->description }}</p>
                            <div class="text-center">
                                <a href="{{ $banners->url }}" class="act-now rounded" target="blank"
                                    data-turbo="false">{{ $banners->banner_button }}</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <div class="banner-section position-absolute w-100">
                <div class="banner-img">
                    <img src="{{ $vcard->cover_url }}" class="w-100 h-100 object-fit-cover" />
                    <div class="d-flex justify-content-end position-absolute top-0 end-0 me-3 z-index-9">
                        @if ($vcard->language_enable == \App\Models\Vcard::LANGUAGE_ENABLE)
                            <div class="language pt-4 me-2">
                                <ul class="text-decoration-none">
                                    <li class="dropdown1 dropdown lang-list">
                                        <a class="dropdown-toggle lang-head text-decoration-none" data-toggle="dropdown"
                                            role="button" aria-haspopup="true" aria-expanded="false">
                                            <i
                                                class="fa-solid fa-language me-2"></i>{{ getLanguage($vcard->default_language) }}
                                        </a>
                                        <ul class="dropdown-menu start-0 top-dropdown lang-hover-list top-100 mt-0">
                                            @foreach (getAllLanguageWithFullData() as $language)
                                                <li
                                                    class="{{ getLanguageIsoCode($vcard->default_language) == $language->iso_code ? 'active' : '' }}">
                                                    <a href="javascript:void(0)" id="languageName"
                                                        data-name="{{ $language->iso_code }}">
                                                        @if (array_key_exists($language->iso_code, \App\Models\User::FLAG))
                                                            @foreach (\App\Models\User::FLAG as $imageKey => $imageValue)
                                                                @if ($imageKey == $language->iso_code)
                                                                    <img src="{{ asset($imageValue) }}"
                                                                        class="me-1" />
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @if (count($language->media) != 0)
                                                                <img src="{{ $language->image_url }}" class="me-1" />
                                                            @else
                                                                <i class="fa fa-flag fa-xl me-3 text-danger"
                                                                    aria-hidden="true"></i>
                                                            @endif
                                                        @endif
                                                        {{ $language->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="overlay"></div>
                </div>
            </div>
            {{-- profile --}}
            <div class="profile-section pb-40 px-30">
                <div class="card flex-sm-row">
                    <div class="card-img d-flex justify-content-center align-items-center">
                        <img src="{{ $vcard->profile_url }}" class="w-100 h-100" />
                    </div>
                    <div class="card-body px-0">
                        <div class="profile-name">
                            <h2 class="text-white fs-30">
                                {{ ucwords($vcard->first_name . ' ' . $vcard->last_name) }}
                                @if ($vcard->is_verified)
                                    <i class="verification-icon bi-patch-check-fill"></i>
                                @endif
                            </h2>
                            <p class="fs-20 text-white mb-0"><span class="profile-designation pt-2 fw-light">
                                    {{ ucwords($vcard->occupation) }}</span></p>
                            <p class="fs-18 text-white mb-0">{{ ucwords($vcard->job_title) }}</p>
                            <p class="fs-18 text-white mb-0">{{ ucwords($vcard->company) }}</p>
                        </div>
                        {{-- profile details --}}

                    </div>
                </div>
            </div>
            <div class="social-media pt-4 d-flex text-light justify-content-center">
                @if (checkFeature('social_links') && getSocialLink($vcard))
                    <div class="social-icons d-flex justify-content-center flex-wrap justify-content-center w-100">
                        @foreach (getSocialLink($vcard) as $value)
                            {!! $value !!}
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="text-gray-100 desc px-30 pt-sm-3 pb-40">
                <p class="text-gray-100 text-center mb-0">
                    <span class="mt-4 profile-description fs-6"> {!! $vcard->description !!}</span>
                </p>
            </div>
            {{-- event --}}
            @if ((isset($managesection) && $managesection['contact_list']) || empty($managesection))
                <div class="contact-section position-relative px-30 ">
                    <div class="section-heading text-center overflow-hidden">
                        <h2 class="text-white mb-0 d-inline-block">
                            {{ __('messages.contact_us.contact') }}
                        </h2>
                    </div>
                    <div class="chest-expander-img">
                        <img src="{{ asset('assets/img/vcard12/chest-expander.png') }}" alt="chest-expander" />
                    </div>
                    <div class="dumbbell-img">
                        <img src="{{ asset('assets/img/vcard12/dumbbell.png') }}" alt="dumbbell" />
                    </div>
                    <div class="pt-3 mt-3 position-relative">
                        <div class="row">
                            <div class="col-sm-6 mb-40">
                                <div class="contact-box">
                                    <div class="contact-icon d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('assets/img/vcard12/Email Icon.png') }}" />
                                    </div>
                                    <div class="contact-desc">
                                        <p class="text-gray-100 mb-0 fs-14">{{ __('messages.admin.email') }}</p>
                                        <a href="mailto:{{ $vcard->email }}"
                                            class="event-name text-center pt-3 mb-0 text-decoration-none text-white">{{ $vcard->email }}</a>
                                    </div>
                                </div>
                            </div>
                            @if ($vcard->phone)
                                <div class="col-sm-6 mb-40">
                                    <div class="contact-box">
                                        <div class="contact-icon d-flex justify-content-center align-items-center">
                                            <img src="{{ asset('assets/img/vcard12/phone.png') }}" />
                                        </div>
                                        <div class="contact-desc">
                                            <p class="text-gray-100 mb-0 fs-14">
                                                {{ __('messages.vcard.mobile_number') }}</p>
                                            <a href="tel:+{{ $vcard->region_code }}{{ $vcard->phone }}"
                                                class="text-white">+{{ $vcard->region_code }} {{ $vcard->phone }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->alternative_phone)
                                <div class="col-sm-6 mb-40">
                                    <div class="contact-box">
                                        <div class="contact-icon d-flex justify-content-center align-items-center">
                                            <img src="{{ asset('assets/img/vcard12/phone.png') }}" />
                                        </div>
                                        <div class="contact-desc">
                                            <p class="text-gray-100 mb-0 fs-14">
                                                {{ __('messages.vcard.alter_mobile_number') }}</p>
                                            <a href="tel:+{{ $vcard->alternative_region_code }} {{ $vcard->alternative_phone }}"
                                                class="text-white">
                                                +{{ $vcard->alternative_region_code }}
                                                {{ $vcard->alternative_phone }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->alternative_email)
                                <div class="col-sm-6 mb-40">
                                    <div class="contact-box">
                                        <div class="contact-icon d-flex justify-content-center align-items-center">
                                            <img src="{{ asset('assets/img/vcard12/Email Icon.png') }}" />
                                        </div>
                                        <div class="contact-desc">
                                            <p class="text-gray-100 mb-0 fs-14">
                                                {{ __('messages.vcard.alter_email_address') }}</p>
                                            <a href="mailto:{{ $vcard->email }}"
                                                class="event-name text-center pt-3 mb-0 text-decoration-none text-white">{{ $vcard->alternative_email }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->dob)
                                <div class="col-sm-6 mb-40">
                                    <div class="contact-box">
                                        <div class="contact-icon d-flex justify-content-center align-items-center">
                                            <img src="{{ asset('assets/img/vcard12/dob-icon.png') }}" />
                                        </div>
                                        <div class="contact-desc">
                                            <p class="text-gray-100 mb-0 fs-14">{{ __('messages.vcard.dob') }}</p>
                                            <p class="mb-0 text-white">{{ $vcard->dob }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->location)
                                <div class="col-sm-6 mb-40">
                                    <div class="contact-box">
                                        <div class="contact-icon d-flex justify-content-center align-items-center">
                                            <img src="{{ asset('assets/img/vcard12/locaiton.png') }}" />
                                        </div>
                                        <div class="contact-desc">
                                            <p class="text-gray-100 mb-0 fs-14">{{ __('messages.setting.address') }}
                                            </p>
                                            <p class="text-white mb-0 text-break">{!! ucwords($vcard->location) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            {{-- qrcode --}}
            @if (isset($vcard['show_qr_code']) && $vcard['show_qr_code'] == 1)
                <div class="qr-code-section pb-40 px-30 mt-3">
                    <div class="row justify-content-between">
                        <div class="col-md-7 col-sm-6">
                            <div class="section-heading overflow-hidden mb-4">
                                <h2 class="text-white mb-0 d-inline-block">
                                    {{ __('messages.vcard.qr_code') }}
                                </h2>
                            </div>
                            <div class="text-center">
                                <div class="qr-profile-img mx-auto mb-3">
                                    <img src="{{ $vcard->profile_url }}" class="w-100 h-100 object-fit-cover">
                                </div>
                                <div
                                    class="qr-code d-sm-none d-flex justify-content-center text-center align-items-center ms-sm-auto mx-auto">
                                    <div
                                        class="qr-code-img d-flex justify-content-center align-items-center z-index-9 ">
                                        @if (isset($customQrCode['applySetting']) && $customQrCode['applySetting'] == 1)
                                            {!! QrCode::color(
                                                $qrcodeColor['qrcodeColor']->red(),
                                                $qrcodeColor['qrcodeColor']->green(),
                                                $qrcodeColor['qrcodeColor']->blue(),
                                            )->backgroundColor(
                                                    $qrcodeColor['background_color']->red(),
                                                    $qrcodeColor['background_color']->green(),
                                                    $qrcodeColor['background_color']->blue(),
                                                )->style($customQrCode['style'])->eye($customQrCode['eye_style'])->size(130)->format('svg')->generate(Request::url()) !!}
                                        @else
                                            {!! QrCode::size(130)->format('svg')->generate(Request::url()) !!}
                                        @endif
                                    </div>
                                </div>
                                {{-- <div
                                    class="qr-code d-sm-none d-flex justify-content-center align-items-center mb-4 mx-auto">
                                    <div class="qr-code-img">
                                        <img src="../images/gym/qr-code.png" class="w-100 h-100 object-fit-cover" />
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-6 d-sm-block d-none">
                            <div
                                class="qr-code d-flex justify-content-center text-center align-items-center ms-sm-auto mx-auto">
                                <div class="qr-code-img d-flex justify-content-center align-items-center"
                                    id="qr-code-twelve">
                                    @if (isset($customQrCode['applySetting']) && $customQrCode['applySetting'] == 1)
                                        {!! QrCode::color(
                                            $qrcodeColor['qrcodeColor']->red(),
                                            $qrcodeColor['qrcodeColor']->green(),
                                            $qrcodeColor['qrcodeColor']->blue(),
                                        )->backgroundColor(
                                                $qrcodeColor['background_color']->red(),
                                                $qrcodeColor['background_color']->green(),
                                                $qrcodeColor['background_color']->blue(),
                                            )->style($customQrCode['style'])->eye($customQrCode['eye_style'])->size(130)->format('svg')->generate(Request::url()) !!}
                                    @else
                                        {!! QrCode::size(130)->format('svg')->generate(Request::url()) !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- service --}}
            @if ((isset($managesection) && $managesection['services']) || empty($managesection))
                @if (checkFeature('services') && $vcard->services->count())
                    <div class="our-services-section px-30 pt-20 pb-40 mt-3">
                        <div class="section-heading text-center overflow-hidden">
                            <h2 class="text-white mb-0 d-inline-block">
                                {{ __('messages.vcard.our_service') }}
                            </h2>
                        </div>
                        <div class="services pt-3">
                            <div class="row">
                                @foreach ($vcard->services as $service)
                                    <div class="col-sm-6 mb-sm-0 mb-40 mt-4">
                                        <div class="service-card card h-100">
                                            <div class="card-img mb-4">
                                                <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                                                    class="text-decoration-none"
                                                    target="{{ $service->service_url ? '_blank' : '' }}">
                                                    <img src="{{ $service->service_icon }}" alt="physical-fitness"
                                                        class="img-fluid h-100" />
                                                </a>
                                            </div>
                                            <div class="card-body p-0">
                                                <h3 class="card-title fs-20 text-white">{{ ucwords($service->name) }}
                                                </h3>
                                                <p
                                                    class="mb-0 fs-14 text-gray-100 {{ \Illuminate\Support\Str::length($service->description) > 80 ? 'more' : '' }}">
                                                    {!! $service->description !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- gallary --}}
            @if ((isset($managesection) && $managesection['galleries']) || empty($managesection))
                @if (checkFeature('gallery') && $vcard->gallery->count())
                    <div class="gallery-section mb-5">
                        <div class="section-heading text-center mx-30">
                            <h2 class="text-white mb-0 d-inline-block">
                                {{ __('messages.plan.gallery') }}
                            </h2>
                        </div>
                        <div class="gallery-slider pt-3 mt-3">
                            @foreach ($vcard->gallery as $file)
                                @php
                                    $infoPath = pathinfo(public_path($file->gallery_image));
                                    $extension = $infoPath['extension'];
                                @endphp
                                @if ($file->type == App\Models\Gallery::TYPE_IMAGE)
                                    <div class="">
                                        <a href="{{ $file->gallery_image }}" data-lightbox="gallery-images"
                                            class="gallery-img"><img src="{{ $file->gallery_image }}" alt="profile"
                                                class="w-100 h-100 object-fit-cover" /></a>
                                    </div>
                                @elseif($file->type == App\Models\Gallery::TYPE_FILE)
                                    <div class="">
                                        <a id="file_url" href="{{ $file->gallery_image }}"
                                            class="gallery-link gallery-file-link" target="_blank">
                                            <div class="gallery-item gallery-file-item"
                                                @if ($extension == 'pdf') style="background-image: url({{ asset('assets/images/pdf-icon.png') }})"> @endif
                                                @if ($extension == 'xls') style="background-image: url({{ asset('assets/images/xls.png') }})"> @endif
                                                @if ($extension == 'csv') style="background-image: url({{ asset('assets/images/csv-file.png') }})"> @endif
                                                @if ($extension == 'xlsx') style="background-image: url({{ asset('assets/images/xlsx.png') }})"> @endif
                                                </div>
                                        </a>
                                    </div>
                                @elseif($file->type == App\Models\Gallery::TYPE_VIDEO)
                                    <div class="d-flex align-items-center video-container">
                                        <video width="100%" controls>
                                            <source src="{{ $file->gallery_image }}">
                                        </video>
                                    </div>
                                @elseif($file->type == App\Models\Gallery::TYPE_AUDIO)
                                    <div class="">
                                        <div class="audio-container gallery-img">
                                            <img src="{{ asset('assets/img/music.jpeg') }}" alt="Album Cover"
                                                class="audio-image">
                                            <audio controls src="{{ $file->gallery_image }}" class="mt-2">
                                                Your browser does not support the <code>audio</code> element.
                                            </audio>
                                        </div>
                                    </div>
                                @else
                                    <div class="">
                                        <iframe id="video"
                                            src="https://www.youtube.com/embed/{{ YoutubeID($file->link) }}"
                                            class="w-100" height="200">
                                        </iframe>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- product --}}
            @if ((isset($managesection) && $managesection['products']) || empty($managesection))
                @if (checkFeature('products') && $vcard->products->count())
                    <div class="product-section bg-gray pb-40 px-3">
                        <div class="section-heading overflow-hidden mx-3">
                            <h2 class="text-white mb-0 d-inline-block">
                                {{ __('messages.plan.products') }}
                            </h2>
                        </div>
                        <div class="product-slider pt-3 mt-3">
                            @foreach ($vcardProducts as $product)
                                <div class="">
                                    <a @if ($product->product_url) href="{{ $product->product_url }}" @endif
                                        target="_blank" class="text-decoration-none fs-6">
                                        <div class="product-card card">
                                            <div class="product-img card-img">
                                                <img src="{{ $product->product_icon }}"
                                                    class="img-fluid h-100 w-100" />
                                            </div>
                                            <div class="product-desc card-body">
                                                <div class="product-title">
                                                    <h3 class="text-white fs-6">{{ $product->name }}</h3>
                                                </div>
                                                <p class="fs-14 text-gray-100 mb-0">{{ $product->description }}</p>
                                                <div class="product-amount text-primary fw-6 fs-20">
                                                    @if ($product->currency_id && $product->price)
                                                        {{ $product->currency->currency_icon }}{{ number_format($product->price, 2) }}
                                                    @elseif($product->price)
                                                        {{ getUserCurrencyIcon($vcard->user->id) . ' ' . $product->price }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-4">
                            <a class="fs-6 mb-0  text-decoration-underline  text-primary "
                                href="{{ route('showProducts', ['id' => $vcard->id, 'alias' => $vcard->url_alias]) }}">{{ __('messages.analytics.view_more') }}</a>
                        </div>
                    </div>
                @endif
            @endif
            {{-- testimonial --}}
            @if ((isset($managesection) && $managesection['testimonials']) || empty($managesection))
                @if (checkFeature('testimonials') && $vcard->testimonials->count())
                    <div class="testimonial-section">
                        <div class="section-heading text-center mb-40 mx-30 overflow-hidden">
                            <h2 class="text-white mb-0 d-inline-block">
                                {{ __('messages.plan.testimonials') }}
                            </h2>
                        </div>
                        <div class=" bg-black position-relative">
                            <div class="quote-img">
                                <img src="{{ asset('assets/img/vcard12/quote-img.png') }}" class="h-100" />
                            </div>
                            <div class="bg-img">
                                <img src="{{ asset('assets/img/vcard12/testimonial-bg.png') }}" />
                            </div>
                            <div class="testimonial-slider px-30 pt-60 pb-30 ">
                                @foreach ($vcard->testimonials as $testimonial)
                                    <div class="">
                                        <div class="testimonial-card h-100">
                                            <div
                                                class="card-body d-flex flex-column justify-content-between p-0 text-sm-start text-center">
                                                <p
                                                    class="text-gray-100 fw-5 fs-14 mb-20 {{ \Illuminate\Support\Str::length($testimonial->description) > 80 ? 'more' : '' }}">
                                                    {!! $testimonial->description !!}
                                                </p>
                                                <div
                                                    class="d-flex align-items-center justify-content-sm-start justify-content-center">
                                                    <div class="profile-img me-3">
                                                        <img src="{{ $testimonial->image_url }}"
                                                            class="w-100 h-100 object-fit-cover">
                                                    </div>
                                                    <div class="">
                                                        <h6 class="name fw-5 text-white mb-0">
                                                            {{ ucwords($testimonial->name) }}
                                                        </h6>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- insta feed --}}
            @if ((isset($managesection) && $managesection['insta_embed']) || empty($managesection))
                @if (checkFeature('instagramEmbed') && $vcard->instagramEmbed->count())
                    <div class="">
                        <div class="section-heading text-center my-4 pt-3 mx-30 overflow-hidden">
                            <h2 class="text-white mb-0 d-inline-block">
                                {{ __('messages.feature.insta_embed') }}
                            </h2>
                        </div>
                        <nav>
                            <div class="row insta-toggle">
                                <div class="nav nav-tabs px-0 border-0" id="nav-tab" role="tablist">
                                    <button class="py-2 active postbtn instagram-btn border-0" id="nav-home-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                                        role="tab" aria-controls="nav-home" aria-selected="true">
                                        <span class="px-1">{{ __('messages.vcard.post') }}</span></button>
                                    <button class="py-2 instagram-btn reelsbtn border-0" id="nav-profile-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                                        role="tab" aria-controls="nav-profile" aria-selected="false">
                                        <span class="px-1">{{ __('messages.vcard.reel') }}</span>
                                    </button>
                                </div>
                            </div>
                        </nav>
                        <div id="postContent" class="insta-feed">
                            <div class="row overflow-hidden m-0 mt-2 mt-2">
                                <!-- "Post" content -->
                                @foreach ($vcard->InstagramEmbed as $InstagramEmbed)
                                    @if ($InstagramEmbed->type == 0)
                                        <div class="col-12 col-sm-6">
                                            {!! $InstagramEmbed->embedtag !!}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="d-none insta-feed" id="reelContent">
                            <div class="row overflow-hidden m-0 mt-2">
                                <!-- "Reel" content -->
                                @foreach ($vcard->InstagramEmbed as $InstagramEmbed)
                                    @if ($InstagramEmbed->type == 1)
                                        <div class="col-12 col-sm-6">
                                            {!! $InstagramEmbed->embedtag !!}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- blog --}}
            @if ((isset($managesection) && $managesection['blogs']) || empty($managesection))
                @if (checkFeature('blog') && $vcard->blogs->count())
                    <div class="blog-section mt-4">
                        <div class="section-heading text-center mx-30 overflow-hidden">
                            <h2 class="text-white mb-0 d-inline-block">
                                {{ __('messages.feature.blog') }}
                            </h2>
                        </div>
                        <div class="blog-slider pt-3 mt-3">
                            @foreach ($vcard->blogs as $blog)
                                <div class="">
                                    <div class="blog-card blog-1 card">
                                        <div class="overlay">
                                            <div class="card-img">
                                                <a
                                                    href="{{ route('vcard.show-blog', [$vcard->url_alias, $blog->id]) }}">
                                                    <img src="{{ $blog->blog_icon }}" alt="profile"
                                                        class="w-100 h-100 object-fit-cover" />
                                                </a>
                                            </div>
                                            <div class="card-body d-flex flex-column justify-content-end">
                                                <a
                                                    href="{{ route('vcard.show-blog', [$vcard->url_alias, $blog->id]) }}">
                                                    <h4 class="card-title text-white fw-5 fs-20">{{ $blog->title }}
                                                    </h4>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            {{-- buisness hours --}}
            @if ((isset($managesection) && $managesection['business_hours']) || empty($managesection))
                @if ($vcard->businessHours->count())
                    @php
                        $todayWeekName = strtolower(\Carbon\Carbon::now()->rawFormat('D'));
                    @endphp

                    <div class="bussiness-hour-section pt-30 px-30 pb-30">
                        <div class="section-heading text-center overflow-hidden">
                            <h2 class="text-white mb-0 d-inline-block">
                                {{ __('messages.business.business_hours') }}
                            </h2>
                        </div>
                        <div class="bussiness-hours mt-3 pt-3">
                            <div class="row m-0 justify-content-center">
                                @foreach ($businessDaysTime as $key => $dayTime)
                                    <div class="col-12">
                                        <div class="mb-10 d-flex align-items-center justify-content-between">
                                            <span>{{ __('messages.business.' . \App\Models\BusinessHour::DAY_OF_WEEK[$key]) . ':' }}</span>

                                            <span class="ms-2">{!! $dayTime ?? '<span class="text-primary">' . __('messages.common.closed') . '</span>' !!}</span>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-sm-6"></div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- make appointment --}}
            @if ((isset($managesection) && $managesection['appointments']) || empty($managesection))
                @if (checkFeature('appointments') && $vcard->appointmentHours->count())
                    <div class="appointment-section pt-3 mt-3 px-30">
                        <div class="section-heading overflow-hidden">
                            <h2 class="text-white mb-0 d-inline-block">
                                {{ __('messages.make_appointments') }}
                            </h2>
                        </div>
                        <div class="appointment mt-3 pt-3">
                            <div class="row">
                                <div class="col-12 mb-20">
                                    <label class="text-white mb-2">{{ __('messages.date') }}</label>
                                    <div class="position-relative">
                                        {{ Form::text('date', null, ['class' => 'form-control date appointment-input', 'placeholder' => __('messages.form.pick_date'), 'id' => 'pickUpDate']) }}
                                        <span class="calendar-icon">
                                            <img src="{{ asset('assets/img/vcard12/calendar 1.png') }}" />
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="text-white mb-2">{{ __('messages.hour') }}</label>
                                    <div id="slotData" class="row">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary w-53 appointmentAdd rounded-2">
                                        {{ __('messages.make_appointments') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('vcardTemplates.appointment')
                @endif
            @endif

            {{-- iframe --}}
            @if ((isset($managesection) && $managesection['iframe']) || empty($managesection))
                @if (checkFeature('iframes') && $vcard->iframes->count())
                    <div class="blog-section pt-40 pb-30 ">
                        <div class="section-heading text-center mx-30 overflow-hidden">
                            <h2 class="text-white mb-0 d-inline-block">
                                {{ __('messages.vcard.iframe') }}
                            </h2>
                        </div>
                        <div class="iframe-slider pt-3 mt-3">
                            @foreach ($vcard->iframes as $iframe)
                                <div class="">
                                    <div class="iframe-card blog-1 card">
                                        <div class="overlay">
                                            <iframe src="{{ $iframe->url }}" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen width="100%" height="300">
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            {{-- contact us --}}
            @php
                $currentSubs = $vcard
                    ->subscriptions()
                    ->where('status', \App\Models\Subscription::ACTIVE)
                    ->latest()
                    ->first();
            @endphp
            @if ($currentSubs && $currentSubs->plan->planFeature->enquiry_form && $vcard->enable_enquiry_form)
                <div class="contact-us-section pb-60 mt-1 px-30">
                    <div class="section-heading text-center overflow-hidden">
                        <h2 class="text-white mb-0 d-inline-block">
                            {{ __('messages.contact_us.inquries') }}
                        </h2>
                    </div>
                    <div class="contact-after-img">
                        <img src="{{ asset('assets/img/vcard12/contact-after-img.png') }}">
                    </div>
                    <div class="contact-form pt-3 mt-3 position-relative">
                        <form action="" id="enquiryForm">
                            @csrf
                            <div id="enquiryError" class="alert alert-danger d-none"></div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="text-white mb-1">{{ __('messages.form.your_name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="{{ __('messages.form.your_name') }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-white mb-1">{{ __('messages.form.your_email') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="{{ __('messages.form.your_email') }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-white mb-1">{{ __('messages.form.phone') }}</label>
                                        <input type="tel" name="phone" class="form-control"
                                            placeholder="{{ __('messages.form.phone') }}." />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="text-white mb-1">{{ __('messages.user.your_message') }} <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control h-100" name="message" placeholder="{{ __('messages.form.type_message') }}"
                                            rows="4"></textarea>
                                    </div>
                                </div>
                                @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                                    <div class="col-12">
                                        <input type="checkbox" name="terms_condition"
                                            class="form-check-input terms-condition" id="termConditionCheckbox"
                                            placeholder>&nbsp;
                                        <label class="form-check-label" for="privacyPolicyCheckbox">
                                            <span class="text-white">{{ __('messages.vcard.agree_to_our') }}</span>
                                            <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                                                target="_blank"
                                                class="text-decoration-none link-info fs-6">{!! __('messages.vcard.term_and_condition') !!}</a>
                                            <span class="text-white">&</span>
                                            <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                                                target="_blank"
                                                class="text-decoration-none link-info fs-6">{{ __('messages.vcard.privacy_policy') }}</a>
                                        </label>
                                    </div>
                                @endif
                                <div class="col-12 text-center mt-4">
                                    <button class="btn btn-primary rounded-2" type="submit">
                                        {{ __('messages.contact_us.send_message') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            @if (!empty($userSetting['enable_affiliation']))
                {{-- create vcard --}}
                <div class="create-vcard-section px-30">
                    <div class="section-heading overflow-hidden">
                        <h2 class="text-white mb-0 d-inline-block">
                            {{ __('messages.create_vcard') }}
                        </h2>
                    </div>
                    <div class="vcard-link-card card mt-4 mx-sm-4">
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}"
                                class="fw-6 text-white link-text"
                                target="_blank">{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}
                                <i class="icon fa-solid fa-arrow-up-right-from-square ms-3 text-primary"></i></a>
                        </div>
                    </div>
                </div>
            @endif
            {{-- map --}}
            @if ((isset($managesection) && $managesection['map']) || empty($managesection))
                <div class="container">
                    <div class="d-flex  flex-column justify-content-center">
                        @if ($vcard->location_url && isset($url[5]))
                            <div class="my-4">
                                <iframe width="100%" height="300px"
                                    src='https://maps.google.de/maps?q={{ $url[5] }}/&output=embed'
                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                                    style="border-radius: 10px;"></iframe>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- sticky btn --}}
            <div class="w-100 mb-5 d-flex justify-content-center sticky-vcard-div ">
                @if (
                    !isset($userSetting['enable_contact']) ||
                        (!$userSetting['enable_contact'] && $userSetting['enable_contact'] != 0) ||
                        $userSetting['enable_contact'] == 1)
                    <a href="{{ route('add-contact', $vcard->id) }}"
                        class="btn btn-primary add-contact-btn d-flex justify-content-center ms-0 align-items-center rounded px-5 text-decoration-none p-2  py-1 justify-content-center"><i
                            class="fas fa-download fa-address-book"></i>
                        &nbsp;{{ __('messages.setting.add_contact') }}</a>
                @endif
            </div>

            <div class="btn-section cursor-pointer">
                <div class="fixed-btn-section">
                    @if (empty($userSetting['hide_stickybar']))
                        <div class="bars-btn gym-bars-btn">
                            <img src="{{ asset('assets/img/vcard12/sticky.png') }}" />
                        </div>
                    @endif
                    <div class="sub-btn d-none">
                        <div class="sub-btn-div">
                            @if (isset($userSetting['whatsapp_share']) && $userSetting['whatsapp_share'] == 1)
                                <div class="icon-search-container mb-3" data-ic-class="search-trigger">
                                    <div class="wp-btn">
                                        <i class="fab text-light  fa-whatsapp fa-2x" id="wpIcon"></i>
                                    </div>
                                    <input type="number" class="search-input" id="wpNumber"
                                        data-ic-class="search-input"
                                        placeholder="{{ __('messages.setting.wp_number') }}" />
                                    <div class="share-wp-btn-div">
                                        <a href="javascript:void(0)"
                                            class="vcard12-sticky-btn vcard12-btn-group d-flex justify-content-center align-items-center text-light rounded-0 text-decoration-none py-1 rounded-pill justify-content share-wp-btn">
                                            <i class="fa-solid fa-paper-plane"></i> </a>
                                    </div>
                                </div>
                            @endif
                            @if (empty($userSetting['hide_stickybar']))
                                <div
                                    class="{{ isset($userSetting['whatsapp_share']) && $userSetting['whatsapp_share'] == 1 ? 'vcard12-btn-group' : 'stickyIcon' }}">
                                    <button type="button"
                                        class="vcard12-btn-group vcard12-share  vcard12-sticky-btn mb-3  px-2 py-1"><i
                                            class="fas fa-share-alt pt-1 fs-4"></i></button>
                                    @if (!empty($vcard->enable_download_qr_code))
                                        <a type="button"
                                            class="vcard12-btn-group vcard12-sticky-btn  d-flex justify-content-center text-white align-items-center  px-2 mb-3 py-2"
                                            id="qr-code-btn" download="qr_code.png"><i
                                                class="fa-solid fa-qrcode fs-4"></i></a>
                                    @endif
                                    {{-- <a type="button"
                                        class="vcard12-btn-group vcard12-sticky-btn  d-flex justify-content-center text-white align-items-center  px-2 mb-3 py-2 d-none"
                                        id="videobtn"><i class="fa-solid fa-video fs-3"
                                            style="color: #eceeed;"></i></a> --}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-evenly">
                @if (checkFeature('advanced'))
                    @if (checkFeature('advanced')->hide_branding && $vcard->branding == 0)
                        @if ($vcard->made_by)
                            <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                                class="text-center text-decoration-none text-white" target="_blank">
                                <small>{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
                            </a>
                        @else
                            <div class="text-center">
                                <small class="text-white">{{ __('messages.made_by') }}
                                    {{ $setting['app_name'] }}</small>
                            </div>
                        @endif
                    @endif
                @else
                    @if ($vcard->made_by)
                        <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                            class="text-center text-decoration-none text-white  " target="_blank">
                            <small>{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
                        </a>
                    @else
                        <div class="text-center">
                            <small class="text-white">{{ __('messages.made_by') }}
                                {{ $setting['app_name'] }}</small>
                        </div>
                    @endif
                @endif
                @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                    <div>
                        <a class="text-decoration-none text-white cursor-pointer terms-policies-btn"
                            href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"><small>{!! __('messages.vcard.term_policy') !!}</small></a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Modal -->
    @if ((isset($managesection) && $managesection['news_latter_popup']) || empty($managesection))
        <div class="modal fade" id="newsLatterModal" tabindex="-1" aria-labelledby="newsLatterModalLabel"
            aria-hidden="true">
            <div class="modal-dialog news-modal">
                <div class="modal-content animate-bottom" id="newsLatter-content">
                    <div class="newsmodal-header">
                        <button type="button" class="btn-close position-absolute top-0 end-0"
                            data-bs-dismiss="modal" aria-label="Close" id="closeNewsLatterModal"></button>
                        <h1 class="newsmodal-title text-center mt-5" id="newsLatterModalLabel"><i
                                class="fa-solid fa-envelope-open-text"></i></h1>
                    </div>
                    <div class="modal-body">
                        <h1 class="content text-center  p-2">{{ __('messages.vcard.subscribe_newslatter') }}</h1>
                        <h3 class="modal-desc text-center">{{ __('messages.vcard.update_directly') }}</h3>
                        <form action="" method="post" id="newsLatterForm">
                            @csrf
                            <input type="hidden" name="vcard_id" value="{{ $vcard->id }}">
                            <div class="input-group mb-3 mt-5">
                                <input type="email" class="form-control"
                                    placeholder="{{ __('messages.form.enter_your_email') }}" aria-label="Email"
                                    name="email" id="emailSubscription" aria-describedby="button-addon2">
                                <button class="btn" type="submit" id="email-send"><i
                                        class="fa-regular fa-envelope"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- share modal code --}}
    <div id="vcard12-shareModel" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="">
                    <div class="row align-items-center mt-3">
                        <div class="col-10 text-center">
                            <h5 class="modal-title" style="padding-left: 50px;">
                                {{ __('messages.vcard.share_my_vcard') }}</h5>
                        </div>
                        <div class="col-2 p-0">
                            <button type="button" aria-label="Close"
                                class="p-3 btn btn-sm btn-icon btn-active-color-danger border-none"
                                data-bs-dismiss="modal">
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                            fill="#000000">
                                            <rect fill="#000000" x="0" y="7" width="16" height="2"
                                                rx="1" />
                                            <rect fill="#000000" opacity="0.5"
                                                transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                                x="0" y="7" width="16" height="2" rx="1" />
                                        </g>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                @php
                    $shareUrl = route('vcard.show', ['alias' => $vcard->url_alias]);
                @endphp
                <div class="modal-body">
                    <a href="http://www.facebook.com/sharer.php?u={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Facebook">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-facebook fa-2x" style="color: #1B95E0"></i>

                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark">
                                    {{ __('messages.social.Share_on_facebook') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="http://twitter.com/share?url={{ $shareUrl }}&text={{ $vcard->name }}&hashtags=sharebuttons"
                        target="_blank" class="text-decoration-none share" title="Twitter">
                        <div class="row">
                            <div class="col-2">

                                <span><svg xmlns="http://www.w3.org/2000/svg" height="2em"
                                        viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                                    </svg></span>

                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark">
                                    {{ __('messages.social.Share_on_twitter') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Linkedin">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-linkedin fa-2x" style="color: #1B95E0"></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark">
                                    {{ __('messages.social.Share_on_linkedin') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="mailto:?Subject=&Body={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Email">
                        <div class="row">
                            <div class="col-2">
                                <i class="fas fa-envelope fa-2x" style="color: #191a19  "></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark">
                                    {{ __('messages.social.Share_on_email') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="http://pinterest.com/pin/create/link/?url={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Pinterest">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-pinterest fa-2x" style="color: #bd081c"></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark">
                                    {{ __('messages.social.Share_on_pinterest') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="http://reddit.com/submit?url={{ $shareUrl }}&title={{ $vcard->name }}"
                        target="_blank" class="text-decoration-none share" title="Reddit">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-reddit fa-2x" style="color: #ff4500"></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark">
                                    {{ __('messages.social.Share_on_reddit') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="https://wa.me/?text={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Whatsapp">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-whatsapp fa-2x" style="color: limegreen"></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark">
                                    {{ __('messages.social.Share_on_whatsapp') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <div class="col-12 justify-content-between social-link-modal">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="{{ request()->fullUrl() }}"
                                disabled>
                            <span id="vcardUrlCopy{{ $vcard->id }}" class="d-none" target="_blank">
                                {{ route('vcard.show', ['alias' => $vcard->url_alias]) }} </span>
                            <button class="copy-vcard-clipboard btn btn-dark" title="Copy Link"
                                data-id="{{ $vcard->id }}">
                                <i class="fa-regular fa-copy fa-2x"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-center">

                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
@include('vcardTemplates.template.templates')
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript" src="{{ asset('assets/js/front-third-party.js') }}"></script>
@if (checkFeature('seo') && $vcard->google_analytics)
    {!! $vcard->google_analytics !!}
@endif
@if (isset(checkFeature('advanced')->custom_js) && $vcard->custom_js)
    {!! $vcard->custom_js !!}
@endif
@php
    $setting = \App\Models\UserSetting::where('user_id', $vcard->tenant->user->id)
        ->where('key', 'stripe_key')
        ->first();
@endphp
<script>
    let stripe = ''
    @if (!empty($setting) && !empty($setting->value))
        stripe = Stripe('{{ $setting->value }}');
    @endif
    $().ready(function() {
        $(".gallery-slider").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            centerMode: true,
            arrows: false,
            dots: true,
            speed: 300,
            centerPadding: '135px',
            infinite: true,
            autoplaySpeed: 5000,
            autoplay: true,
            responsive: [{
                    breakpoint: 575,
                    settings: {
                        centerPadding: '125px',
                        dots: true,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        centerPadding: '0',
                        dots: true,
                    },
                },
            ],
        });
        $(".product-slider").slick({
            arrows: false,
            infinite: true,
            dots: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            responsive: [{
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                },
            }, ],
        });
        $(".testimonial-slider").slick({
            arrows: false,
            infinite: true,
            dots: true,
            slidesToShow: 1,
            autoplay: true,
        });
        $(".blog-slider").slick({
            arrows: false,
            infinite: true,
            dots: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            centerPadding: '40px',
            centerMode: true,
            responsive: [{
                breakpoint: 575,
                settings: {
                    centerPadding: '0',
                },
            }, ],
        });
        $(".iframe-slider").slick({
            arrows: false,
            infinite: true,
            dots: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            centerPadding: '40px',
            centerMode: true,
            responsive: [{
                breakpoint: 575,
                settings: {
                    centerPadding: '0',
                },
            }, ],
        });
    });
</script>
<script>
    let isEdit = false
    let password = "{{ isset(checkFeature('advanced')->password) && !empty($vcard->password) }}"
    let passwordUrl = "{{ route('vcard.password', $vcard->id) }}";
    let enquiryUrl = "{{ route('enquiry.store', ['vcard' => $vcard->id, 'alias' => $vcard->url_alias]) }}";
    let appointmentUrl = "{{ route('appointment.store', ['vcard' => $vcard->id, 'alias' => $vcard->url_alias]) }}";
    let slotUrl = "{{ route('appointment-session-time', $vcard->url_alias) }}";
    let appUrl = "{{ config('app.url') }}";
    let vcardId = {{ $vcard->id }};
    let vcardAlias = "{{ $vcard->url_alias }}";
    let languageChange = "{{ url('language') }}";
    let paypalUrl = "{{ route('paypal.init') }}"
    let lang = "{{ checkLanguageSession($vcard->url_alias) }}";
</script>
<script>
    const qrCodeTwelve = document.getElementById("qr-code-twelve");
    const svg = qrCodeTwelve.querySelector("svg");
    const blob = new Blob([svg.outerHTML], {
        type: 'image/svg+xml'
    });
    const url = URL.createObjectURL(blob);
    const image = document.createElement('img');
    image.src = url;
    image.addEventListener('load', () => {
        const canvas = document.createElement('canvas');
        canvas.width = canvas.height = {{ $vcard->qr_code_download_size }};
        const context = canvas.getContext('2d');
        context.drawImage(image, 0, 0, canvas.width, canvas.height);
        const link = document.getElementById('qr-code-btn');
        link.href = canvas.toDataURL();
        URL.revokeObjectURL(url);
    });
</script>
@routes
<script src="{{ asset('messages.js') }}"></script>
<script src="{{ asset('assets/js/custom/helpers.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom.js') }}"></script>
<script src="{{ asset('assets/js/vcards/vcard-view.js') }}"></script>
<script src="{{ asset('assets/js/lightbox.js') }}"></script>
<script src="{{ asset('/sw.js') }}"></script>
<script>
    if ("serviceWorker" in navigator) {
        // Register a service worker hosted at the root of the
        // site using the default scope.
        navigator.serviceWorker.register("/sw.js").then(
            (registration) => {
                console.log("Service worker registration succeeded:", registration);
            },
            (error) => {
                console.error(`Service worker registration failed: ${error}`);
            },
        );
    } else {
        console.error("Service workers are not supported.");
    }
</script>

</html>
