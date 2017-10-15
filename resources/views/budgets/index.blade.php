@extends('layouts.general')

@section('content')

    <p class="display-4">{{ __('My Budgets') }}</p>
    <p class="lead">Manage your Budgets.</p>

    <div class="row">
        @foreach ($budgets as $budget)
            <div class="col-sm-6 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $budget->name }}</h4>
                        <p class="card-text">
                            <small class="text-muted">{{ __('Last used :diff', ['diff' => $budget->updated_at->diffForHumans()]) }}</small>
                        </p>
                        <div class="btn-group">
                            <a class="btn btn-primary" href="{{ route('budgets.show', ['id' => $budget->id])  }}">
                                {{ __('Open Budget') }}
                            </a>
                            <a class="btn btn-light" href="{{  route('budgets.edit', ['id' => $budget->id]) }}"
                               title="{{ __('Budget Settings') }}">
                                <span class="fa fa-cog"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
