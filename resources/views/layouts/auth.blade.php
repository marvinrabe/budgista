@extends('layouts.base', ['body_class' => 'layout-auth', 'style' => 'css/app.css'])

@section('card')
    <div class="card">
        <div class="card-body">
            @yield('content')
        </div>
    </div>
@endsection

@section('body')

    <div id="app">
        <div class="cover">
            <div class="container text-center">
                <a href="{{ route('home') }}" class="h2 logo">
                    {{ config('app.name') }}
                </a>
            </div>
        </div>

        <div class="container overlap">
            <div class="row justify-content-md-center">
                <div class="col-sm-12 col-md-6 col-lg-5 center">
                    @yield('card')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ mix('js/website.js') }}"></script>

@endsection