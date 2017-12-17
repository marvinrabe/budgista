@extends('layouts.general')

@section('content')

    <section class="main padder">
        <div class="error">
            <span class="fa fa-lock fa-5x"></span>
            <h1>{{ __('Access denied') }}</h1>
            <p>{{ __('You don\'t have permissions to access this site. Please contact the administrator.') }}</p>
        </div>
    </section>

@endsection

@section('stylesheets')
    <script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>
@endsection
