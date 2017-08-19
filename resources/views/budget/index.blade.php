@extends('layouts.app')

@section('content')
    <div class="container">

        <a class="btn btn-primary float-right my-4" href="{{ URL::to('budget/create') }}">New Budget</a>
        <p class="display-4">Your Budgets</p>

        <p class="lead">Manage your Budgets.</p>


        <div class="card-deck">
            @foreach ($budgets as $budget)
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $budget->name }}</h4>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    <a class="btn btn-primary" href="{{ URL::to('budget/' . $budget->id . '/edit') }}">Open Budget</a>
                    <a class="btn btn-light" href="{{ URL::to('budget/' . $budget->id . '/edit') }}" title="Edit Budget">
                        <span class="fa fa-pencil"></span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
