@extends('layouts.auth')

@section('title')
    {{ trans('title.login') }} - {{ config('app.name') }}
@overwrite

@section('card')
    <div class="card">
        <div class="card-body">

            <h1 class="card-title">{{ trans('title.login') }}</h1>

            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="email" class="control-label">{{ trans('form.email') }}</label>

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
                    <label for="password" class="control-label">{{ trans('form.password') }}</label>

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
                            {{ trans('form.remember') }}
                        </label>
                    </div>
                </div>

                <button class="btn btn-primary btn-block">
                    {{ trans('action.login') }}
                </button>
            </form>

        </div>

        <div class="card-body card-body-secondary text-center">

            {{ trans('message.no_account') }}
            <a href="{{ route('register') }}">
                {{ trans('message.no_account_sign_up') }}
            </a>

        </div>
    </div>

    <p class="text-center mt-3">
        <a class="text-muted" href="{{ route('password.request') }}">
            {{ trans('message.forgot_password') }}
        </a>
    </p>

@endsection
