    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@yield('title') | {{ getAppName() }}</title>
        <!-- Favicon -->
        <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <!-- General CSS Files -->

        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
        {{--        <link rel="stylesheet" type="text/css" href="{{ asset('assets/scss/custom.css') }}"> --}}

        @if (!getLogInUser()->theme_mode)
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
        @else
            <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.dark.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.dark.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-pages-dark.css') }}">
        @endif
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/page.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.css') }}">

        @livewireStyles

        <script src="{{ asset('vendor/livewire/livewire.js') }}"></script>
        @include('layouts.livewire-turbo')
        <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
            data-turbolinks-eval="false" data-turbo-eval="false"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <script src="https://checkout.razorpay.com/v1/checkout.js" data-turbolinks-eval="false" data-turbo-eval="false">
        </script>
        <script src="{{ asset('assets/js/third-party.js') }}"></script>

        <script data-turbo-eval="false">
            let mobileValidation = "{{ getSuperAdminSettingValue('mobile_validation') }}"
            let stripe = ''
            @if (getSelectedPaymentGateway('stripe_key'))
                stripe = Stripe('{{ getSelectedPaymentGateway('stripe_key') }}')
            @endif
            let appUrl = "{{ config('app.url') }}"
            let noData = "{{ __('messages.no_data') }}"
            let utilsScript = "{{ asset('assets/js/inttel/js/utils.min.js') }}"
            let defaultProfileUrl = "{{ asset('web/media/avatars/user.png') }}"
            let defaultTemplate = "{{ asset('assets/images/default_cover_image.jpg') }}"
            let defaultServiceIconUrl = "{{ asset('assets/images/default_service.png') }}"
            let defaultCoverUrl = "{{ asset('assets/images/default_cover_image.jpg') }}"
            let defaultGalleryUrl = "{{ asset('assets/images/default_service.png') }}"
            let defaultAppLogoUrl = "{{ asset(getAppLogo()) }}"
            let defaultFaviconUrl = "{{ getFaviconUrl() }}"
            let getLoggedInUserdata = "{{ getLogInUser() }}"
            window.getLoggedInUserLang = "{{ getCurrentLanguageName() }}"
            let lang = "{{ Illuminate\Support\Facades\Auth::user()->language ?? 'en' }}"
            let getCurrencyCode = "{{ getMaximumCurrencyCode($getIcon = true) }}"
            let sweetAlertIcon = "{{ asset('images/remove.png') }}"
            let sweetCompletedAlertIcon = "{{ asset('images/Alert.png') }}"
            let defaultCountryCodeValue = "{{ getSuperAdminSettingValue('default_country_code') }}"
            let getUniqueVcardUrlAlias = "{{ getUniqueVcardUrlAlias() }}"
            let currencyAfterAmount = "{{ getSuperAdminSettingValue('currency_after_amount') }}"
            $(document).ready(function() {
                $('[data-bs-toggle="tooltip"]').tooltip()
            })
        </script>

        @stack('scripts')
        <script src="{{ asset('messages.js') }}"></script>
        <script src="{{ asset('assets/js/pages.js') }}"></script>
        @routes
    </head>

    <body>
        <div class="d-flex flex-column flex-root vh-100">
            <div class="d-flex flex-row flex-column-fluid">
                @include('layouts.sidebar')
                <div class="wrapper d-flex flex-column flex-row-fluid">
                    <div class='container-fluid d-flex align-items-stretch justify-content-between px-0'>
                        @include('layouts.header')
                    </div>
                    <div class='content d-flex flex-column flex-column-fluid pt-7 overflow-scroll'>
                        @yield('header_toolbar')
                        <div class='d-flex flex-wrap flex-column-fluid'>
                            @yield('content')
                        </div>
                    </div>
                    <div class='container-fluid'>
                        @include('layouts.footer')
                    </div>
                </div>
            </div>
        </div>

        @include('profile.changePassword')
        @include('profile.changelanguage')


    </body>

    </html>
