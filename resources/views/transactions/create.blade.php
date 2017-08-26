@extends('layouts.budget')

@section('content')
    <div class="card panel-default">
        <div class="card-header">{{ __('Create Transaction') }}</div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ Form::open(['route' => ['transactions.store', $budget->id]]) }}

            <div class="form-group">
                {{ Form::label('account_id', __('Account')) }}
                {{ Form::select('account_id', $accounts, Input::old('account_id', Request::query('account')), ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
                {{ Form::label('date', __('Date')) }}
                {{ Form::date('date', Input::old('date', new \DateTime), array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('payee', __('Payee')) }}
                {{ Form::text('payee', Input::old('payee'), array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('category_id', __('Category')) }}
                {{ Form::select('category_id', $categories, Input::old('category_id'), ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
                {{ Form::label('memo', __('Memo')) }}
                {{ Form::text('memo', Input::old('memo'), array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('amount', __('Amount')) }}
                {{ Form::number('amount', Input::old('amount'), array('class' => 'form-control')) }}
            </div>

            {{ Form::submit(__('Create Transaction'), array('class' => 'btn btn-primary')) }}

            {{ Form::close() }}
        </div>
    </div>
@endsection
