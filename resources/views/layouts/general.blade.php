@extends('layouts.base', ['body_class' => 'layout-general', 'style' => 'css/website.css'])

@section('body')
    <nav class="navbar navbar-expand navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand logo" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>

            <ul class="navbar-nav ml-auto">
                @if (Auth::guest())
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">{{ trans('title.home') }}</a>
                    </li>
                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('register') }}">{{ trans('title.register') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ trans('title.login') }}</a>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('app') }}">{{ trans('message.return_to_app') }}</a>
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
