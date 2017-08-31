@extends('layouts.auth')

@section('content')

    <h4 class="card-title">{{ __('Reset Password') }}</h4>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}" class="{{ $errors->any()?'was-validated':'' }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="email" class="control-label">{{ __('E-Mail Address') }}</label>

            <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'border-danger' : '' }}" name="email" value="{{ old('email') }}"
                   required>

            @if ($errors->has('email'))
                <div class="form-text text-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                {{ __('Send Password Reset Link') }}
            </button>
        </div>
    </form>
@endsection
