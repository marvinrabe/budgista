@extends('layouts.base',  ['body_class' => 'layout-budget'])

@section('body')

    <div class="menu">
        <div class="app-menu">

            <nav class="navbar navbar-expand navbar-light" style="width: 100%;">
                <a class="navbar-brand logo" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>

                <ul class="navbar-nav ml-auto">
                    @include('auth.menu')
                    <li class="nav-item d-md-none">
                        <a href="#" class="menu-toggle nav-link">
                            <span class="fa fa-times"></span>
                        </a>
                    </li>
                </ul>
            </nav>

            <nav class="nav flex-column">
                <router-link :to="{ name: 'budget', params: { budget: '{{ $budget->id }}' }}" active-class="active"
                             class="nav-link-main">
                    <span class="fa fa-envelope-o fa-fw"></span> {{ __('Budget') }}
                </router-link>
                <h6 class="nav-header">Accounts</h6>
                @foreach ($budget->accounts as $menuAccount)
                    <router-link :to="{ name: 'account', params: { account_id: '{{ $menuAccount->id }}' }}"
                                 active-class="active" class="nav-link-main">
                        <span class="float-right mt-1 badge @if($menuAccount->workingBalance() < 0) badge-danger @else badge-success @endif">
                            {{ Currency::format($menuAccount->workingBalance(), $budget->currency) }}
                        </span>
                        {{ $menuAccount->name }}
                    </router-link>
                @endforeach
                <a class="nav-link text-muted small text-right" href="">
                    <span class="fa fa-plus"></span> {{ __('Add Account') }}
                </a>
            </nav>

        </div>
    </div>
    <transition name="fade" mode="out-in">
        <keep-alive>
            <router-view></router-view>
        </keep-alive>
    </transition>
@endsection