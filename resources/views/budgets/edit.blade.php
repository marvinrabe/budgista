@extends('layouts.general')

@section('content')

    <div class="card panel-default">
        <div class="card-header">{{ __('Budget Settings') }}</div>

        <div class="card-body">
            @include('helpers.errors')

            {{ Form::model($budget, ['route' => ['budgets.update', $budget->id], 'method' => 'PUT', 'id' => 'form']) }}

            <div class="form-group">
                {{ Form::label('name', __('Name')) }}
                {{ Form::text('name', null, ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
                {{ Form::label('currency', __('Currency')) }}
                {{ Form::select('currency', Currency::all(), null, ['class' => 'form-control']) }}
            </div>

            {{ Form::close() }}

            <div class="row">
                <div class="col">
                    <button form="form" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
                <div class="col text-right">
                    <div class="d-inline">
                        {{ Form::open(['route' => ['budgets.destroy', $budget->id], 'class' => 'pull-right']) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit(__('Delete Budget'), array('class' => 'btn btn-outline-danger btn-delete')) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
