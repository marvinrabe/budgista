@extends('layouts.budget')

@section('content')

    <div class="float-right my-4">
        Cleared Balance: <strong>0€</strong>
        + Uncleared Balance: <strong>0€</strong>
        = Working Balance: <strong>0€</strong>
    </div>

    <p class="display-4">
        {{ $account->name }}
    </p>

    <table class="table">
        <thead>
        <tr>
            <th>Date</th>
            <th>Payee</th>
            <th>Category</th>
            <th>Activity</th>
            <th>Amount</th>
        </tr>
        </thead>
    </table>
@endsection
