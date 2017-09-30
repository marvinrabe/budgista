@extends('layouts.base',  ['body_class' => 'layout-budget'])

@section('body')

    <router-view>
        @include('auth.menu')
    </router-view>

@endsection