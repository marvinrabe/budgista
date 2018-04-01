@extends('layouts.auth')

@section('title')
    {{ trans('title.register') }} - {{ config('app.name') }}
@overwrite

@section('content')

    <h1 class="card-title h4">{{ trans('title.register') }}</h1>

    <form method="POST" action="{{ route('register') }}" novalidate>
        {{ csrf_field() }}

        <div class="form-group">
            <label for="email" class="control-label">{{ trans('form.email') }}</label>

            <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                   name="email" value="{{ old('email') }}" required>

            @if ($errors->has('email'))
                <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="password" class="control-label">{{ trans('form.password') }}</label>

            <app-password>
                <input id="password"
                       name="password"
                       class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                       slot-scope="{bindings, handlers}"
                       v-bind="bindings"
                       v-on="handlers"
                       required>
            </app-password>

            @if ($errors->has('password'))
                <div class="invalid-feedback d-inline-block">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox"
                       class="form-check-input {{ $errors->has('terms') ? 'is-invalid' : '' }}"
                       {{ (old('terms') == 1) ? 'checked' : '' }}
                       id="terms" name="terms" value="1">
                <label class="form-check-label" for="terms">
                    {!! Lang::get('form.termsOfService', ['url' => route('terms')]) !!}
                </label>

                @if ($errors->has('terms'))
                    <div class="invalid-feedback">
                        {{ $errors->first('terms') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-2">
            <button class="btn btn-primary btn-block">
                {{ trans('action.register') }}
            </button>
        </div>
    </form>

@endsection
