@extends('layouts.auth')

@section('content')

    <h4 class="card-title">{{ __('Login') }}</h4>

    <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="form-group {{ $errors->has('email') ? 'is-invald' : '' }}">
            <label for="email" class="control-label">{{ __('E-Mail Address') }}</label>

            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required
                   autofocus>

            @if ($errors->has('email'))
                <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <div class="form-group {{ $errors->has('password') ? 'is-invald' : '' }}">
            <label for="password" class="control-label">{{ __('Password') }}</label>

            <input id="password" type="password" class="form-control" name="password" required>

            @if ($errors->has('password'))
                <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    {{ __('Remember Me') }}
                </label>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-primary">
                {{ __('Login') }}
            </button>

            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        </div>
    </form>

    <hr>

    {{ __('Don\'t have an account?') }}
    <a href="{{ route('register') }}">
        {{ __('Sign up now.') }}
    </a>
@endsection
