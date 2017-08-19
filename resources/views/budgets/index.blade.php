@extends('layouts.app')

@section('content')
    <div class="container">

        <a class="btn btn-primary float-right my-4" href="{{ route('budgets.create') }}">New Budget</a>
        <p class="display-4">Your Budgets</p>
        <p class="lead">Manage your Budgets.</p>

        <div class="row">
            @foreach ($budgets as $budget)
                <div class="col-sm-6 col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $budget->name }}</h4>
                            <p class="card-text">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </p>
                            <a class="btn btn-primary" href="{{ route('budgets.show', ['id' => $budget->id])  }}">
                                Open Budget
                            </a>
                            <a class="btn btn-light" href="{{  route('budgets.edit', ['id' => $budget->id]) }}"
                               title="Edit Budget">
                                <span class="fa fa-pencil"></span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
