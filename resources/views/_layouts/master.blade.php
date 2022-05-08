<!DOCTYPE html>
<html lang="{{ $page->language ?? 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="referrer" content="always">
    <meta name="author" content="Marien Mupenda">
    <meta name="keywords" content="ecommerce,congo,lubumabshi,smirltech,marketplace">
    @yield('meta_tags')

    <title>{{ $page->title }}</title>

    <!-- Icons -->
    <link href="{{ asset('vendor/zmdi/css/material-design-iconic-font.css') }}" rel="stylesheet">


    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @include('analytics')
</head>
<body>
    <div x-data="{ cartOpen: false , isOpen: false }">
        @include('_layouts._navbar')

        @include('_layouts._cart')

        <main class="my-8">
            @yield('body')
        </main>

        @include('_layouts._footer')
    </div>
</body>
</html>
