@extends('layouts.base', ['body_class' => 'layout-general'])

@section('body')
    <nav class="navbar navbar-expand-md navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('/images/logo.svg') }}" alt="{{ config('app.name') }}" height="30">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    @if (Auth::guest())
                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('home') }}">{{ trans('title.home') }}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('register') }}">{{ trans('title.register') }}</a></li>
                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('login') }}">{{ trans('title.login') }}</a>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('app') }}">{{ trans('message.return_to_app') }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="mt-4">
        @yield('content')
    </div>

    @include('snippets.footer')
@endsection('body')