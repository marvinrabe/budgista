@extends('layouts.base', ['body_class' => 'layout-auth', 'style' => 'css/app.css'])

@section('card')
    <div class="card">
        <div class="card-body">
            @yield('content')
        </div>
    </div>
@endsection

@section('body')

    <div class="cover">
        <div class="container text-center">
            <a href="{{ url('/') }}" class="h1 logo">
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

@endsection