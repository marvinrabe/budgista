@extends('layouts.budget')

@section('content')
    <div class="card panel-default">
        <div class="card-header">{{ __('Account Settings') }}</div>

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

            {{ Form::model($account, ['route' => ['accounts.update', $budget->id, $account->id], 'method' => 'PUT', 'id' => 'form']) }}

            <div class="form-group">
                {{ Form::label('name', __('Name')) }}
                {{ Form::text('name', null, ['class' => 'form-control']) }}
            </div>

            {{ Form::close() }}

            <div class="row">
                <div class="col">
                    <button form="form" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
                <div class="col text-right">
                    <div class="d-inline">
                        {{ Form::open(['route' => ['accounts.destroy', $budget->id, $account->id], 'class' => 'pull-right']) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit(__('Delete Account'), array('class' => 'btn btn-outline-danger btn-delete')) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
