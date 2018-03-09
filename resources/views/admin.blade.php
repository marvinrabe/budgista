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
            <th class="text-center">Active</th>
            <th>{{ trans('form.email') }}</th>
            <th>Language</th>
            <th>Currency</th>
            <th>Accounts</th>
            <th>Categories</th>
            <th>Transactions</th>
            <th>Joined</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td class="text-center">
                    <span class="fa fa-circle {{ $user->isActive()?'text-success':'text-danger' }}"></span>
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    {{ Language::all()[$user->locale] }}<br>
                    <small>{{ Language::all()[$user->language] }}</small>
                </td>
                <td>{{ Currency::all()[$user->currency] }}</td>
                <td>{{ $user->accounts()->count() }}</td>
                <td>{{ $user->categories()->count() }}</td>
                <td>{{ $user->transactions()->count() }}</td>
                <td>{{ $user->created_at->format('d.m.Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $users->links() }}

@endsection
