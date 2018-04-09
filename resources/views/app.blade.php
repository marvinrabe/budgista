<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('snippets.google-analytics')

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="alternate" hreflang="x-default" href="{{ route('app') }}" />

    @include('snippets.icons')

    <meta name="application-name" content="{{ config('app.name') }}"/>
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <title>{{ config('app.name') }}</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>
<body>

<div id="app">
    <router-view></router-view>
    <vue-snotify></vue-snotify>
</div>

@if(config('app.env') == 'production')
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=default,Intl,Intl.~locale.{{ app()->getLocale() }}"></script>
@endif

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
