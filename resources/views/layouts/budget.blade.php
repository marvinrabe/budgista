@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-3 col-xl-3">
                <nav class="nav flex-column">
                    <a href="#" class="nav-header h6 dropdown-toggle" id="chooseBudgets" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $budget->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="chooseBudgets">
                        <h6 class="dropdown-header">Budgets</h6>
                        @foreach (Auth::user()->budgets as $otherBudget)
                            @if ($otherBudget->id != $budget->id)
                                <a class="dropdown-item" href="{{ route('budgets.show', ['id' => $otherBudget->id])  }}">
                                    {{ $otherBudget->name }}
                                </a>
                            @else
                                <a class="dropdown-item disabled" href="#">{{ $otherBudget->name }}</a>
                            @endif
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('budgets.index') }}"><span class="fa fa-cog"></span> Manage
                            Budgets</a>
                    </div>
                    <a class="nav-link" href="{{ route('sheet', [$budget->id]) }}">
                        <span class="fa fa-envelope-o fa-fw"></span> Budget
                    </a>
                    <h6 class="nav-header">Accounts</h6>
                    @foreach ($budget->accounts as $account)
                        <a class="nav-link" href="{{ route('accounts.show', [$budget->id, $account->id]) }}">
                            <span class="float-right badge @if($account->workingBalance() < 0) badge-danger @else badge-success @endif">
                                {{ format_currency($account->workingBalance(), $budget) }}
                            </span>
                            {{ $account->name }}
                        </a>
                    @endforeach
                    <a class="nav-link text-muted small text-right" href="{{ route('accounts.create', [$budget->id]) }}">
                        <span  class="fa fa-plus"></span> Add Account
                    </a>
                </nav>
            </div>
            <div class="col">
                @yield('content')
            </div>
        </div>

    </div>
@overwrite