@extends('layouts.auth')

@section('title')
    {{ trans('title.register') }} - {{ config('app.name') }}
@overwrite

@section('content')

    <h1 class="card-title h4">{{ trans('title.register') }}</h1>

    <form method="POST" action="{{ route('register') }}" class="{{ $errors->any()?'was-validated':'' }}"
          onsubmit="gtag_report_conversion()" novalidate>
        {{ csrf_field() }}

        <div class="form-group">
            <label for="email" class="control-label">{{ trans('form.email') }}</label>

            <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'border-danger' : '' }}"
                   name="email" value="{{ old('email') }}" required>

            @if ($errors->has('email'))
                <div class="form-text text-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="password" class="control-label">{{ trans('form.password') }}</label>

            <vue-password></vue-password>

            @if ($errors->has('password'))
                <div class="form-text text-danger">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>

        <button class="btn btn-primary btn-block">
            {{ trans('action.register') }}
        </button>
    </form>

@endsection
