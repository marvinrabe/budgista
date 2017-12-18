@extends('layouts.base',  ['body_class' => 'layout-budget', 'style' => 'css/app.css', 'no_translations' => true])

@section('body')

    <div id="app">

        <app-layout></app-layout>

    </div>

    @if(config('app.env') == 'production')
        <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=default,Intl.~locale.{{ app()->getLocale() }}"></script>
    @endif

    <script src="{{ mix('js/app.js') }}"></script>

@endsection