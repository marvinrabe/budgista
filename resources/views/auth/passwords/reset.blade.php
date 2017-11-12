@extends('layouts.auth')

@section('title')
    {{ trans('title.reset') }} - {{ config('app.name') }}
@overwrite

@section('content')

    <h1 class="card-title">{{ trans('title.reset') }}</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.request') }}" class="{{ $errors->any()?'was-validated':'' }}">
        {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email" class="control-label">{{ trans('form.email') }}</label>

            <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'border-danger' : '' }}"
                   name="email"
                   value="{{ $email or old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <div class="form-text text-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="password" class="control-label">{{ trans('form.password_new') }}</label>

            <input id="password" type="password"
                   class="form-control {{ $errors->has('password') ? 'border-danger' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <div class="form-text text-danger">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="password-confirm" class="control-label">{{ trans('form.password_new_confirm') }}</label>

            <input id="password-confirm" type="password"
                   class="form-control {{ $errors->has('password_confirmation') ? 'border-danger' : '' }}"
                   name="password_confirmation" required>

            @if ($errors->has('password_confirmation'))
                <div class="form-text text-danger">
                    {{ $errors->first('password_confirmation') }}
                </div>
            @endif
        </div>

        <button class="btn btn-primary btn-block">
            {{ trans('action.reset') }}
        </button>

    </form>

@endsection
