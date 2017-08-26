@extends('layouts.general')

@section('content')

    <div class="container">

        <section class="main padder">
            <div class="error">
                <span class="fa fa-question-circle fa-5x"></span>
                <h1>{{ __('Not Found') }}</h1>
                <p>{{ __('The requested page could not be found.') }}</p>
            </div>
        </section>

    </div>

@endsection
