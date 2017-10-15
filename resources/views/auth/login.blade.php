@extends('layouts.auth')

@section('card')
    <div class="card border-light">
        <div class="card-body">

            <h1 class="card-title">{{ __('Login') }}</h1>

            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="email" class="control-label">{{ __('E-Mail Address') }}</label>

                    <input id="email" type="email"
                           class="form-control {{ $errors->has('email') ? 'border-danger' : '' }}" name="email"
                           value="{{ old('email') }}" required
                           autofocus>

                    @if ($errors->has('email'))
                        <div class="form-text text-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password" class="control-label">{{ __('Password') }}</label>

                    <input id="password" type="password"
                           class="form-control {{ $errors->has('password') ? 'border-danger' : '' }}" name="password"
                           required>

                    @if ($errors->has('password'))
                        <div class="form-text text-danger">
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

                <button class="btn btn-primary btn-block">
                    {{ __('Login') }}
                </button>
            </form>

        </div>

        <div class="card-body card-body-secondary text-center">

            {{ __('Don\'t have an account?') }}
            <a href="{{ route('register') }}">
                {{ __('Sign up now.') }}
            </a>

        </div>
    </div>

    <p class="text-center mt-3">
        <a class="text-white" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }}
        </a>
    </p>

@endsection
