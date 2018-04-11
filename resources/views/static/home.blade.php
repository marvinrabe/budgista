@extends('layouts.base', ['body_class' => 'layout-home', 'style' => 'css/website.css'])

@section('title')
    {{ trans('static.home.title') }} - {{ config('app.name') }}
@overwrite

@section('body')

    <header class="border-bottom">
        <div class="decoration">
            <nav class="navbar navbar-expand navbar-light">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ asset('/images/logo.svg') }}" alt="{{ config('app.name') }}" height="30">
                    </a>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="btn btn-text-dark" href="{{ route('login') }}">{{ trans('title.login') }}</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container">
                <div class="intro-message">
                    <h1>{{ trans('static.home.heading') }}</h1>
                    <p class="lead">{{ trans('static.home.lead') }}</p>

                    <a href="{{ route('register') }}" class="btn btn-lg btn-primary mt-2 shadow-1">
                        {{ trans('static.home.cta') }}
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container pt-4 pt-md-5">
        <div class="row">
            @each('static._bullet', trans('static.home.bullets'), 'bullet')
        </div>
        <div class="row mb-md-3">
            <div class="px-4 px-md-5 d-sm-block d-none">
                <img src="{{ asset('images/desktop.png') }}" class="img-fluid" alt="Budgista on Laptop">
            </div>
            <div class="px-3 d-sm-none">
                <img src="{{ asset('images/mobile.png') }}" class="img-fluid" alt="Budgista on Mobile Device">
            </div>
        </div>
    </div>

    <div class="container text-center">
        <div class="pb-4 pb-md-5 second-cta">
            <p class="h2 m-0">{{ trans('static.home.lead2') }}</p>

            <a href="{{ route('register') }}" class="btn btn-lg btn-primary mt-3 shadow-1">
                {{ trans('static.home.cta') }}
            </a>
        </div>
    </div>

    <div class="container text-muted py-4 help">
        <p class="h4 m-0">
            {{ trans('static.home.help') }}
        </p>
        <a href="mailto:support@budgista.com" class="btn btn-lg btn-text-primary">
            {{ trans('static.home.contact') }}
        </a>
    </div>

    @include('snippets.footer')

@endsection('body')
