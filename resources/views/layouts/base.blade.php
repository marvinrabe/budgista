<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('img/apple-touch-icon-57x57.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('img/apple-touch-icon-114x114.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('img/apple-touch-icon-72x72.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('img/apple-touch-icon-144x144.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ asset('img/apple-touch-icon-120x120.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ asset('img/apple-touch-icon-152x152.png') }}"/>

    <link rel='mask-icon' href='{{ asset('img/icon.svg') }}' color='#007BFF'>
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    {{--
    Enables web app support. Only useful when Navigation between pages not via links
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    --}}

    <meta name="application-name" content="{{ config('app.name') }}"/>

    <meta name="msapplication-TileColor" content="#007BFF"/>
    <meta name="msapplication-TileImage" content="{{ asset('img/mstile-144x144.png') }}"/>

    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="{{$body_class}}">

<div id="app">

    @yield('body')

</div>

<script>
    @if(Auth::check())
    window.currency = '{{ Auth::user()->currency }}';
    @endif
    window.locale = '{{ config('app.locale') }}';
</script>

<!--<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=Intl.~locale.{{ config('app.locale') }}"></script>-->
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
