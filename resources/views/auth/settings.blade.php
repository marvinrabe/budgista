@extends('layouts.general')

@section('content')


    <p class="display-4">{{ __('Account Settings') }}</p>

    @include('helpers.errors')

    <form method="POST" action="{{ route('settings.store') }}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">{{ trans('Name') }}</label>
            <input name="name" value="{{ old('name', $user->name) }}" id="name" class="form-control" autofocus>
        </div>

        <div class="form-group">
            <label for="email">{{ trans('E-Mail Address') }}</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" id="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="password">{{ trans('New Password') }}</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="password_confirmation">{{ trans('Confirm New Password') }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <div class="form-group">
            <label for="locale">{{ trans('Locale') }}</label>
            <select id="locale" name="locale" class="form-control">
                @foreach(Language::all() as $key => $name)
                    <option value="{{ $key }}" {{ ($key == $user->locale)?'selected':'' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">{{ __('Save') }}</button>

    </form>

    <passport-authorized-clients></passport-authorized-clients>

    <passport-clients></passport-clients>

    <passport-personal-access-tokens></passport-personal-access-tokens>

@endsection
