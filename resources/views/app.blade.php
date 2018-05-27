<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('snippets.google-analytics')

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="alternate" hreflang="x-default" href="{{ route('app') }}"/>

    @include('snippets.icons')

    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>
<body>

<div id="app">
    <div class="d-flex flex-column align-items-center justify-content-center container" style="height: 100%">

        <div class="spinner" role="progressbar">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>

        <noscript>
            <div class="alert alert-warning" role="alert">
                <strong>{{ trans('title.no_script') }}</strong>
                {{ trans('message.no_script') }}
            </div>
            <style>
                .spinner {
                    display: none;
                }
            </style>
        </noscript>
    </div>
</div>

@if(config('app.env') == 'production')
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=default,Intl,Intl.~locale.{{ app()->getLocale() }}"></script>
@endif
@include('snippets.sentry')
<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
