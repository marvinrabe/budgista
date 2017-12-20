@extends('layouts.auth')

@section('title')
    {{ trans('title.reset') }} - {{ config('app.name') }}
@overwrite

@section('content')

    <h1 class="card-title h4">{{ trans('title.reset') }}</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="{{ $errors->any()?'was-validated':'' }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="email" class="control-label">{{ trans('form.email') }}</label>

            <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'border-danger' : '' }}" name="email" value="{{ old('email') }}"
                   required>

            @if ($errors->has('email'))
                <div class="form-text text-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary btn-block">
            {{ trans('action.send_reset') }}
        </button>

    </form>
@endsection
