@extends('layouts.budget')

@section('content')
    <div class="card panel-default">
        <div class="card-header">{{ __('Edit Transaction') }}</div>

        <div class="card-body">
            @include('helpers.errors')

            {{ Form::model($transaction, ['route' => ['transactions.update', $budget->id, $transaction->id], 'method' => 'PUT', 'id' => 'form']) }}

                <div class="form-group">
                    {{ Form::label('account_id', __('Account')) }}
                    {{ Form::select('account_id', $accounts, null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('date', __('Date')) }}
                    {{ Form::date('date', $transaction->date, array('class' => 'form-control')) }}
                </div>

                <recurrence rule="{{ $transaction->rrule }}"></recurrence>

                <div class="form-group">
                    {{ Form::label('payee', __('Payee')) }}
                    {{ Form::text('payee', null, array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('category_id', __('Category')) }}
                    {{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('memo', __('Memo')) }}
                    {{ Form::text('memo', null, array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('amount', __('Amount')) }}
                    {{ Form::number('amount', null, array('class' => 'form-control', 'step' => '0.01')) }}
                </div>

            {{ Form::close() }}

            <div class="row">
                <div class="col">
                    <button form="form" class="btn btn-primary">{{ __('Edit Transaction') }}</button>
                </div>
                <div class="col text-right">
                    <div class="d-inline">
                        {{ Form::open(['route' => ['transactions.destroy', $budget->id, $transaction->id], 'class' => 'pull-right']) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit(__('Delete Transaction'), array('class' => 'btn btn-outline-danger btn-delete')) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
