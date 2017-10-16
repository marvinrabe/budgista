@extends('layouts.base',  ['body_class' => 'layout-budget'])

@section('body')

    <app-layout :budget-id="{{ $budget->id }}"></app-layout>

@endsection