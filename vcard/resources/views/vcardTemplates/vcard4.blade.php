<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
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
    <meta property="og:image" content="{{ $vcard->cover_url }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if (checkFeature('seo') && $vcard->site_title && $vcard->home_title)
        <title>{{ $vcard->home_title }} | {{ $vcard->site_title }}</title>
    @else
        <title>{{ $vcard->name }} | {{ getAppName() }}</title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('pwa/1.json') }}">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png">

    {{-- css link --}}
    <link rel="stylesheet" href="{{ asset('assets/css/vcard4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css') }}">


    @if (checkFeature('custom-fonts') && $vcard->font_family)
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family={{ $vcard->font_family }}">
    @endif

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
        <div class="main-content vcard w-100 mx-auto content-blur collapse show allSection">

            <div class="vcard__banner w-100 position-relative">
                <img src="{{ $vcard->cover_url }}" class="img-fluid banner-image" alt="banner" />
                <div class="d-flex justify-content-end position-absolute top-0 end-0 me-3">
                    @if ($vcard->language_enable == \App\Models\Vcard::LANGUAGE_ENABLE)
                        <div class="language pt-4 me-2">
                            <ul class="text-decoration-none">
                                <li class="dropdown1 dropdown lang-list">
                                    <a class="dropdown-toggle lang-head text-decoration-none" data-toggle="dropdown"
                                        role="button" aria-haspopup="true" aria-expanded="false">
                                        <i
                                            class="fa-solid fa-language me-2"></i>{{ getLanguage($vcard->default_language) }}
                                    </a>
                                    <ul class="dropdown-menu  start-0 lang-hover-list top-dropdown top-100">
                                        @foreach (getAllLanguageWithFullData() as $language)
                                            <li
                                                class="{{ getLanguageIsoCode($vcard->default_language) == $language->iso_code ? 'active' : '' }}">
                                                <a href="javascript:void(0)" id="languageName"
                                                    data-name="{{ $language->iso_code }}">
                                                    @if (array_key_exists($language->iso_code, \App\Models\User::FLAG))
                                                        @foreach (\App\Models\User::FLAG as $imageKey => $imageValue)
                                                            @if ($imageKey == $language->iso_code)
                                                                <img src="{{ asset($imageValue) }}" class="me-1" />
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
            </div>
            {{-- profile details --}}
            <div class="vcard__profile d-flex align-items-center px-4 flex-sm-row flex-column">
                <div class="vcard__avatar">
                    <img src="{{ $vcard->profile_url }}" class="rounded-circle" />
                </div>
                <div class="vcard__position d-flex flex-column mx-sm-4 mt-sm-5 mt-2">
                    <div class="d-flex flex-column vcard_details">
                        <h4 class="avatar-name text-sm-start text-center">
                            {{ ucwords($vcard->first_name . ' ' . $vcard->last_name) }}
                            @if ($vcard->is_verified)
                                <i class="verification-icon bi-patch-check-fill"></i>
                            @endif
                        </h4>
                        <span
                            class="avatar-designation text-sm-start text-center p-2">{{ ucwords($vcard->occupation) }}</span>
                        <span
                            class="avatar-designation text-sm-start text-center ms-1">{{ ucwords($vcard->job_title) }}</span>
                        <span class="avatar-company text-sm-start text-center">{{ ucwords($vcard->company) }}</span>
                    </div>
                    @if (checkFeature('social_links') && getSocialLink($vcard))
                        <div class="social-icons d-flex flex-wrap justify-content-center pt-4 vcard__social">
                            @foreach (getSocialLink($vcard) as $value)
                                <span class="icons rounded-circle d-flex justify-content-center align-items-center">
                                    {!! $value !!}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="d-flex align-items-center">
                <span class="pt-2 px-2 profile-description fs-6"> {!! $vcard->description !!}</span>
            </div>
            {{-- details --}}
            @if ((isset($managesection) && $managesection['contact_list']) || empty($managesection))
                <div class="px-4 my-3">
                    <div class="vcard__event">
                        <div class="row py-4 g-3">
                            @if ($vcard->email)
                                <div class="col-sm-6 col-12">
                                    <div
                                        class="card vcard__event-card d-flex flex-column justify-content-center align-items-center border-0 p-3 h-100">
                                        <span class="event-icon">
                                            <img src="{{ asset('assets/img/vcard4/email.png') }}" class="img-fluid">
                                        </span>
                                        <a href="mailto:{{ $vcard->email }}"
                                            class="event-name text-center mb-0 pt-2 text-decoration-none">{{ $vcard->email }}</a>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->alternative_email)
                                <div class="col-sm-6 col-12">
                                    <div
                                        class="card vcard__event-card d-flex flex-column justify-content-center align-items-center border-0 p-3 h-100">
                                        <span class="event-icon">
                                            <img src="{{ asset('img/vcard4/alter-image.png') }}" class="img-fluid"
                                                height="22" width="30" alt>
                                        </span>
                                        <a href="mailto:{{ $vcard->alternative_email }}"
                                            class="event-name text-center mb-0 pt-2 text-decoration-none">{{ $vcard->alternative_email }}</a>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->dob)
                                <div class="col-sm-6 col-12">
                                    <div
                                        class="card vcard__event-card d-flex flex-column justify-content-center align-items-center border-0 p-3 h-100">
                                        <span class="event-icon">
                                            <img src="{{ asset('assets/img/vcard4/birthday.png') }}"
                                                class="img-fluid">
                                        </span>
                                        <span class="event-name pt-2">{{ $vcard->dob }}</span>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->phone)
                                <div class="col-sm-6 col-12">
                                    <div
                                        class="card vcard__event-card d-flex flex-column justify-content-center align-items-center border-0 p-3 h-100">
                                        <span class="event-icon">
                                            <img src="{{ asset('assets/img/vcard4/mobile.png') }}" class="img-fluid">
                                        </span>
                                        <a href="tel:+{{ $vcard->region_code }}{{ $vcard->phone }}"
                                            class="event-name text-center mb-0 pt-2 text-decoration-none">+{{ $vcard->region_code }}
                                            {{ $vcard->phone }}</a>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->alternative_phone)
                                <div class="col-sm-6 col-12">
                                    <div
                                        class="card vcard__event-card d-flex flex-column justify-content-center align-items-center border-0 p-3 h-100">
                                        <span class="event-icon">
                                            <img src="{{ asset('img/vcard4/alter-phone.png') }}" class="img-fluid">
                                        </span>
                                        <a href="tel:+{{ $vcard->alternative_region_code }} {{ $vcard->alternative_phone }}"
                                            class="event-name text-center mb-0 pt-2 text-decoration-none">+{{ $vcard->alternative_region_code }}
                                            {{ $vcard->alternative_phone }}</a>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->location)
                                <div class="col-sm-6 col-12">
                                    <div
                                        class="card vcard__event-card d-flex flex-column justify-content-center align-items-center border-0 p-3 h-100">
                                        <span class="event-icon">
                                            <img src="{{ asset('assets/img/vcard4/location.png') }}"
                                                class="img-fluid">
                                        </span>
                                        <span class="event-name pt-2">{{ $vcard->location }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            {{-- QR code --}}
            @if (isset($vcard['show_qr_code']) && $vcard['show_qr_code'] == 1)
                <div class="vcard__qr-code">
                    <div class="px-4 pt-5 pb-4">
                        <h4 class="vcard__heading text-center pb-10">{{ __('messages.vcard.qr_code') }}</h4>
                        <div class="qr-code d-block mx-auto position-relative px-5 pt-5 pb-3">
                            <img src="{{ $vcard->profile_url }}"
                                class="qr-code-profile d-block mx-auto position-absolute top-0 start-50 translate-middle" />
                            <div class="qr-code-image d-flex justify-content-center pt-7" id="qr-code-four">
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
            @endif
            {{-- our services --}}
            @if ((isset($managesection) && $managesection['services']) || empty($managesection))
                @if (checkFeature('services') && $vcard->services->count())
                    <div class="my-4 px-4 pb-2 position-relative overflow-hidden pt-2">
                        <div class="line-shape position-absolute">
                            <span class="inner-circle position-absolute rounded-circle"></span>
                        </div>
                        <div class="vcard__service mt-3">
                            <h4 class="vcard__heading text-center pb-3">{{ __('messages.vcard.our_service') }}</h4>
                            <div class="container mt-1">
                                <div class="row  g-6 justify-content-center">
                                    @foreach ($vcard->services as $service)
                                        <div class="col-sm-6">
                                            <div class="card service-card h-100">
                                                <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                                                    class="text-decoration-none {{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                                                    target="{{ $service->service_url ? '_blank' : '' }}">
                                                    <img src="{{ $service->service_icon }}"
                                                        class="card-img-top service-new-image"
                                                        alt="{{ $service->name }}">
                                                </a>
                                                <div class="card-body pt-3 p-0">
                                                    <h5 class="card-title title-text">{{ ucwords($service->name) }}
                                                    </h5>
                                                    <p
                                                        class="card-text description-text {{ \Illuminate\Support\Str::length($service->description) > 80 ? 'more' : '' }}">
                                                        {!! $service->description !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            {{-- gallery --}}
            @if ((isset($managesection) && $managesection['galleries']) || empty($managesection))
                @if (checkFeature('gallery') && $vcard->gallery->count())
                    <div class="pt-4 px-4 mt-0">
                        <div class="vcard__gallery">
                            <h4 class="vcard__heading text-center">{{ __('messages.plan.gallery') }}</h4>
                            <div class="container mt-2">
                                <div class="row g-4 justify-content-center gallery-slider">
                                    @foreach ($vcard->gallery as $file)
                                        @php
                                            $infoPath = pathinfo(public_path($file->gallery_image));
                                            $extension = $infoPath['extension'];
                                        @endphp
                                        <div class="col-6">
                                            <div class="card gallery-card h-100 border-0 w-100">
                                                <div class="gallery-profile">
                                                    @if ($file->type == App\Models\Gallery::TYPE_IMAGE)
                                                        <a href="{{ $file->gallery_image }}"
                                                            data-lightbox="gallery-images"><img
                                                                src="{{ $file->gallery_image }}" alt="profile"
                                                                class="w-100" /></a>
                                                    @elseif($file->type == App\Models\Gallery::TYPE_FILE)
                                                        <a id="file_url" href="{{ $file->gallery_image }}"
                                                            class="gallery-link gallery-file-link" target="_blank">
                                                            <div class="gallery-item"
                                                                @if ($extension == 'pdf') style="background-image: url({{ asset('assets/images/pdf-icon.png') }})"> @endif
                                                                @if ($extension == 'xls') style="background-image: url({{ asset('assets/images/xls.png') }})"> @endif
                                                                @if ($extension == 'csv') style="background-image: url({{ asset('assets/images/csv-file.png') }})"> @endif
                                                                @if ($extension == 'xlsx') style="background-image: url({{ asset('assets/images/xlsx.png') }})"> @endif
                                                                </div>
                                                        </a>
                                                    @elseif($file->type == App\Models\Gallery::TYPE_VIDEO)
                                                        <div class="d-flex align-items-center video-container">
                                                            <video width="100%" controls>
                                                                <source src="{{ $file->gallery_image }}">
                                                            </video>
                                                        </div>
                                                    @elseif($file->type == App\Models\Gallery::TYPE_AUDIO)
                                                        <div class="audio-container">
                                                            <img src="{{ asset('assets/img/music.jpeg') }}"
                                                                alt="Album Cover" class="audio-image" height="173">
                                                            <audio controls src="{{ $file->gallery_image }}"
                                                                class="mt-2">
                                                                Your browser does not support the <code>audio</code>
                                                                element.
                                                            </audio>
                                                        </div>
                                                    @else
                                                        <iframe
                                                            src="https://www.youtube.com/embed/{{ YoutubeID($file->link) }}"
                                                            class="w-100" height="230">
                                                        </iframe>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- Product --}}
            @if ((isset($managesection) && $managesection['products']) || empty($managesection))
                @if (checkFeature('products') && $vcard->products->count())
                    <div class="pt-4 px-4 position-relative mt-0 ">
                        <div class="vcard__product mt-3">
                            <h4 class="vcard__heading text-center">{{ __('messages.plan.products') }}</h4>
                            <div class="container mt-2">
                                <div class="row g-4 justify-content-center product-slider">
                                    @foreach ($vcardProducts as $product)
                                        <div class="col-6">
                                            <a @if ($product->product_url) href="{{ $product->product_url }}" @endif
                                                target="_blank" class="text-decoration-none fs-6">
                                                <div class="card product-card h-100 border-0 w-100">
                                                    <div class="product-profile">
                                                        <img src="{{ $product->product_icon }}" alt="profile"
                                                            class="w-100" height="208px" />
                                                    </div>
                                                    <div class="product-details mt-3">
                                                        <h4>{{ $product->name }}</h4>
                                                        <p class="mb-2">
                                                            {{ $product->description }}
                                                        </p>
                                                        @if ($product->currency_id && $product->price)
                                                            <span
                                                                class="text-black">{{ $product->currency->currency_icon }}{{ number_format($product->price, 2) }}</span>
                                                        @elseif($product->price)
                                                            <span
                                                                class="text-black">{{ getUserCurrencyIcon($vcard->user->id) . ' ' . $product->price }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="text-center py-2">
                                    <a class="fs-4 view-more"
                                        href="{{ route('showProducts', ['id' => $vcard->id, 'alias' => $vcard->url_alias]) }}">{{ __('messages.analytics.view_more') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- Testimonial --}}
            @if ((isset($managesection) && $managesection['testimonials']) || empty($managesection))
                @if (checkFeature('testimonials') && $vcard->testimonials->count())
                    <div class="px-3 my-4 py-1">
                        <div class="vcard__testimonial">
                            <h4 class="vcard__heading text-center">{{ __('messages.plan.testimonials') }}</h4>
                            <div class="container mt-1">
                                <div class="row g-4 justify-content-center testimonial-slider">
                                    @foreach ($vcard->testimonials as $testimonial)
                                        <div class="col-6">
                                            <div class="card testimonial-card h-100 border-0 w-100">
                                                <img src="{{ $testimonial->image_url }}"
                                                    class="testimonial-image d-block mx-auto" />
                                                <div class="testimonial-details d-flex flex-column">
                                                    <p
                                                        class="mb-0 text-center pt-3 {{ \Illuminate\Support\Str::length($testimonial->description) > 80 ? 'more' : '' }}">
                                                        {{ $testimonial->description }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="testimonial-user d-flex justify-content-center flex-column align-center mt-3">
                                                    <h5 class="user-name text-center position-relative mt-2">
                                                        {{ ucwords($testimonial->name) }}</h5>
                                                    <span class="user-designation text-center"></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- insta feed --}}
            @if ((isset($managesection) && $managesection['insta_embed']) || empty($managesection))
                @if (checkFeature('instagramEmbed') && $vcard->instagramEmbed->count())
                    <div class="mt-5">
                        <h4 class="insta-heading text-center pt-5">{{ __('messages.feature.insta_embed') }}</h4>
                        <nav>
                            <div class="row insta-toggle">
                                <div class="nav nav-tabs px-0" id="nav-tab" role="tablist">
                                    <button class="active postbtn instagram-btn fs-2 border-0 py-2" id="nav-home-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                                        role="tab" aria-controls="nav-home" aria-selected="true">
                                        <span class="px-1">{{ __('messages.vcard.post') }}</span></button>
                                    <button class="instagram-btn reelsbtn fs-2 border-0 py-2" id="nav-profile-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                                        role="tab" aria-controls="nav-profile" aria-selected="false">
                                        <span class="px-1">{{ __('messages.vcard.reel') }}</span>
                                    </button>
                                </div>
                            </div>
                        </nav>
                        <div id="postContent" class="insta-feed">
                            <div class="row overflow-hidden m-0 mt-2">
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
                    <div class="vcard__blog mt-5">
                        <h4 class="vcard__heading heading-line position-relative text-center">
                            {{ __('messages.feature.blog') }}</h4>
                        <div class="container">
                            <div class="row g-4 blog-slider overflow-hidden">
                                @foreach ($vcard->blogs as $blog)
                                    <div class="col-6 mb-2">
                                        <div class="card blog-card p-2 border-0 w-100 h-100">
                                            <div class="blog-image w-100">
                                                <a
                                                    href="{{ route('vcard.show-blog', [$vcard->url_alias, $blog->id]) }}">
                                                    <img src="{{ $blog->blog_icon }}" alt="profile"
                                                        class="w-100" />
                                                </a>
                                            </div>
                                            <div class="blog-details">
                                                <a href="{{ route('vcard.show-blog', [$vcard->url_alias, $blog->id]) }}"
                                                    class="text-decoration-none">
                                                    <h4
                                                        class="text-sm-start text-center title-color text-black p-3 mb-0">
                                                        {{ $blog->title }}</h4>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- Business hour --}}
            @if ((isset($managesection) && $managesection['business_hours']) || empty($managesection))
                @if ($vcard->businessHours->count())
                    @php
                        $todayWeekName = strtolower(\Carbon\Carbon::now()->rawFormat('D'));
                    @endphp
                    <div class="vcard__timing mb-10 mt-0">
                        <div class="px-4 hours-section">
                            <h4 class="vcard__heading text-center pb-4">{{ __('messages.business.business_hours') }}
                            </h4>
                            <div class="row g-3 mx-sm-4">
                                @foreach ($businessDaysTime as $key => $dayTime)
                                    <div class="col-12">
                                        <div
                                            class="card business-card flex-row
                                        {{ \App\Models\BusinessHour::DAY_OF_WEEK[$key] == $todayWeekName ? 'business-card-today' : '' }}">
                                            <div class="calendar-icon p-4">
                                                <i class="fa-solid fa-calendar-days fs-1 text-white"></i>
                                            </div>
                                            <div class="ms-sm-2 ms-3">
                                                <div class="text-muted ms-sm-5 business-hour-day-text">
                                                    {{ __('messages.business.' . \App\Models\BusinessHour::DAY_OF_WEEK[$key]) }}
                                                </div>
                                                <div class="ms-sm-5 fw-bold mt-3 fs-4 business-hour-time-text">
                                                    {{ $dayTime ?? __('messages.common.closed') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            {{-- Appointment --}}
            @if ((isset($managesection) && $managesection['appointments']) || empty($managesection))
                @if (checkFeature('appointments') && $vcard->appointmentHours->count())
                    <div class="vcard__appointment  mb-10 mt-0">
                        <h4 class="vcard__heading heading-line text-center pb-4 position-relative">
                            {{ __('messages.make_appointments') }}</h4>
                        <div class="container">
                            <div class="appointment">
                                <div class="row d-flex align-items-center justify-content-center mb-3">
                                    <div class="col-md-2">
                                        <label for="date"
                                            class="appoint-date mb-2">{{ __('messages.date') }}</label>
                                    </div>
                                    <div class="col-md-10">
                                        {{ Form::text('date', null, ['class' => 'date appoint-input', 'placeholder' => __('messages.form.pick_date'), 'id' => 'pickUpDate']) }}
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center mb-md-3">
                                    <div class="col-md-2">
                                        <label for="text"
                                            class="appoint-date mb-2">{{ __('messages.hour') }}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div id="slotData" class="row">
                                        </div>
                                    </div>
                                </div>
                                <button type="button"
                                    class="appointmentAdd appoint-btn rounded text-white mt-4 d-block mx-auto ">{{ __('messages.make_appointments') }}
                                </button>
                                @include('vcardTemplates.appointment')
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            {{-- iframe --}}
            @if ((isset($managesection) && $managesection['iframe']) || empty($managesection))
                @if (checkFeature('iframes') && $vcard->iframes->count())
                    <div class="vcard__iframe pb-5">
                        <h4 class="vcard__heading heading-line position-relative text-center mb-5">
                            {{ __('messages.vcard.iframe') }}</h4>
                        <div class="container my-0 p-0">
                            <div class="g-4 iframe-section iframe-slider overflow-hidden">
                                @foreach ($vcard->iframes as $iframe)
                                    <div class="pb-3">
                                        <div class="card iframe-card p-4 border-0 w-100 h-100 blog-block">
                                            <iframe src="{{ $iframe->url }}" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen width="100%" height="400">
                                            </iframe>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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
            <div class="vcard__contact-us pb-5  ">
                @if ($currentSubs && $currentSubs->plan->planFeature->enquiry_form && $vcard->enable_enquiry_form)
                    <div class="px-4 mb-5 inquries">
                        <h4 class="vcard__heading text-center pb-4">{{ __('messages.contact_us.inquries') }}</h4>
                        <form id="enquiryForm">
                            @csrf
                            <div class="contact-form px-sm-5">
                                <div id="enquiryError" class="alert alert-danger d-none"></div>
                                <div class="mb-3">
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="{{ __('messages.form.your_name') }}">
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder="{{ __('messages.form.your_email') }}">
                                </div>
                                <div class="mb-3">
                                    <input type="tel" name="phone" class="form-control" id="phone"
                                        placeholder="{{ __('messages.form.enter_phone') }}">
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" placeholder="{{ __('messages.form.type_message') }}" name="message" id="message"
                                        rows="5"></textarea>
                                </div>
                                @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                                    <div class="mb-3">
                                        <input type="checkbox" name="terms_condition"
                                            class="form-check-input terms-condition" id="termConditionCheckbox"
                                            placeholder>&nbsp;
                                        <label class="form-check-label" for="privacyPolicyCheckbox">
                                            <span class="text-dark">{{ __('messages.vcard.agree_to_our') }}</span>
                                            <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                                                target="_blank"
                                                class="text-decoration-none link-info fs-6">{!! __('messages.vcard.term_and_condition') !!}</a>
                                            <span class="text-dark">&</span>
                                            <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                                                target="_blank"
                                                class="text-decoration-none link-info fs-6">{{ __('messages.vcard.privacy_policy') }}</a>
                                        </label>
                                    </div>
                                @endif
                                <button type="submit"
                                    class="contact-btn text-white mt-4 d-block mx-auto">{{ __('messages.contact_us.send_message') }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
            @if (!empty($userSetting['enable_affiliation']))
                <div class="container mb-10">
                    <h4 class="vcard-four-heading text-center mb-5">
                        {{ __('messages.create_vcard') }}</h4>
                    <div class=" link-back p-4 text-center rounded mb-2">
                        <a href="{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}"
                            target="_blank"
                            class="d-flex justify-content-center align-items-center text-decoration-none link-text font-primary">{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}<i
                                class="fa-solid fa-arrow-up-right-from-square ms-3"></i></a>
                    </div>
                </div>
            @endif
            {{-- map --}}
            @if ((isset($managesection) && $managesection['map']) || empty($managesection))
                @if ($vcard->location_url && isset($url[5]))
                    <div class="m-2 mb-10 mt-0">
                        <iframe width="100%" height="300px"
                            src='https://maps.google.de/maps?q={{ $url[5] }}/&output=embed' frameborder="0"
                            scrolling="no" marginheight="0" marginwidth="0" style="border-radius: 10px;"></iframe>
                    </div>
                @endif
            @endif
            <div class="d-flex justify-content-evenly">
                @if (checkFeature('advanced'))
                    @if (checkFeature('advanced')->hide_branding && $vcard->branding == 0)
                        @if ($vcard->made_by)
                            <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                                class="text-center text-decoration-none text-dark" target="_blank">
                                <small>{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
                            </a>
                        @else
                            <div class="text-center">
                                <small>{{ __('messages.made_by') }} {{ $setting['app_name'] }}</small>
                            </div>
                        @endif
                    @endif
                @else
                    @if ($vcard->made_by)
                        <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                            class="text-center text-decoration-none text-dark" target="_blank">
                            <small>{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
                        </a>
                    @else
                        <div class="text-center">
                            <small>{{ __('messages.made_by') }} {{ $setting['app_name'] }}</small>
                        </div>
                    @endif
                @endif
                @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                    <div>
                        <a class="text-decoration-none text-dark cursor-pointer terms-policies-btn"
                            href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"><small>{!! __('messages.vcard.term_policy') !!}</small></a>
                    </div>
                @endif
            </div>
            <div class="w-100 d-flex justify-content-center  position-fixed" style="top:50%; left:0; z-index: 9999;">
                <div class="vcard-bars-btn position-relative">
                    @if (empty($userSetting['hide_stickybar']))
                        <a href="javascript:void(0)"
                            class="vcard4-btn-group text-white bars-btn vcard4-sticky-btn  d-flex justify-content-center me-5 align-items-center rounded-0 px-5 mb-3 text-decoration-none py-1 rounded-pill justify-content-center">
                            <img src="{{ asset('assets/img/vcard4/stikcy.png') }}" />

                        </a>
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
                                            class="vcard4-btn-group d-flex justify-content-center text-white align-items-center rounded-0 text-decoration-none py-1 rounded-pill justify-content share-wp-btn">
                                            <i class="fa-solid fa-paper-plane"></i> </a>
                                    </div>
                                </div>
                            @endif
                            @if (empty($userSetting['hide_stickybar']))
                                <div
                                    class="{{ isset($userSetting['whatsapp_share']) && $userSetting['whatsapp_share'] == 1 ? 'vcard4-btn-group' : 'stickyIcon' }}">
                                    <button type="button"
                                        class="vcard4-btn-group  vcard4-share vcard4-sticky-btn d-flex justify-content-center align-items-center  px-2 mb-3 py-2"><i
                                            class="fas fa-share-alt pt-1 fs-1"></i></button>
                                    @if (!empty($vcard->enable_download_qr_code))
                                        <a type="button"
                                            class="vcard4-btn-group  vcard4-sticky-btn text-white d-flex justify-content-center align-items-center px-2 mb-3 py-2"
                                            id="qr-code-btn" download="qr_code.png"><i
                                                class="fa-solid fa-qrcode fs-1"></i></a>
                                    @endif
                                    {{-- <a type="button"
                                        class="vcard4-sticky-btn text-white h-100 d-flex justify-content-center  rounded-circle  align-items-center px-2 mb-3 py-2 d-none"
                                        id="videobtn"><i class="fa-solid fa-video fs-1"
                                            style="color: #eceeed;"></i></a> --}}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-center sticky-vcard-div">
                        @if (
                            !isset($userSetting['enable_contact']) ||
                                (!$userSetting['enable_contact'] && $userSetting['enable_contact'] != 0) ||
                                $userSetting['enable_contact'] == 1)
                            <a href="{{ route('add-contact', $vcard->id) }}"
                                class="vcard4-sticky-btn add-contact-btn d-flex justify-content-center ms-0 text-white align-items-center rounded px-5 text-decoration-none py-1  justify-content-center"><i
                                    class="fas fa-download fa-address-book fs-4"></i>
                                &nbsp;{{ __('messages.setting.add_contact') }}</a>
                        @endif
                    </div>
                    <!-- Modal -->
                    @if ((isset($managesection) && $managesection['news_latter_popup']) || empty($managesection))
                        <div class="modal fade" id="newsLatterModal" tabindex="-1"
                            aria-labelledby="newsLatterModalLabel" aria-hidden="true">
                            <div class="modal-dialog news-modal">
                                <div class="modal-content animate-bottom" id="newsLatter-content">
                                    <div class="newsmodal-header">
                                        <button type="button" class="btn-close p-5 position-absolute top-0 end-0"
                                            data-bs-dismiss="modal" aria-label="Close"
                                            id="closeNewsLatterModal"></button>
                                        <h1 class="newsmodal-title text-center mt-5" id="newsLatterModalLabel"><i
                                                class="fa-solid fa-envelope-open-text"></i></h1>
                                    </div>
                                    <div class="modal-body">
                                        <h1 class="content text-center  p-2">
                                            {{ __('messages.vcard.subscribe_newslatter') }}</h1>
                                        <h3 class="modal-desc text-center">{{ __('messages.vcard.update_directly') }}
                                        </h3>
                                        <form action="" method="post" id="newsLatterForm">
                                            @csrf
                                            <input type="hidden" name="vcard_id" value="{{ $vcard->id }}">
                                            <div class="input-group mb-3 mt-5 border-none">
                                                <input type="email"
                                                    class="form-control bg-dark border-dark text-light"
                                                    placeholder="{{ __('messages.form.enter_your_email') }}"
                                                    name="email" id="emailSubscription aria-label="Email"
                                                    aria-describedby="button-addon2">
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
                    <div id="vcard4-shareModel" class="modal fade" role="dialog">
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
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                                            fill="#000000">
                                                            <rect fill="#000000" x="0" y="7" width="16"
                                                                height="2" rx="1" />
                                                            <rect fill="#000000" opacity="0.5"
                                                                transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                                                x="0" y="7" width="16" height="2"
                                                                rx="1" />
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
                                    <a href="http://www.facebook.com/sharer.php?u={{ $shareUrl }}"
                                        target="_blank" class="text-decoration-none share" title="Facebook">
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
                                                    viewBox="0 0 512.000000 512.000000"
                                                    preserveAspectRatio="xMidYMid meet">
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
                                                    viewBox="0 0 512.000000 512.000000"
                                                    preserveAspectRatio="xMidYMid meet">
                                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                        fill="#000000" stroke="none">
                                                        <path
                                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}"
                                        target="_blank" class="text-decoration-none share" title="Linkedin">
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
                                                    viewBox="0 0 512.000000 512.000000"
                                                    preserveAspectRatio="xMidYMid meet">
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
                                                    viewBox="0 0 512.000000 512.000000"
                                                    preserveAspectRatio="xMidYMid meet">
                                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                        fill="#000000" stroke="none">
                                                        <path
                                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="http://pinterest.com/pin/create/link/?url={{ $shareUrl }}"
                                        target="_blank" class="text-decoration-none share" title="Pinterest">
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
                                                    viewBox="0 0 512.000000 512.000000"
                                                    preserveAspectRatio="xMidYMid meet">
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
                                                    viewBox="0 0 512.000000 512.000000"
                                                    preserveAspectRatio="xMidYMid meet">
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
                                                    viewBox="0 0 512.000000 512.000000"
                                                    preserveAspectRatio="xMidYMid meet">
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
                                            <input type="text" class="form-control"
                                                placeholder="{{ request()->fullUrl() }}" disabled>
                                            <span id="vcardUrlCopy{{ $vcard->id }}" class="d-none"
                                                target="_blank">
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

                </div>
            </div>
            {{-- support banner --}}
            @if ((isset($managesection) && $managesection['banner']) || empty($managesection))
                @if (isset($banners->title))
                    <div class="mb-10 mt-0">
                        <div class="support-banner d-flex align-items-center justify-content-center">
                            <button type="button" class="text-start banner-close"><i
                                    class="fa-solid fa-xmark"></i></button>
                            <div class="">
                                <h1 class="text-center support_heading">{{ $banners->title }}</h1>
                                <p class="text-center support_text text-dark">{{ $banners->description }} </p>
                                <div class="text-center">
                                    <a href="{{ $banners->url }}" class="act-now rounded text-light" target="blank"
                                        data-turbo="false">{{ $banners->banner_button }} </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        @include('vcardTemplates.template.templates')
        <script src="https://js.stripe.com/v3/"></script>
        <script type="text/javascript" src="{{ asset('assets/js/front-third-party.js') }}"></script>
        <script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>

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
            $('.testimonial-slider').slick({
                dots: true,
                infinite: true,
                speed: 300,
                arrows: false,
                slidesToShow: 2,
                slidesToScroll: 1,
                autoplay: true,
                prevArrow: '<button class="slide-arrow prev-arrow"></button>',
                nextArrow: '<button class="slide-arrow next-arrow"></button>',
                responsive: [{
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                }]
            });
        </script>
        <script>
            $('.product-slider').slick({
                dots: true,
                infinite: true,
                arrows: false,
                speed: 300,
                slidesToShow: 2,
                autoplay: true,
                slidesToScroll: 1,
                prevArrow: '<button class="slide-arrow prev-arrow"></button>',
                nextArrow: '<button class="slide-arrow next-arrow"></button>',
                responsive: [{
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                }]
            });
        </script>
        <script>
            $('.gallery-slider').slick({
                dots: true,
                infinite: true,
                arrows: false,
                speed: 300,
                slidesToShow: 2,
                autoplay: true,
                slidesToScroll: 1,
                prevArrow: '<button class="slide-arrow prev-arrow"></button>',
                nextArrow: '<button class="slide-arrow next-arrow"></button>',
                responsive: [{
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true,
                    },
                }]
            });

            $('.blog-slider').slick({
                dots: true,
                infinite: true,
                arrows: false,
                speed: 300,
                slidesToShow: 1,
                autoplay: true,
                slidesToScroll: 1,
                prevArrow: '<button class="slide-arrow-blog prev-arrow"></button>',
                nextArrow: '<button class="slide-arrow-blog next-arrow"></button>',
            })
            $('.iframe-slider').slick({
                dots: true,
                infinite: true,
                arrows: false,
                speed: 300,
                slidesToShow: 1,
                autoplay: false,
                slidesToScroll: 1,
                prevArrow: '<button class="slide-arrow-iframe iframe-prev-arrow"></button>',
                nextArrow: '<button class="slide-arrow-iframe iframe-next-arrow"></button>',
            })
        </script>
        <script>
            let isEdit = false
            let password = "{{ isset(checkFeature('advanced')->password) && !empty($vcard->password) }}"
            let passwordUrl = "{{ route('vcard.password', $vcard->id) }}";
            let enquiryUrl = "{{ route('enquiry.store', ['vcard' => $vcard->id, 'alias' => $vcard->url_alias]) }}";
            let appointmentUrl = "{{ route('appointment.store', ['vcard' => $vcard->id, 'alias' => $vcard->url_alias]) }}";
            let paypalUrl = "{{ route('paypal.init') }}"
            let slotUrl = "{{ route('appointment-session-time', $vcard->url_alias) }}";
            let appUrl = "{{ config('app.url') }}";
            let vcardId = {{ $vcard->id }};
            let vcardAlias = "{{ $vcard->url_alias }}"
            let languageChange = "{{ url('language') }}";
            let lang = "{{ checkLanguageSession($vcard->url_alias) }}";
        </script>
        <script>
            const qrCodeFour = document.getElementById("qr-code-four");
            const svg = qrCodeFour.querySelector("svg");
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

</body>

</html>
