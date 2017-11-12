@extends('layouts.base', ['body_class' => 'layout-home', 'style' => 'css/website.css'])

@section('title')
    {{ trans('static.home.title') }} - {{ config('app.name') }}
@overwrite

@section('body')

    <header>
        <nav class="navbar navbar-expand navbar-dark">
            <div class="container">
                <a class="navbar-brand logo logo-white" href="/">
                    {{ config('app.name') }}
                </a>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ trans('title.login') }}</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="intro-message">
            <h1>{{ trans('static.home.heading') }}</h1>
            <p class="lead">{{ trans('static.home.lead') }}</p>

            <a href="{{ route('register') }}" class="btn btn-lg btn-outline-light m-2">
                {{ trans('static.home.cta') }}
            </a>

            <p class="m-0"><em class="small">{{ trans('static.home.free') }}</em></p>
        </div>
    </div>

    @include('helpers.footer')

@endsection('body')

