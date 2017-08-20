@extends('layouts.budget')

@section('content')
    <div class="card panel-default">
        <div class="card-header">Edit Transaction</div>

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

            {{ Form::model($transaction, ['route' => ['transactions.update', $budget->id, $account->id, $transaction->id], 'method' => 'PUT', 'id' => 'form']) }}

                <div class="form-group">
                    {{ Form::label('date', 'Date') }}
                    {{ Form::date('date', null, array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('payee', 'Payee') }}
                    {{ Form::text('payee', null, array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('category_id', 'Category') }}
                    {{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('memo', 'Memo') }}
                    {{ Form::text('memo', null, array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('amount', 'Amount') }}
                    {{ Form::number('amount', null, array('class' => 'form-control')) }}
                </div>

            {{ Form::close() }}

            <div class="row">
                <div class="col">
                    <button form="form" class="btn btn-primary">Edit Transaction</button>
                </div>
                <div class="col text-right">
                    <div class="d-inline">
                        {{ Form::open(['route' => ['transactions.destroy', $budget->id, $account->id, $transaction->id], 'class' => 'pull-right']) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit('Delete Transaction', array('class' => 'btn btn-outline-danger')) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
