<!DOCTYPE html>
<html lang="{{ auth()->user()->language }}">
<head>
    @include('snippets.google-analytics')

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="alternate" hreflang="x-default" href="{{ route('app') }}" />

    @include('snippets.icons')

    {{--
    Enables web app support. Only useful when Navigation between pages not via links
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    + android manifest
    --}}
    <meta name="application-name" content="{{ config('app.name') }}"/>

    <title>{{ config('app.name') }}</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>
<body>

<div id="app">
    <app-layout></app-layout>
</div>

@include('snippets.zendesk')

@if(config('app.env') == 'production' or true)
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=default,Intl,Intl.~locale.{{ auth()->user()->language }}"></script>
@endif

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
