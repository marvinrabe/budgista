@extends('layouts.general')

@section('content')

    <div class="container">
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

                {{ Form::model($user, ['route' => ['settings.store'], 'method' => 'PUT']) }}

                <div class="form-group">
                    {{ Form::label('locale', __('Locale')) }}
                    {{ Form::select('locale', Language::all(), null, ['class' => 'form-control']) }}
                </div>

                <button class="btn btn-primary">{{ __('Save') }}</button>

                {{ Form::close() }}

            </div>
        </div>
    </div>

@endsection
