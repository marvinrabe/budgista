@extends('layouts.budget')

@section('content')
    <div class="card panel-default">
        <div class="card-header">Create Transaction</div>

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

            {{ Form::open(['route' => ['transactions.store', $budget->id, $account->id]]) }}

            <div class="form-group">
                {{ Form::label('date', 'Date') }}
                {{ Form::date('date', Input::old('date'), array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('payee', 'Payee') }}
                {{ Form::text('payee', Input::old('payee'), array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('category_id', 'Category') }}
                {{ Form::select('category_id', $categories, Input::old('category_id'), ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
                {{ Form::label('memo', 'Memo') }}
                {{ Form::text('memo', Input::old('memo'), array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('amount', 'Amount') }}
                {{ Form::number('amount', Input::old('amount'), array('class' => 'form-control')) }}
            </div>

            {{ Form::submit('Create Transaction', array('class' => 'btn btn-primary')) }}

            {{ Form::close() }}
        </div>
    </div>
@endsection
