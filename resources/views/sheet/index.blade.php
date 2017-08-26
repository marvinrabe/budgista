@extends('layouts.budget')

@section('content')

    <p class="display-4">
        <a href="{{ route('sheet', [$budget->id, (string) $month->previous()]) }}" title="{{ __('Previous Month') }}">&laquo;</a>
        {{ $month->forHumans() }}
        <a href="{{ route('sheet', [$budget->id, (string) $month->next()]) }}" title="{{ __('Next Month') }}">&raquo;</a>
    </p>

    <p>
        {{ __('To be Budgeted') }}: <strong>{{ Currency::format($sheet->getAvailable(), $budget->currency) }}</strong>
        &middot; {{ __('Previous Month') }}: <strong>{{ Currency::format($sheet->getPreviousMonthAvailable(), $budget->currency) }}</strong>
        &middot; {{ __('Funds') }}: <strong>{{ Currency::format($sheet->getFunds(), $budget->currency) }}</strong>
        &middot; {{ __('Budgeted') }}: <strong>{{ Currency::format($sheet->getBudgeted(), $budget->currency) }}</strong>
    </p>

    <table class="table">
        <thead>
        <tr>
            <th>{{ __('Category') }}</th>
            <th>{{ __('Budgeted') }}</th>
            <th>{{ __('Activity') }}</th>
            <th>{{ __('Available') }}</th>
            <th></th>
        </tr>
        </thead>
        @forelse ($sheet->getRows() as $row)
            <tr>
                <td>
                    {{ $row->getCategory()->name }}
                </td>
                <td>
                    <a href="{{ route('categories.budget', [$budget->id, $row->getCategory()->id, (string) $month]) }}">
                        {{ Currency::format($row->getBudgeted(), $budget->currency) }}
                    </a>
                </td>
                <td>{{ Currency::format($row->getActivity(), $budget->currency) }}</td>
                <td>{{ Currency::format($row->getAvailable(), $budget->currency) }}</td>
                <td>
                    <a href="{{ route('categories.edit', [$budget->id, $row->getCategory()->id]) }}"
                       title="{{ __('Edit Category') }}" class="text-muted">
                        <span class="fa fa-pencil"></span>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-muted text-center">
                    {{ __('No categories available.') }}
                </td>
            </tr>
        @endforelse
    </table>

    <p class="text-right">
        <a href="{{ route('categories.create', [$budget->id]) }}" class="text-muted small ">
            <span class="fa fa-plus"></span> {{ __('Create New Category') }}
        </a>
    </p>

@endsection
