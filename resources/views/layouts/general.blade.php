@extends('layouts.base', ['body_class' => 'layout-general'])

@section('body')
    <nav class="navbar navbar-expand navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand logo" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>

            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('Sign up') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">{{ __('Go back to App') }}</a></li>
                @endif
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @include('helpers.successes')

        @yield('content')
    </div>

@endsection('body')
