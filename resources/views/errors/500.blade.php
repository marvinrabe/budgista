@extends('layouts.general')

@section('content')

    <section class="main padder">
        <div class="error">
            <span class="fa fa-exclamation-triangle fa-5x"></span>
            <h1>{{ __('Unexpected Error') }}</h1>
            <p>{{ __('An unexpected Error has occurred. A report has been sent.') }}</p>
        </div>
    </section>

@endsection

@section('stylesheets')
    <script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>
@endsection
