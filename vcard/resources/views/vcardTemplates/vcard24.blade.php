<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @if (checkFeature('seo') && $vcard->site_title && $vcard->home_title)
        <title>{{ $vcard->home_title }} | {{ $vcard->site_title }}</title>
    @else
        <title>{{ $vcard->name }} | {{ getAppName() }}</title>
    @endif

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('pwa/1.json') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png">

    {{-- css link --}}
    <link rel="stylesheet" href="{{ asset('assets/css/vcard24.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
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
    <style>
        .bg-img {
            background-image: url("/assets/img/vcard21/bg-img.png");
        }
    </style>
</head>

<body>
    <div class="container p-0">
        @include('vcards.password')
        <div class="main-content mx-auto w-100 overflow-hidden">
            {{-- support banner --}}
            @if ((isset($managesection) && $managesection['banner']) || empty($managesection))
                @if (isset($banners->title))
                    <div class="support-banner d-flex align-items-center justify-content-center">
                        <button type="button" class="text-start banner-close"><i
                                class="fa-solid fa-xmark"></i></button>
                        <div class="">
                            <h1 class="text-center support_heading">{{ $banners->title }}</h1>
                            <p class="text-center text-dark support_text">{{ $banners->description }} </p>
                            <div class="text-center mt-3">
                                <a href="{{ $banners->url }}" class="act-now rounded" target="blank"
                                    data-turbo="false">{{ $banners->banner_button }}</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <div class="banner-section position-relative">
                <div class="banner-img cover-img">
                    <img src="{{ $vcard->cover_url }}" class="w-100 h-100 object-fit-cover" />
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
                    <div class="cloud-img">
                        <img src="{{ asset('assets/img/vcard24/Cloud.png') }}" class="w-100" />
                    </div>
                </div>
            </div>
            <div class="profile-section pt-60 pb-60 px-30">
                <div class="book-img text-end">
                    <img src="{{ asset('assets/img/vcard24/book.png') }}" alt="book" />
                </div>
                <div class="card d-flex flex-sm-row">
                    <div class="card-img">
                        <img src="{{ $vcard->profile_url }}" class="w-100 h-100 object-fit-cover" />
                    </div>
                    <div class="card-body p-0 text-sm-start text-center">
                        <div class="profile-name">
                            <h4 class="text-black mb-0 fw-bold">
                                {{ ucwords($vcard->first_name . ' ' . $vcard->last_name) }}
                                @if ($vcard->is_verified)
                                    <i class="verification-icon bi-patch-check-fill"></i>
                                @endif
                            </h4>
                            <p class="fs-16 text-pink fw-5 mb-0">{{ ucwords($vcard->occupation) }}</p>
                            <p class="fs-16 text-pink fw-5 mb-0">{{ ucwords($vcard->job_title) }}</p>
                            <p class="fs-16 text-pink fw-5 mb-0">{{ ucwords($vcard->company) }} </p>
                            <p class="fs-14 text-gray-200 mt-4">{!! $vcard->description !!} </p>
                        </div>
                        {{-- social icons --}}
                        <div class="social-media-section">
                            @if (checkFeature('social_links') && getSocialLink($vcard))
                                <div class="d-flex flex-wrap justify-content-sm-start justify-content-center">
                                    @foreach (getSocialLink($vcard) as $value)
                                        <span class="social-icon justify-content-center align-items-center">
                                            {!! $value !!}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- contact --}}
            @if ((isset($managesection) && $managesection['contact_list']) || empty($managesection))
                <div class="contact-section pb-60 px-30">
                    <div class="abc-img">
                        <img src="{{ asset('assets/img/vcard24/abc.png') }}" alt="book" />
                    </div>
                    <div class="section-heading text-center">
                        <h2 class="mb-0">{{ __('messages.contact_us.contact') }}</h2>
                    </div>
                    <div class="row">
                        @if ($vcard->email)
                            <div class="col-sm-6 mb-20">
                                <div class="contact-box d-flex align-items-center">
                                    <div class="contact-icon d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('assets/img/vcard24/email.png') }}" />
                                    </div>
                                    <div class="contact-desc">
                                        <p class="text-gray-100 mb-0 fw-5">{{ __('messages.admin.email') }}</p>
                                        <a href="mailto:{{ $vcard->email }}"
                                            class="text-black fw-5">{{ $vcard->email }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($vcard->alternative_email)
                            <div class="col-sm-6 mb-20">
                                <div class="contact-box d-flex align-items-center">
                                    <div class="contact-icon d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('assets/img/vcard24/email.png') }}" />
                                    </div>
                                    <div class="contact-desc">
                                        <p class="text-gray-100 mb-0 fw-5">
                                            {{ __('messages.vcard.alter_email_address') }}</p>
                                        <a href="mailto:{{ $vcard->alternative_email }}"
                                            class="text-black fw-5">{{ $vcard->alternative_email }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($vcard->phone)
                            <div class="col-sm-6 mb-20">
                                <div class="contact-box d-flex align-items-center">
                                    <div class="contact-icon d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('assets/img/vcard24/phone.png') }}" />
                                    </div>
                                    <div class="contact-desc">
                                        <p class="text-gray-100 mb-0 fw-5">{{ __('messages.vcard.mobile_number') }}
                                        </p>
                                        <a href="tel:+{{ $vcard->region_code }}{{ $vcard->phone }}"
                                            class="text-black fw-5">+{{ $vcard->region_code }}{{ $vcard->phone }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($vcard->alternative_phone)
                            <div class="col-sm-6 mb-20">
                                <div class="contact-box d-flex align-items-center">
                                    <div class="contact-icon d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('assets/img/vcard24/phone.png') }}" />
                                    </div>
                                    <div class="contact-desc">
                                        <p class="text-gray-100 mb-0 fw-5">
                                            {{ __('messages.vcard.alternative_phone') }} </p>
                                        <a href="tel:+{{ $vcard->alternative_region_code }}{{ $vcard->alternative_phone }}"
                                            class="text-black fw-5">+{{ $vcard->alternative_region_code }}{{ $vcard->alternative_phone }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($vcard->dob)
                            <div class="col-sm-6 mb-sm-0 mb-20">
                                <div class="contact-box d-flex align-items-center">
                                    <div class="contact-icon d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('assets/img/vcard24/dob.png') }}" />
                                    </div>
                                    <div class="contact-desc">
                                        <p class="text-gray-100 mb-0 fw-5">{{ __('messages.vcard.dob') }} </p>
                                        <p class="mb-0 text-black fw-5">{{ $vcard->dob }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($vcard->location)
                            <div class="col-sm-6">
                                <div class="contact-box d-flex align-items-center">
                                    <div class="contact-icon d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('assets/img/vcard24/location.png') }}" />
                                    </div>
                                    <div class="contact-desc">
                                        <p class="text-gray-100 mb-0 fw-5">{{ __('messages.setting.address') }}</p>
                                        <p class="mb-0 text-black fw-5">{!! ucwords($vcard->location) !!}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            {{-- service --}}
            @if ((isset($managesection) && $managesection['services']) || empty($managesection))
                @if (checkFeature('services') && $vcard->services->count())
                    <div class="our-services-section px-30">
                        <div class="pencil-img1">
                            <img src="{{ asset('assets/img/vcard24/pencil-img1.png') }}" alt="book" />
                        </div>
                        <div class="triangle-img1 text-end">
                            <img src="{{ asset('assets/img/vcard24/triangle-img1.png') }}" alt="book" />
                        </div>
                        <div class="section-heading text-center">
                            <h2 class="mb-0">{{ __('messages.vcard.our_service') }}</h2>
                        </div>
                        <div class="services">
                            <div class="row">
                                @foreach ($vcard->services as $service)
                                    <div class="col-sm-6 mb-sm-0 mb-40 pt-30 mt-4">
                                        <div class="service-card h-100">
                                            <div class="card-img learning-img mx-auto d-flex">
                                                <img src="{{ $service->service_icon }}" />
                                            </div>
                                            <div class="card-body p-0">
                                                <h3 class="card-title fs-18 fw-5 text-black mb-10">
                                                    {{ ucwords($service->name) }}
                                                </h3>
                                                <p
                                                    class="mb-0 fs-14 text-gray-200 {{ \Illuminate\Support\Str::length($service->description) > 80 ? 'more' : '' }}">
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
            {{-- make appointment --}}
            @if ((isset($managesection) && $managesection['appointments']) || empty($managesection))
                @if (checkFeature('appointments') && $vcard->appointmentHours->count())
                    <div class="appointment-section pt-60 px-30">
                        <div class="one-img">
                            <img src="{{ asset('assets/img/vcard24/one.png') }}" alt="book" />
                        </div>
                        <div class="red-heart-img">
                            <img src="{{ asset('assets/img/vcard24/red-heart.png') }}" alt="book" />
                        </div>
                        <div class="yellow-star-img text-end">
                            <img src="{{ asset('assets/img/vcard24/yellow-star.png') }}" alt="book" />
                        </div>
                        <div class="two-img text-end">
                            <img src="{{ asset('assets/img/vcard24/two.png') }}" alt="book" />
                        </div>
                        <div class="three-img">
                            <img src="{{ asset('assets/img/vcard24/three.png') }}" alt="book" />
                        </div>
                        <div class="section-heading text-center">
                            <h2 class="mb-0">{{ __('messages.make_appointments') }}</h2>
                        </div>
                        <div class="appointment px-sm-4 mx-lg-3">
                            <div class="mb-20">
                                <div class="position-relative">
                                    {{ Form::text('date', null, ['class' => 'date appoint-input form-control  appointment-input', 'placeholder' => __('messages.form.pick_date'), 'id' => 'pickUpDate']) }}
                                </div>
                                <div class="mt-3">
                                    <div id="slotData" class="row ">
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <button type="submit" class="appointmentAdd btn btn-pink w-100">
                                            {{ __('messages.make_appointments') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('vcardTemplates.appointment')
                @endif
            @endif
            {{-- insta feed --}}
            @if ((isset($managesection) && $managesection['insta_embed']) || empty($managesection))
                @if (checkFeature('instagramEmbed') && $vcard->instagramEmbed->count())
                    <div class="">
                        <div class="section-heading text-center mx-30 mb-40 overflow-hidden">
                            <h2 class=" text-white mb-1 d-inline-block mt-5">
                                {{ __('messages.feature.insta_embed') }}
                            </h2>
                        </div>
                        <nav>
                            <div class="row insta-toggle">
                                <div class="nav nav-tabs border-0 px-0" id="nav-tab" role="tablist">
                                    <button class="py-2 active postbtn instagram-btn  border-0 text-dark"
                                        id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                        <span class="px-1">{{ __('messages.vcard.post') }}</span></button>
                                    <button class="py-2 instagram-btn reelsbtn  border-0 text-dark"
                                        id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                                        type="button" role="tab" aria-controls="nav-profile"
                                        aria-selected="false">
                                        <span class="px-1">{{ __('messages.vcard.reel') }}</span>
                                    </button>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div id="postContent" class="insta-feed">
                        <div class="row overflow-hidden m-0 mt-2">
                            <!-- "Post" content -->
                            @foreach ($vcard->InstagramEmbed as $InstagramEmbed)
                                @if ($InstagramEmbed->type == 0)
                                    <div class="col-12 col-sm-6 insta-embed">
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
                                    <div class="col-12 col-sm-6 insta-embed">
                                        {!! $InstagramEmbed->embedtag !!}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- gallery --}}
            @if ((isset($managesection) && $managesection['galleries']) || empty($managesection))
                @if (checkFeature('gallery') && $vcard->gallery->count())
                    <div class="gallery-section pt-60 px-30">
                        <div class="earth-img text-end">
                            <img src="{{ asset('assets/img/vcard24/earth.png') }}" alt="earth" />
                        </div>
                        <div class="star-img text-end">
                            <img src="{{ asset('assets/img/vcard24/star.png') }}" alt="star" />
                        </div>
                        <div class="section-heading text-center">
                            <h2 class="mb-0">{{ __('messages.plan.gallery') }}</h2>
                        </div>
                        <div class="gallery-slider">
                            @foreach ($vcard->gallery as $file)
                                @php
                                    $infoPath = pathinfo(public_path($file->gallery_image));
                                    $extension = $infoPath['extension'];
                                @endphp
                                <div class="slide">
                                    <div class="gallery-img px-2">
                                        @if ($file->type == App\Models\Gallery::TYPE_IMAGE)
                                            <a href="{{ $file->gallery_image }}" data-lightbox="gallery-images"><img
                                                    src="{{ $file->gallery_image }}" alt="profile"
                                                    class="w-100" /></a>
                                        @elseif($file->type == App\Models\Gallery::TYPE_FILE)
                                            <a id="file_url" href="{{ $file->gallery_image }}"
                                                class="gallery-link gallery-file-link" target="_blank">
                                                <div class="gallery-item gallery-file-item"
                                                    @if ($extension == 'pdf') style="background-image: url({{ asset('assets/images/pdf-icon.png') }})"> @endif
                                                    @if ($extension == 'xls') style="background-image: url({{ asset('assets/images/xls.png') }})"> @endif
                                                    @if ($extension == 'csv') style="background-image: url({{ asset('assets/images/csv-file.png') }})"> @endif
                                                    @if ($extension == 'xlsx') style="background-image: url({{ asset('assets/images/xlsx.png') }})"> @endif
                                                    </div>
                                            </a>
                                        @elseif($file->type == App\Models\Gallery::TYPE_VIDEO)
                                            <video width="100%" height="100%" controls>
                                                <source src="{{ $file->gallery_image }}">
                                            </video>
                                        @elseif($file->type == App\Models\Gallery::TYPE_AUDIO)
                                            <div class="audio-container mt-2">
                                                <img src="{{ asset('assets/img/music.jpeg') }}" alt="Album Cover"
                                                    class="audio-image">
                                                <audio controls src="{{ $file->gallery_image }}"
                                                    class="audio-control">
                                                    Your browser does not support the <code>audio</code> element.
                                                </audio>
                                            </div>
                                        @else
                                            <iframe src="https://www.youtube.com/embed/{{ YoutubeID($file->link) }}"
                                                class="w-100" height="315">
                                            </iframe>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- product --}}
            @if ((isset($managesection) && $managesection['products']) || empty($managesection))
                @if (checkFeature('products') && $vcard->products->count())
                    <div class="product-section pt-60 px-3">
                        <div class="bag-img">
                            <img src="{{ asset('assets/img/vcard24/bag.png') }}" alt="bag" />
                        </div>
                        <div class="brush-img text-end">
                            <img src="{{ asset('assets/img/vcard24/brush.png') }}" alt="brush" />
                        </div>
                        <div class="section-heading text-center">
                            <h2 class="mb-0">{{ __('messages.plan.products') }}</h2>
                        </div>
                        <div class="product-slider mb-30">
                            @foreach ($vcard->products as $product)
                                <div class="">
                                    <div class="product-card card">
                                        <div class="maskborder">
                                            <div class="mask">
                                                <div class="content">
                                                    <div class="product-img card-img">
                                                        <a @if ($product->product_url) href="{{ $product->product_url }}" @endif
                                                            target="_blank">
                                                            <img src="{{ $product->product_icon }}"
                                                                class="w-100 h-100 object-fit-cover" /></a>
                                                    </div>
                                                    <div class="product-desc card-body p-3">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-0">
                                                            <h3 class="text-black fs-18 fw-5 mb-0 product-name">
                                                                {{ $product->name }}</h3>
                                                            <p class="amount fs-18 fw-5 mb-0 text-green">
                                                                @if ($product->currency_id && $product->price)
                                                                    <span>{{ $product->currency->currency_icon }}{{ number_format($product->price, 2) }}</span>
                                                                @elseif($product->price)
                                                                    <span>{{ getUserCurrencyIcon($vcard->user->id) . ' ' . $product->price }}</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                        <p class="fs-12 text-gray-100 mb-0">
                                                            {{ $product->description }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center">
                            <a class="view-all fs-6 fw-5 text-pink text-decoration-underline"
                                href="{{ route('showProducts', ['id' => $vcard->id, 'alias' => $vcard->url_alias]) }}">{{ __('messages.analytics.view_more') }}</a>
                        </div>
                    </div>
                @endif
            @endif
            {{-- testimonial --}}
            @if ((isset($managesection) && $managesection['testimonials']) || empty($managesection))
                @if (checkFeature('testimonials') && $vcard->testimonials->count())
                    <div class="testimonial-section pt-60">
                        <div class="clip-img">
                            <img src="{{ asset('assets/img/vcard24/clip.png') }}" alt="clip" />
                        </div>
                        <div class="color-plat-img">
                            <img src="{{ asset('assets/img/vcard24/color-plat.png') }}" alt="color-plat" />
                        </div>
                        <div class="pencil-color-img text-end">
                            <img src="{{ asset('assets/img/vcard24/pencil-color.png') }}" alt="pencil-color" />
                        </div>

                        <div class="section-heading text-center px-3">
                            <h2 class="mb-0">{{ __('messages.plan.testimonials') }}</h2>
                        </div>
                        <div class="testimonial-slider">
                            @foreach ($vcard->testimonials as $testimonial)
                                <div class="">
                                    <div
                                        class="testimonial-card card d-flex flex-sm-row-reverse flex-column justify-content-center">
                                        <div class="card-img mx-auto">
                                            <div class="mask">
                                                <img src="{{ $testimonial->image_url }}"
                                                    class="w-100 h-100 object-fit-cover" />
                                            </div>
                                        </div>
                                        <div class="card-body p-0 pe-sm-3 text-sm-start text-center">
                                            <div class="">
                                                <div class="profile-desc mt-3">
                                                    <h3 class="text-black fs-18 mb-0 fw-6">
                                                        {{ ucwords($testimonial->name) }}</h3>
                                                </div>
                                                <p
                                                    class="desc text-gray-100 fs-14 mb-0 {{ \Illuminate\Support\Str::length($testimonial->description) > 80 ? 'more' : '' }}">
                                                    {!! $testimonial->description !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- blog --}}
            @if ((isset($managesection) && $managesection['blogs']) || empty($managesection))
                @if (checkFeature('blog') && $vcard->blogs->count())
                    <div class="blog-section pt-60 px-3">
                        <div class="paper-plane-img">
                            <img src="{{ asset('assets/img/vcard24/paper-plane.png') }}" alt="paper-plane" />
                        </div>
                        <div class="cloud-vector-img text-end">
                            <img src="{{ asset('assets/img/vcard24/cloud-vector.png') }}" alt="cloud-vector" />
                        </div>
                        <div class="star-img2 text-end">
                            <img src="{{ asset('assets/img/vcard24/star.png') }}" alt="star" />
                        </div>
                        <div class="section-heading text-center">
                            <h2 class="mb-0">{{ __('messages.feature.blog') }}</h2>
                        </div>
                        <div class="blog-slider">
                            @foreach ($vcard->blogs as $blog)
                                <div class="">
                                    <div class="blog-card card">
                                        <div class="card-img mb-3">
                                            <a href="{{ route('vcard.show-blog', [$vcard->url_alias, $blog->id]) }}">
                                                <img src="{{ $blog->blog_icon }}"
                                                    class="w-100 h-100 object-fit-cover" />
                                            </a>
                                        </div>
                                        <div class="card-body p-0">
                                            <h2 class="fs-6 fw-6 text-black blog-head">{{ $blog->title }}</h2>
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
                    <div class="business-hour-section pt-60 px-30">
                        <div class="rainbow-img">
                            <img src="{{ asset('assets/img/vcard24/rainbow.png') }}" alt="rainbow" />
                        </div>
                        <div class="triangle-img2 text-end mt-3">
                            <img src="{{ asset('assets/img/vcard24/triangle-img2.png') }}" alt="triangle" />
                        </div>
                        <div class="section-heading text-center">
                            <h2 class="mb-0">{{ __('messages.business.business_hours') }}</h2>
                        </div>
                        <div class="">
                            <div class="business-hours mt-3">
                                @foreach ($businessDaysTime as $key => $dayTime)
                                    <div class="mb-10 d-flex justify-content-between">
                                        <span>{{ __('messages.business.' . \App\Models\BusinessHour::DAY_OF_WEEK[$key]) . ':' }}</span>
                                        <span>{{ $dayTime ?? __('messages.common.closed') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- qr code --}}
            @if (isset($vcard['show_qr_code']) && $vcard['show_qr_code'] == 1)
                <div class="qr-code-section pt-60 px-30">
                    <div class="pencil-img2">
                        <img src="{{ asset('assets/img/vcard24/pencil-img2.png') }}" alt="pencil" />
                    </div>
                    <div class="lab-img1 text-end">
                        <img src="{{ asset('assets/img/vcard24/lab-img1.png') }}" alt="lab-img" />
                    </div>
                    <div class="lab-img2 text-end">
                        <img src="{{ asset('assets/img/vcard24/lab-img2.png') }}" alt="lab-img" />
                    </div>
                    <div class="blue-heart-img text-end">
                        <img src="{{ asset('assets/img/vcard24/blue-heart.png') }}" alt="blue-heart" />
                    </div>
                    <div class="section-heading text-center">
                        <h2 class="mb-0">{{ __('messages.vcard.qr_code') }}</h2>
                    </div>
                    <div class="qr-code d-flex justify-content-center align-items-center flex-wrap mb-30">
                        <div class="qr-profile-img">
                            <img src="{{ $vcard->profile_url }}" class="w-100 h-100 object-fit-cover" />
                        </div>
                        <div class="qr-code-img" id="qr-code-twentyfour">
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
            @endif
            {{-- iframe --}}
            @if ((isset($managesection) && $managesection['iframe']) || empty($managesection))
                @if (checkFeature('iframes') && $vcard->iframes->count())
                    <div class="blog-section pt-40 pb-40 ">
                        <div class="section-heading text-center">
                            <h2 class="mb-0"> {{ __('messages.vcard.iframe') }}</h2>
                        </div>
                        <div class="iframe-slider">
                            @foreach ($vcard->iframes as $iframe)
                                <div class="slide p-3">
                                    <div class="iframe-card">
                                        <div class="overlay">
                                            <iframe src="{{ $iframe->url }}" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen width="100%" height="400">
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- inquiry --}}
            @php
                $currentSubs = $vcard
                    ->subscriptions()
                    ->where('status', \App\Models\Subscription::ACTIVE)
                    ->latest()
                    ->first();
            @endphp
            @if ($currentSubs && $currentSubs->plan->planFeature->enquiry_form && $vcard->enable_enquiry_form)
                <div class="contact-us-section px-30">
                    <div class="crystal-img">
                        <img src="{{ asset('assets/img/vcard24/crystal.png') }}" alt="crystal" />
                    </div>
                    <div class="apple-img">
                        <img src="{{ asset('assets/img/vcard24/apple.png') }}" alt="apple" />
                    </div>
                    <div class="half-round-img text-end">
                        <img src="{{ asset('assets/img/vcard24/half-round.png') }}" alt="half-round" />
                    </div>
                    <div class="section-heading text-center">
                        <h2 class="mb-0">{{ __('messages.contact_us.inquries') }}</h2>
                    </div>
                    <div class="contact-form">
                        <form action="" id="enquiryForm">
                            @csrf
                            <div class="row">
                                <div id="enquiryError" class="alert alert-danger d-none"></div>
                                <div class="col-sm-6 pe-sm-2">
                                    <input type="text" class="form-control" name="name"
                                        placeholder="{{ __('messages.form.your_name') }}" />
                                </div>
                                <div class="col-sm-6 ps-sm-2">
                                    <input type="email" class="form-control" name="email"
                                        placeholder="{{ __('messages.form.your_email') }}" />
                                </div>
                                <div class="col-12">
                                    <input type="tel" class="form-control" name="phone"
                                        placeholder="{{ __('messages.form.phone') }}" />
                                </div>

                                <div class="col-12 mb-30">
                                    <textarea class="form-control h-100" name="message" placeholder="{{ __('messages.form.type_message') }}"
                                        rows="3"></textarea>
                                </div>
                                @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                                    <div class="col-12 mb-4">
                                        <input type="checkbox" name="terms_condition"
                                            class="form-check-input terms-condition required"
                                            id="termConditionCheckbox" placeholder>&nbsp;
                                        <label class="form-check-label" for="privacyPolicyCheckbox">
                                            <span class="text-black">{{ __('messages.vcard.agree_to_our') }}</span>
                                            <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                                                target="_blank"
                                                class="text-decoration-none link-info fs-6">{!! __('messages.vcard.term_and_condition') !!}</a>
                                            <span class="text-black">&</span>
                                            <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                                                target="_blank"
                                                class="text-decoration-none link-info fs-6">{{ __('messages.vcard.privacy_policy') }}</a>
                                        </label>
                                    </div>
                                @endif
                                <div class="col-12 text-center">
                                    <button class="send-btn btn rounded btn-orange" type="submit">
                                        {{ __('messages.contact_us.send_message') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            @if (!empty($userSetting['enable_affiliation']))
                <div class="">
                    <div class="create-vcard-section pt-60">
                        <div class="notes-img">
                            <img src="{{ asset('assets/img/vcard24/notes.png') }}" alt="notes" />
                        </div>
                        <div class="fusion-img text-end">
                            <img src="{{ asset('assets/img/vcard24/fusion.png') }}" alt="fusion" />
                        </div>
                        <div class="ball-img text-end">
                            <img src="{{ asset('assets/img/vcard24/ball.png') }}" alt="ball" />
                        </div>
                        <div class="section-heading text-center px-30">
                            <h2 class="mb-0">{{ __('messages.create_vcard') }}</h2>
                        </div>
                        <div class="pt-50 pb-50 vcard-bg px-30">
                            <div class="vcard-link-card card">
                                <div class="d-flex justify-content-center align-items-center link">
                                    <a href="{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}"
                                        target="blank"
                                        class="fw-6 text-pink link-text">{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}</a>
                                    <i class="icon fa-solid fa-arrow-up-right-from-square text-pink ms-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- map --}}
            @if ((isset($managesection) && $managesection['map']) || empty($managesection))
                <div class="container">
                    <div class="d-flex mt-5 flex-column justify-content-center mt-2 mb-sm-5 pb-30">
                        @if ($vcard->location_url && isset($url[5]))
                            <div class="m-2 mb-10 mt-0">
                                <iframe width="100%" height="300px"
                                    src='https://maps.google.de/maps?q={{ $url[5] }}/&output=embed'
                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                                    style="border-radius: 10px;"></iframe>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            {{-- add to contact --}}
            @if (
                !isset($userSetting['enable_contact']) ||
                    (!$userSetting['enable_contact'] && $userSetting['enable_contact'] != 0) ||
                    $userSetting['enable_contact'] == 1)
                <div class="bg-img">
                    <img src="{{ asset('assets/img/vcard24/main-bg.png') }}" class="w-100" />
                </div>
                <div class="add-to-contact-section">
                    <div class="text-center">
                        <a href="{{ route('add-contact', $vcard->id) }}"
                            class="btn btn-cyan add-contact-btn rounded"><i
                                class="fas fa-download fa-address-book"></i>
                            &nbsp;{{ __('messages.setting.add_contact') }}</a>
                    </div>
                </div>
            @endif
            {{-- made by --}}
            <div class="d-flex justify-content-evenly">
                @if (checkFeature('advanced'))
                    @if (checkFeature('advanced')->hide_branding && $vcard->branding == 0)
                        @if ($vcard->made_by)
                            <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                                class="text-center text-decoration-none text-light" target="_blank">
                                <small>{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
                            </a>
                        @else
                            <div class="text-center">
                                <small class="text-light">{{ __('messages.made_by') }}
                                    {{ $setting['app_name'] }}</small>
                            </div>
                        @endif
                    @endif
                @else
                    @if ($vcard->made_by)
                        <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                            class="text-center text-decoration-none text-light" target="_blank">
                            <small>{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
                        </a>
                    @else
                        <div class="text-center">
                            <small class="text-light">{{ __('messages.made_by') }}
                                {{ $setting['app_name'] }}</small>
                        </div>
                    @endif
                @endif
                @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                    <div>
                        <a class="text-decoration-none text-light cursor-pointer terms-policies-btn"
                            href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"><small>{!! __('messages.vcard.term_policy') !!}</small></a>
                    </div>
                @endif
            </div>
            {{-- sticky button --}}
            <div class="btn-section cursor-pointer">
                <div class="fixed-btn-section">
                    @if (empty($userSetting['hide_stickybar']))
                        <div class="bars-btn school-bars-btn">
                            <img src="{{ asset('assets/img/vcard24/sticky.png') }}" />
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
                                            class="vcard24-sticky-btn vcard24-btn-group d-flex justify-content-center align-items-center rounded-0 text-decoration-none py-1 rounded-pill justify-content share-wp-btn">
                                            <i class="fa-solid fa-paper-plane"></i> </a>
                                    </div>
                                </div>
                            @endif
                            @if (empty($userSetting['hide_stickybar']))
                                <div
                                    class="{{ isset($userSetting['whatsapp_share']) && $userSetting['whatsapp_share'] == 1 ? 'vcard24-btn-group' : 'stickyIcon' }}">
                                    <button type="button"
                                        class="vcard24-btn-group vcard24-share vcard24-sticky-btn mb-3 px-2 py-1 border-0"><i
                                            class="fas fa-share-alt fs-4 mt-1"></i></button>
                                    @if (!empty($vcard->enable_download_qr_code))
                                        <a type="button"
                                            class="vcard24-btn-group vcard24-sticky-btn d-flex justify-content-center  align-items-center  px-2 mb-3 py-2"
                                            id="qr-code-btn" download="qr_code.png"><i
                                                class="fa-solid fa-qrcode fs-4"></i></a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- newslatter modal --}}
            @if ((isset($managesection) && $managesection['news_latter_popup']) || empty($managesection))
                <div class="modal fade" id="newsLatterModal" tabindex="-1" aria-labelledby="newsLatterModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog news-modal">
                        <div class="modal-content animate-bottom" id="newsLatter-content">
                            <div class="newsmodal-header">
                                <button type="button" class="btn-close text-light position-absolute top-0 end-0"
                                    data-bs-dismiss="modal" aria-label="Close" id="closeNewsLatterModal"></button>
                                <h1 class="newsmodal-title text-center mt-5" id="newsLatterModalLabel"><i
                                        class="fa-solid fa-envelope-open-text"></i></h1>
                            </div>
                            <div class="modal-body">
                                <h1 class="content text-center  p-2">{{ __('messages.vcard.subscribe_newslatter') }}
                                </h1>
                                <h3 class="modal-desc text-center">{{ __('messages.vcard.update_directly') }}</h3>
                                <form action="" method="post" id="newsLatterForm">
                                    @csrf
                                    <input type="hidden" name="vcard_id" value="{{ $vcard->id }}">
                                    <div class="input-group mb-3 mt-5">
                                        <input type="email" class="form-control bg-dark border-0 text-light"
                                            placeholder="{{ __('messages.form.enter_your_email') }}" name="email"
                                            id="emailSubscription" aria-label="Email"
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
            <div id="vcard24-shareModel" class="modal fade" role="dialog">
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
                                        class="btn btn-sm btn-icon btn-active-color-danger border-none"
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
                                        <p class="align-items-center text-dark fw-bolder">
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

                                        <span class="fa-2x"><svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path
                                                    d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                                            </svg></span>

                                    </div>
                                    <div class="col-9 p-1">
                                        <p class="align-items-center text-dark fw-bolder">
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
                            <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}"
                                target="_blank" class="text-decoration-none share" title="Linkedin">
                                <div class="row">
                                    <div class="col-2">
                                        <i class="fab fa-linkedin fa-2x" style="color: #1B95E0"></i>
                                    </div>
                                    <div class="col-9 p-1">
                                        <p class="align-items-center text-dark fw-bolder">
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
                                        <p class="align-items-center text-dark fw-bolder">
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
                                        <p class="align-items-center text-dark fw-bolder">
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
                                        <p class="align-items-center text-dark fw-bolder">
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
                                        <p class="align-items-center text-dark fw-bolder">
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
                                    <input type="text" class="form-control"
                                        placeholder="{{ request()->fullUrl() }}" disabled>
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
        </div>
    </div>
</body>
@include('vcardTemplates.template.templates')
<script src="https://js.stripe.com/v3/"></script>
<script src="../js/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/front-third-party.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>
<script>
    $().ready(function() {
        $(".gallery-slider").slick({
            arrows: false,
            infinite: false,
            dots: true,
            slidesToShow: 1,
            autoplay: true,
            prevArrow: '<button class="slide-arrow prev-arrow"><i class="fa-solid fa-arrow-left"></i></button>',
            nextArrow: '<button class="slide-arrow next-arrow"><i class="fa-solid fa-arrow-right"></i></button>',
            responsive: [{
                breakpoint: 575,
                settings: {
                    infinite: true,
                    arrows: false,
                    dots: true,
                },
            }, ],
        });
        $(".product-slider").slick({
            arrows: false,
            infinite: true,
            dots: false,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            responsive: [{
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                    dots: false,
                },
            }, ],
        });
        $(".testimonial-slider").slick({
            arrows: false,
            infinite: true,
            dots: false,
            slidesToShow: 1,
            autoplay: true,
        });
        $(".blog-slider").slick({
            arrows: false,
            infinite: true,
            dots: true,
            slidesToShow: 2,
            autoplay: true,
            responsive: [{
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                    dots: true,
                },
            }, ],
        });
        $(".iframe-slider").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            speed: 300,
            infinite: true,
            autoplaySpeed: 5000,
            autoplay: false,
            responsive: [{
                    breakpoint: 575,
                    settings: {
                        centerPadding: "125px",
                        dots: true,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        centerPadding: "0",
                        dots: true,
                    },
                },
            ],
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
    const qrCodeTwenty = document.getElementById("qr-code-twentyfour");
    const svg = qrCodeTwenty.querySelector("svg");
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
