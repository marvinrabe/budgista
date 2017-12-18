@extends('layouts.general', ['no_translations' => true])

@section('content')

    <section class="main padder">
        <div class="error">
            <span class="{{ $icon }} fa-5x"></span>
            <h1>{{ $title }}</h1>
            <p>{{ $body }}</p>
        </div>
    </section>

@endsection