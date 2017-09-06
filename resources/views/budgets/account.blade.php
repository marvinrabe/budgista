@extends('layouts.budget')

@section('content')

    <budget-account-view account_id="{{ $account->id }}"></budget-account-view>

@endsection
