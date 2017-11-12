@extends('layouts.general')

@section('title')
    {{ config('app.name') }} - {{ trans('title.legal') }}
@endsection('title')

@section('content')

    <div class="text-center">
        <h1>{{ trans('title.legal') }}</h1>

        <p>{{ __('Information in accordance with section 5 TMG:') }}</p>

        <p>
            Marvin Rabe<br>
            Henricistr. 1c<br>
            45136 Essen<br>
            {{ __('Germany') }}
        </p>

        <h2>{{ __('Contact') }}</h2>

        <p>
            E-Mail: <a href="mailto:support@budgista.com">support@budgista.com</a><br>
            Telephone: +49 1525 47 555 29
        </p>
    </div>

@endsection('body')
