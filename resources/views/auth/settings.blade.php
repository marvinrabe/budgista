@extends('layouts.general')

@section('content')

    <div class="card panel-default">
        <div class="card-header">{{ __('Account Settings') }}</div>

        <div class="card-body">
            @include('helpers.errors')

            {{ Form::model($user, ['route' => ['settings.store'], 'method' => 'PUT']) }}

            <div class="form-group">
                {{ Form::label('name', __('Name')) }}
                {{ Form::text('name', null, ['class' => 'form-control', 'autofocus']) }}
            </div>

            <div class="form-group">
                {{ Form::label('email', __('E-Mail Address')) }}
                {{ Form::email('email', null, ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
                {{ Form::label('password', 'New Password') }}
                {{ Form::password('password', ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
                {{ Form::label('password', 'Confirm New Password') }}
                {{ Form::password('password_confirmation',['class' => 'form-control']) }}
            </div>

            <div class="form-group">
                {{ Form::label('locale', __('Locale')) }}
                {{ Form::select('locale', Language::all(), null, ['class' => 'form-control']) }}
            </div>

            <button class="btn btn-primary">{{ __('Save') }}</button>

            {{ Form::close() }}

        </div>
    </div>

@endsection
