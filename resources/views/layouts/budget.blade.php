@extends('layouts.app')

@section('content')
    <div class="container">

        <nav class="nav nav-pills">
            <a class="nav-link active" href="#">Budget</a>
            <a class="nav-link" href="#">Longer nav link</a>
            <a class="nav-link" href="#">Link</a>
            <a class="nav-link text-muted" href="#">+ Add Account</a>
        </nav>

        <hr>

        @yield('content')

    </div>
@overwrite