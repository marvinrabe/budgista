@extends('layouts.auth')

@section('content')

    <h4 class="card-title">{{ __('Reset Password') }}</h4>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.request') }}" class="{{ $errors->any()?'was-validated':'' }}">
        {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email" class="control-label">{{ __('E-Mail Address') }}</label>

            <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'border-danger' : '' }}" name="email"
                   value="{{ $email or old('email') }}" required autofocus>

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

            <input id="password-confirm" type="password" class="form-control {{ $errors->has('password_confirmation') ? 'border-danger' : '' }}"
                   name="password_confirmation" required>

            @if ($errors->has('password_confirmation'))
                <div class="form-text text-danger">
                    {{ $errors->first('password_confirmation') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <button class="btn btn-primary">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>

@endsection
