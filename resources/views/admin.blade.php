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
            <th>{{ trans('form.name') }}</th>
            <th>{{ trans('form.created_at') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $users->links() }}

@endsection
