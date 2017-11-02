@extends('layouts.base',  ['body_class' => 'layout-budget'])

@section('body')

    <div id="app">

        <app-layout></app-layout>

    </div>

    @if(config('app.env') == 'production')
        <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=default,Intl.~locale.{{ app()->getLocale() }}"></script>
    @endif

    <script src="{{ asset('js/app.js') }}"></script>

@endsection