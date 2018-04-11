<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
<head>
    @include('snippets.google-analytics')

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="alternate" hreflang="x-default" href="{{ LaravelLocalization::getNonLocalizedURL() }}" />
    @if(!isset($no_translations))
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <link rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" />
        @endforeach
    @endif

    @include('snippets.icons')

    <title>
        @section('title')
            {{ config('app.name') }}
        @show
    </title>

    <link href="{{ mix($style) }}" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
    
</head>
<body class="{{ $body_class }}">

@yield('body')

<script src="{{ mix('js/website.js') }}"></script>
@include('snippets.cookie-law')
</body>
</html>
