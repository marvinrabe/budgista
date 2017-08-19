@extends('layouts.budget')

@section('content')

    <div class="float-right my-4">
        To be Budgeted: <strong>0€</strong>
        &middot; Previous Month: <strong>0€</strong>
        &middot; Funds: <strong>0€</strong>
        &middot; Budgeted: <strong>0€</strong>
    </div>

    <p class="display-4">
        <a href="{{ route('sheet', [$budget->id, (string) $month->previous()]) }}">&laquo;</a>
        {{ $month }}
        <a href="{{ route('sheet', [$budget->id, (string) $month->next()]) }}">&raquo;</a>
    </p>

    <table class="table">
        <thead>
        <tr>
            <th>Category</th>
            <th>Previous Month</th>
            <th>Budgeted</th>
            <th>Activity</th>
            <th>Available</th>
        </tr>
        </thead>
    </table>

@endsection
