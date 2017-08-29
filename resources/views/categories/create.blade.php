@extends('layouts.budget')

@section('content')
    <div class="card panel-default">
        <div class="card-header">{{ __('Add Category') }}</div>

        <div class="card-body">
            @include('helpers.errors')

            {{ Form::open(['route' => ['categories.store', $budget->id]]) }}

            <div class="form-group">
                {{ Form::label('name', __('Name')) }}
                {{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'autofocus', 'autocomplete' => 'off')) }}
            </div>

            {{ Form::submit(__('Add Category'), array('class' => 'btn btn-primary')) }}

            {{ Form::close() }}
        </div>
    </div>
@endsection
