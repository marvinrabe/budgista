@extends('layouts.app')

@section('content')
    <div class="container">

        <p class="display-4">{{ $budget->name  }}</p>
        <p class="lead">{{ $month  }}</p>

    </div>
@endsection
