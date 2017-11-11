@extends('layouts.base', ['body_class' => 'layout-home', 'style' => 'css/website.css'])

@section('title')
    {{ config('app.name') }} - Keeping a Budget was never easier!
@endsection('title')

@section('body')

    <header>
        <nav class="navbar navbar-expand navbar-dark">
            <div class="container">
                <a class="navbar-brand logo logo-white" href="/">
                    {{ config('app.name') }}
                </a>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="intro-message">
            <h1>Keeping a Budget is easy!</h1>
            <p class="lead">Get out of dept and save money.</p>

            <a href="{{ route('register') }}" class="btn btn-lg btn-outline-light m-2">
                Start your Budget now
            </a>

            <p class="m-0"><em class="small">It's completely free!</em></p>
        </div>
    </div>

    @include('helpers.footer')

@endsection('body')

