@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="dropdown float-right">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $budget->name }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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
                <a class="dropdown-item" href="{{ route('budgets.index') }}"><span class="fa fa-cog"></span> Manage Budgets</a>
            </div>
        </div>

        <nav class="nav nav-pills">
            <a class="nav-link active" href="#">Budget</a>
            <a class="nav-link" href="#">Longer nav link</a>
            <a class="nav-link" href="#">Link</a>
            <a class="nav-link text-muted" href="#">+ Add Account</a>
        </nav>

        <hr>

        @yield('content')

    </div>
@overwrite