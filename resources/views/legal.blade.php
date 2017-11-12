@extends('layouts.general')

@section('title')
    {{ trans('title.legal') }} - {{ config('app.name') }}
@overwrite

@section('content')

    <div class="text-center">
        <h1>{{ trans('title.legal') }}</h1>

        <p>{{ trans('static.legal.tmg_notice') }}</p>

        <p>
            Marvin Rabe<br>
            Henricistr. 1c<br>
            45136 Essen<br>
            {{ trans('static.legal.germany') }}
        </p>

        <h2>{{ trans('static.legal.contact') }}</h2>

        <p>
            {{ trans('static.legal.email') }}: <a href="mailto:support@budgista.com">support@budgista.com</a><br>
            {{ trans('static.legal.telephone') }}: +49 1525 47 555 29
        </p>
    </div>

@endsection('body')
