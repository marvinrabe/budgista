@extends('layouts.base', ['body_class' => 'layout-general'])

@section('body')
    <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand logo" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar"
                    aria-controls="mainNavbar" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mr-auto">

                </ul>
                <ul class="navbar-nav">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @else
                        @include('auth.menu')
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @include('helpers.successes')

        @yield('content')
    </div>

@endsection('body')
