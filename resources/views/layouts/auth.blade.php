@extends('layouts.base')

@section('card')
    <div class="card">
        <div class="card-body">
            @yield('content')
        </div>
    </div>
@endsection

@section('body')
    <div class="container text-center my-4">
        <div class="mb-4">
            <a href="{{ route('login') }}">
                <img src="{{ asset('/images/logo.svg') }}" alt="{{ config('app.name') }}" height="48">
            </a>
        </div>

        <div class="row justify-content-md-center text-left">
            <div class="col-sm-12 col-md-6 col-lg-5 center">
                @yield('card')
            </div>
        </div>
    </div>
@endsection