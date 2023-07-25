<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <title>@yield('title', __('meta.default.title'))</title>

    <meta name="description" content="@yield('meta-description', __('meta.default.description'))"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="keywords" content="location, salle, professionnels, Paris, Île-de-France, événement, réunion, conférence, formation">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    @hasSection('canonical')
        <link rel="canonical" href="@yield('canonical')"/>
    @else
        <link rel="canonical" href="{{  Request::url() }}"/>
    @endif

    @hasSection('noindex')
        <meta name="robots" content="@yield('noindex')"/>
    @endif

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/logo/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/logo/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!-- Standard Open graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', __('meta.default.title'))"/>
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}"/>
    <meta property="og:description" content="@yield('meta-description', __('meta.default.description'))">
    <meta property="og:url" content="{{  Request::url() }}"/>
    <meta property="og:image" content="{{ asset('images/er-image-bg3.webp') }}">
    <!-- Standard Open graph Twitter Card -->
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:url" content="{{  Request::url() }}">
    <meta name="twitter:title" content="@yield('title', __('meta.default.title'))">
    <meta name="twitter:description" content="@yield('meta-description', __('meta.default.description'))">
    <meta name="twitter:image" content="{{ asset('images/er-image-bg3.webp') }}">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MQD2TN8MLY"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-MQD2TN8MLY');
    </script>
</head>
<body>
@include('layouts._partials.header')
<div>
<button id="btnUp"
       type="button"
       aria-label="Défiler vers le haut"
       class="easyBtn text-white font-bold py-1 px-1 rounded fixed bottom-28 right-10 z-40 dNoneForMobil">
       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
           <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
       </svg>
</button>

   @yield('content')
</div>


<div class="fill-blank"></div>

@include('layouts._partials.footer')

@stack('scripts')
@stack('end-body')
<script src="{{ mix('js/app-front.js') }}"></script>
</body>
</html>
