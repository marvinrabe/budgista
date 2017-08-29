@extends('layouts.budget')

@section('content')
    <div class="card panel-default">
        <div class="card-header">{{ __('Edit Category') }}</div>

        <div class="card-body">
            @include('helpers.errors')

            {{ Form::model($category, ['route' => ['categories.update', $budget->id, $category->id], 'method' => 'PUT', 'id' => 'form']) }}

            <div class="form-group">
                {{ Form::label('name', __('Name')) }}
                {{ Form::text('name', null, ['class' => 'form-control', 'autofocus', 'autocomplete' => 'off']) }}
            </div>

            {{ Form::close() }}

            <div class="row">
                <div class="col">
                    <button form="form" class="btn btn-primary">{{ __('Edit Category') }}</button>
                </div>
                <div class="col text-right">
                    <div class="d-inline">
                        {{ Form::open(['route' => ['categories.destroy', $budget->id, $category->id], 'class' => 'pull-right']) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit(__('Delete Category'), array('class' => 'btn btn-outline-danger btn-delete')) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
