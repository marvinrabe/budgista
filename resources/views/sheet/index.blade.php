@extends('layouts.budget')

@section('content')

    <budget-monthly-view :sheet="{{ json_encode($sheet) }}"></budget-monthly-view>

@endsection
