@extends('layouts.base', ['body_class' => 'layout-general', 'style' => 'css/website.css'])

@section('body')
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand logo logo-white" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>

            <ul class="navbar-nav ml-auto">
                @if (Auth::guest())
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('Sign up') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('app') }}">{{ __('Go back to App') }}</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    @include('helpers.footer')
@endsection('body')
