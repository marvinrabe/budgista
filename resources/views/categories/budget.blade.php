@extends('layouts.budget')

@section('content')
    <div class="card panel-default">
        <div class="card-header">{{ __('Budget') }}</div>

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

            {{ Form::model($categoryBudget, ['route' => ['categories.storeBudget', $budget->id, $category->id, $month], 'method' => 'PUT', 'id' => 'form']) }}

            <div class="form-group">
                {{ Form::label('amount', __('Amount')) }}
                {{ Form::text('amount', null, ['class' => 'form-control']) }}
            </div>

            {{ Form::submit(__('Budget'), array('class' => 'btn btn-primary')) }}

            {{ Form::close() }}

        </div>
    </div>
@endsection
