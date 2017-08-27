@extends('layouts.base', ['body_class' => 'layout-auth'])

@section('body')

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-sm-12 col-md-8 col-lg-6 col-lg-4 center">

                <div class="text-center h1 logo">
                    <img src="{{ asset('img/logo.svg') }}">
                    {{ config('app.name') }}
                </div>

                <div class="card border-light">
                    <div class="card-body">
                        @yield('content')
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection('body')
