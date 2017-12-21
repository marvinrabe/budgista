@extends('layouts.base', ['body_class' => 'layout-home', 'style' => 'css/website.css'])

@section('title')
    {{ trans('static.home.title') }} - {{ config('app.name') }}
@overwrite

@section('body')

    <header>
        <nav class="navbar navbar-expand navbar-light">
            <div class="container">
                <a class="navbar-brand logo" href="{{ route('home') }}">
                    {{ config('app.name') }}
                </a>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="btn btn-light" href="{{ route('login') }}">{{ trans('title.login') }}</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <div class="intro-message">
                <h1>{{ trans('static.home.heading') }}</h1>
                <p class="lead">{{ trans('static.home.lead') }}</p>

                <a href="{{ route('register') }}" class="btn btn-lg btn-primary mt-2">
                    {{ trans('static.home.cta') }}
                </a>
            </div>
        </div>
    </header>

    <div class="container py-5">
        <div class="row">
            @each('static._bullet', trans('static.home.bullets'), 'bullet')
        </div>
        {{--
        <img src="{{ asset('images/product/desktop_'.config('app.locale').'.png') }}" class="img-fluid px-5 mt-3">
        --}}
    </div>

    <div class="container text-center">
        <div class="py-5 second-cta">
            <p class="h2 m-0">{{ trans('static.home.lead2') }}</p>

            <a href="{{ route('register') }}" class="btn btn-lg btn-primary mt-3">
                {{ trans('static.home.cta') }}
            </a>
        </div>
    </div>

    <div class="container text-muted py-5 help">
        <p class="h4 m-0">
            {{ trans('static.home.help') }}
        </p>
        <a href="javascript: window.zE.activate({hideOnClose: true});" class="btn btn-outline-secondary">
            {{ trans('static.home.contact') }}
        </a>
    </div>

    @include('snippets.footer')

@endsection('body')
