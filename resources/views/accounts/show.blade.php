@extends('layouts.budget')

@section('content')


    <div class="float-right my-3 ml-4 btn-group">
        <a class="btn btn-light" href="{{ route('accounts.edit', [$budget->id, $account->id]) }}" title="Edit Account">
            <span class="fa fa-pencil"></span>
        </a>
        <a class="btn btn-primary" href="{{ route('transactions.create', [$budget->id, 'account' => $account->id]) }}">
            <span class="fa fa-plus"></span> Create Transaction
        </a>
    </div>

    <div class="float-right my-4">
        Cleared Balance: <strong class=" @if($account->clearedBalance() < 0) text-danger @else text-success @endif ">{{ $account->clearedBalance() }}</strong>
        + Uncleared Balance: <strong class=" @if($account->unclearedBalance() < 0) text-danger @else text-success @endif ">{{ $account->unclearedBalance() }}</strong>
        = Working Balance: <strong class=" @if($account->workingBalance() < 0) text-danger @else text-success @endif ">{{ $account->workingBalance() }}</strong>
    </div>

    <p class="display-4">
        {{ $account->name }}
    </p>

    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>Date</th>
            <th>Payee</th>
            <th>Category</th>
            <th>Memo</th>
            <th>Outflow</th>
            <th>Inflow</th>
            <th></th>
        </tr>
        </thead>
        @forelse ($account->transactions()->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get() as $transaction)
            <tr>
                <td width="32">
                    {{ Form::open(['route' => ['transactions.clear', $budget->id, $transaction->id]]) }}
                    {{ Form::hidden('_method', 'PUT') }}
                    <button class="btn btn-sm
                    @if ($transaction->cleared)
                    btn-success
                    @else
                    btn-light
                    @endif
                    ">
                        <span class="fa fa-check"></span>
                    </button>
                    {{ Form::close() }}
                </td>
                <td>{{ $transaction->date }}</td>
                <td>{{ $transaction->payee }}</td>
                <td>
                    @if($transaction->category === null)
                        Income
                    @else
                        {{ $transaction->category->name }}
                    @endif
                </td>
                <td>{{ $transaction->memo }}</td>
                <td class="text-danger">
                    @if ( $transaction->amount < 0)
                    {{ $transaction->amount }}
                    @endif
                </td>
                <td class="text-success">
                    @if ( $transaction->amount >= 0)
                    +{{ $transaction->amount }}
                    @endif
                </td>
                <td>
                    <a href="{{ route('transactions.edit', [$budget->id, $transaction->id]) }}" title="Edit Transaction" class="text-muted">
                        <span class="fa fa-pencil"></span>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-muted text-center">
                    No transactions available.
                </td>
            </tr>
        @endforelse
    </table>
@endsection
