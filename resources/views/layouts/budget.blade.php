@extends('layouts.base',  ['body_class' => 'layout-budget'])

@section('body')
    <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
        <div class="container">

            <a class="navbar-brand logo" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>

            <button class="menu-open btn btn-outline-light float-left d-md-none" type="button"
                    aria-controls="menu" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <ul class="navbar-nav float-right d-none d-md-block">
                @include('auth.menu')
            </ul>
        </div>
    </nav>

    <div class="container px-0 px-lg-2 pb-2 py-lg-2">

        <div class="form-row">
            <div class="col-md-4 col-lg-3">
                <div class="menu">
                    <div class="app-menu">

                        <nav class="navbar navbar-dark bg-primary mb-3 d-md-none">
                            <a class="navbar-brand logo logo-white" href="{{ url('/') }}">
                                {{ config('app.name') }}
                            </a>
                            <div class="navbar-nav mr-auto"></div>
                            <button class="menu-close btn btn-primary" type="button">
                                <span class="fa fa-times 2x"></span>
                            </button>
                        </nav>

                        <nav class="nav flex-column">
                            <a href="#" class="nav-header h6 dropdown-toggle" id="chooseBudgets" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                {{ $budget->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="chooseBudgets">
                                <h6 class="dropdown-header">{{ __('Budgets') }}</h6>
                                @foreach (Auth::user()->budgets as $otherBudget)
                                    @if ($otherBudget->id != $budget->id)
                                        <a class="dropdown-item"
                                           href="{{ route('budgets.show', ['id' => $otherBudget->id])  }}">
                                            {{ $otherBudget->name }}
                                        </a>
                                    @else
                                        <a class="dropdown-item disabled" href="#">{{ $otherBudget->name }}</a>
                                    @endif
                                @endforeach
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('budgets.index') }}">
                                    <span class="fa fa-cog"></span>
                                    {{ __('Manage Budgets') }}
                                </a>
                            </div>
                            <a class="nav-link" href="{{ route('budgets.show', [$budget->id]) }}">
                                <span class="fa fa-envelope-o fa-fw"></span> Budget
                            </a>
                            <h6 class="nav-header">Accounts</h6>
                            @foreach ($budget->accounts as $account)
                                <a class="nav-link" href="{{ route('accounts.show', [$budget->id, $account->id]) }}">
                            <span class="float-right badge @if($account->workingBalance() < 0) badge-danger @else badge-success @endif">
                                {{ Currency::format($account->workingBalance(), $budget->currency) }}
                            </span>
                                    {{ $account->name }}
                                </a>
                            @endforeach
                            <a class="nav-link text-muted small text-right"
                               href="{{ route('accounts.create', [$budget->id]) }}">
                                <span class="fa fa-plus"></span> {{ __('Add Account') }}
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col">

                @include('helpers.successes')

                @yield('content')

            </div>
        </div>

    </div>
@endsection