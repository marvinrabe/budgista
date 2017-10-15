@extends('layouts.auth')

@section('content')

    <h1 class="card-title">{{ __('Sign up') }}</h1>

    <form method="POST" action="{{ route('register') }}" class="{{ $errors->any()?'was-validated':'' }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name" class="control-label">{{ __('Name') }}</label>

            <input id="name" class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

            @if ($errors->has('name'))
                <div class="form-text text-danger">
                    {{ $errors->first('name') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="email" class="control-label">{{ __('E-Mail Address') }}</label>

            <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'border-danger' : '' }}" name="email" value="{{ old('email') }}" required>

            @if ($errors->has('email'))
                <div class="form-text text-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="password" class="control-label">{{ __('Password') }}</label>

            <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'border-danger' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <div class="form-text text-danger">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="password-confirm" class="control-label">{{ __('Confirm Password') }}</label>

            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
        </div>

        <button class="btn btn-primary btn-block">
            {{ __('Sign up') }}
        </button>
    </form>

@endsection
