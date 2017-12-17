@extends('layouts.general')

@section('content')

    <section class="main padder">
        <div class="error">
            <span class="fa fa-question-circle fa-5x"></span>
            <h1>{{ __('Not Found') }}</h1>
            <p>{{ __('The requested page could not be found.') }}</p>
        </div>
    </section>

@endsection

@section('stylesheets')
    <script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>
@endsection
