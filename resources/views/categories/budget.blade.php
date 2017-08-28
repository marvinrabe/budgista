@extends('layouts.budget')

@section('content')
    <div class="card panel-default">
        <div class="card-header">{{ __('Budget') }}</div>

        <div class="card-body">
            @include('helpers.errors')

            {{ Form::model($categoryBudget, ['route' => ['categories.storeBudget', $budget->id, $category->id, $month], 'method' => 'PUT', 'id' => 'form']) }}

            <div class="form-group">
                {{ Form::label('amount', __('Amount')) }}
                {{ Form::number('amount', null, ['class' => 'form-control', 'step' => '0.01']) }}
            </div>

            {{ Form::submit(__('Budget'), array('class' => 'btn btn-primary')) }}

            {{ Form::close() }}

        </div>
    </div>
@endsection
