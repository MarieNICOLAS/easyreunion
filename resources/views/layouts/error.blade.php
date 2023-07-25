<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <title>@yield('title', __('meta.default.title'))</title>
    <meta name="description" content="@yield('meta-description', __('meta.default.description'))"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo/apple-icon-180x180') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/logo/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/logo/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

</head>
<body>

<div>
    <div class="h-screen flex items-center justify-center">
        <div class="-mt-12">
            <img class="mx-auto my-12 px-6" src="{{ asset('images/logo/new-logo-small.png') }}"/>
            @yield('content')
        </div>
    </div>
</div>

<div class="fill-blank"></div>


@stack('scripts')

</body>
</html>
