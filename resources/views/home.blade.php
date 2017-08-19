@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card panel-default">
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                <strong>Budgets:</strong>
                <ul>
                @foreach (Auth::user()->budgets as $budget)
                    <li>{{ $budget->name }}</li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
