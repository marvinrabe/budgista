@extends('layouts.base')

@section('body')

    <section class="main padder">
        <div class="error">
            <span class="{{ $icon }} fa-5x"></span>
            <h1>{{ $title }}</h1>
            <p>{{ $body }}</p>
            <a class="btn btn-dark" href="{{ route('app') }}">
                {{ trans('message.return_to_app') }}
            </a>
        </div>
    </section>

@endsection