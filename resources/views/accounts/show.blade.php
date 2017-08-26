@extends('layouts.budget')

@section('content')

    <div class="float-right my-3 ml-4 btn-group">
        <a class="btn btn-light" href="{{ route('accounts.edit', [$budget->id, $account->id]) }}" title="{{ __('Account Settings') }}">
            <span class="fa fa-cog"></span>
        </a>
        <a class="btn btn-primary" href="{{ route('transactions.create', [$budget->id, 'account' => $account->id]) }}">
            <span class="fa fa-plus"></span> {{ __('Create Transaction') }}
        </a>
    </div>

    <p class="display-4">
        {{ $account->name }}
    </p>

    <p>
        {{ __('Cleared Balance') }}: <strong class=" @if($account->clearedBalance() < 0) text-danger @else text-success @endif ">{{ Currency::format($account->clearedBalance(), $budget->currency) }}</strong>
        + {{ __('Uncleared Balance') }}: <strong class=" @if($account->unclearedBalance() < 0) text-danger @else text-success @endif ">{{ Currency::format($account->unclearedBalance(), $budget->currency) }}</strong>
        = {{ __('Working Balance') }}: <strong class=" @if($account->workingBalance() < 0) text-danger @else text-success @endif ">{{ Currency::format($account->workingBalance(), $budget->currency) }}</strong>
    </p>

    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>{{ __('Date') }}</th>
            <th>{{ __('Payee') }}</th>
            <th>{{ __('Category') }}</th>
            <th>{{ __('Memo') }}</th>
            <th>{{ __('Outflow') }}</th>
            <th>{{ __('Inflow') }}</th>
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
                <td>{{ DateIntl::date('medium', $transaction->date) }}</td>
                <td>{{ $transaction->payee }}</td>
                <td>
                    @if($transaction->category === null)
                        {{ __('To be Budgeted') }}
                    @else
                        {{ $transaction->category->name }}
                    @endif
                </td>
                <td>{{ $transaction->memo }}</td>
                <td class="text-danger">
                    @if ( $transaction->amount < 0)
                    - {{ Currency::format($transaction->amount*-1, $budget->currency) }}
                    @endif
                </td>
                <td class="text-success">
                    @if ( $transaction->amount >= 0)
                    + {{ Currency::format($transaction->amount, $budget->currency) }}
                    @endif
                </td>
                <td>
                    <a href="{{ route('transactions.edit', [$budget->id, $transaction->id]) }}" title="{{ __('Edit Transaction') }}" class="text-muted">
                        <span class="fa fa-pencil"></span>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-muted text-center">
                    {{ __('No transactions available.') }}
                </td>
            </tr>
        @endforelse
    </table>
@endsection
