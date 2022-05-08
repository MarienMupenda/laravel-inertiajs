<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title inertia>{{config('app.name','Uzaraka')}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="referrer" content="always">
        <meta name="author" content="Marien Mupenda">
        <meta name="keywords" content="ecommerce,congo,lubumabshi,smirltech,marketplace">
        <meta name="description" content="Nous vulgarisons les produits et services made in congo🇨🇩 et nous rendons possible la vente en ligne ainsi que la gestion à distance">
        <link rel="canonical" href="{{url('/')}}">

        @include('analytics')

        <!-- Favicon-->
        <link rel="shortcut icon" href="{{asset('images/icons/logo.png')}}">

        <!--  SEO -->
        <meta property="fb:app_id" content="444914197218751">
        <meta property="og:title" content="Uzaraka - La simplicité dans vos achats et ventes">
        <meta property="og:type" content="website">
        <meta property="og:description" content="Nous vulgarisons les produits et services made in congo🇨🇩 et nous rendons possible la vente en ligne ainsi que la gestion à distance">
        <meta property="og:image" content="{{asset('images/icons/logo.png')}}">
        <meta property="og:url" content="{{url('/')}}">
        <meta name="twitter:card" content="{{asset('images/icons/logo.png')}}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

        @env ('local')
            <script src="http://localhost:8080/js/bundle.js"></script>
        @endenv
    </body>
</html>
