@extends('layouts.budget')

@section('content')


    <div class="float-right my-3 ml-4 btn-group">
        <a class="btn btn-light" href="{{ route('accounts.edit', [$budget->id, $account->id]) }}" title="Edit Account">
            <span class="fa fa-pencil"></span>
        </a>
    </div>

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
