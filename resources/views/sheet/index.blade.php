@extends('layouts.budget')

@section('content')

    <budget-monthly-view budget="{{ $budget->id }}"></budget-monthly-view>

@endsection
