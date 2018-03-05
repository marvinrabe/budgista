@extends('layouts.general')

@section('title')
    {{ trans('title.users') }} - {{ config('app.name') }}
@overwrite

@section('content')

    <p class="display-4">
        {{ trans('title.users') }}

        <span class="badge badge-success">
            {{ $users->total() }}
        </span>
    </p>

    <table class="table table-condensed">
        <thead>
        <tr>
            <th>{{ trans('form.email') }}</th>
            <th>{{ trans('form.created_at') }}</th>
            <th>{{ trans('form.language') }}</th>
            <th>{{ trans('form.locale') }}</th>
            <th>{{ trans('form.currency') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->language }}</td>
                <td>{{ $user->locale }}</td>
                <td>{{ $user->currency }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $users->links() }}

@endsection
