@extends('layouts.budget')


@section('navbar')
    <div class="h3 mt-1 mt-lg-0 mb-0 text-center text-lg-left" style="line-height: 1rem;">
        <a class="btn btn-secondary rounded-circle"
           href="{{ route('sheet', [$budget->id, (string) $month->previous()]) }}" title="{{ __('Previous Month') }}">
            <span class="fa fa-chevron-left"></span>
        </a>
        {{ $month->forHumans() }}
        <a class="btn btn-secondary rounded-circle" href="{{ route('sheet', [$budget->id, (string) $month->next()]) }}"
           title="{{ __('Next Month') }}">
            <span class="fa fa-chevron-right"></span>
        </a>
    </div>
@endsection

@section('content')

    <div class="navbar {{ ($sheet->getAvailable() >= 0)?'bg-success':'bg-danger' }} text-light row d-lg-none">
        <div class="col">
            <strong>{{ __('To be Budgeted') }}</strong>
        </div>
        <div class="col text-right">
            {{ Currency::format($sheet->getAvailable(), $budget->currency) }}
        </div>
    </div>

    <div class="d-none d-lg-flex form-row mb-3" style="align-items: flex-end;">
        <div class="col-6">
            <div class="h3 display-4 mb-0">
                <a class="btn btn-secondary rounded-circle"
                   href="{{ route('sheet', [$budget->id, (string) $month->previous()]) }}"
                   title="{{ __('Previous Month') }}">
                    <span class="fa fa-chevron-left"></span>
                </a>
                {{ $month->forHumans() }}
                <a class="btn btn-secondary rounded-circle"
                   href="{{ route('sheet', [$budget->id, (string) $month->next()]) }}"
                   title="{{ __('Next Month') }}">
                    <span class="fa fa-chevron-right"></span>
                </a>
            </div>
        </div>
        <div class="col text-right">
            <div class="badge {{ ($sheet->getAvailable() >= 0)?'badge-success':'badge-danger' }}">
                <strong class="h3">{{ Currency::format($sheet->getAvailable(), $budget->currency) }}</strong><br>
                <span class="small">{{ __('To be Budgeted') }}</span>
            </div>
        </div>
        <div class="col small">
            {{ __('Previous Month') }}:
            <strong>{{ Currency::format($sheet->getPreviousMonthAvailable(), $budget->currency) }}</strong><br>
            {{ __('Funds') }}: <strong>{{ Currency::format($sheet->getFunds(), $budget->currency) }}</strong><br>
            {{ __('Budgeted') }}: <strong>{{ Currency::format($sheet->getBudgeted(), $budget->currency) }}</strong>
        </div>
    </div>

    <table class="table table-sm">
        <thead>
        <tr>
            <th>{{ __('Category') }}</th>
            <th>{{ __('Budgeted') }}</th>
            <th class="d-none d-md-table-cell">{{ __('Activity') }}</th>
            <th>{{ __('Available') }}</th>
        </tr>
        </thead>
        @forelse ($sheet->getRows() as $row)
            <tr>
                <td>
                    <a href="{{ route('categories.edit', [$budget->id, $row->getCategory()->id]) }}"
                       title="{{ __('Edit Category') }}" class="text-dark">
                        {{ $row->getCategory()->name }}
                    </a>
                </td>
                <td class="text-right">
                    <a class="{{ ($row->getBudgeted() == 0)?'text-muted':'text-dark' }}"
                       href="{{ route('categories.budget', [$budget->id, $row->getCategory()->id, (string) $month]) }}">
                        {{ Currency::format($row->getBudgeted(), $budget->currency) }}
                    </a>
                </td>
                <td class="d-none d-md-table-cell text-right {{ ($row->getActivity() == 0)?'text-muted':'text-dark' }}">{{ Currency::format($row->getActivity(), $budget->currency) }}</td>
                <td class="text-right">
                    <span style="font-size: 100%"
                          class="badge {{ ($row->getAvailable() == 0)?'badge-secondary':(($row->getAvailable() >= 0)?'badge-success':'badge-danger') }}">
                        {{ Currency::format($row->getAvailable(), $budget->currency) }}
                    </span>
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

    <p class="text-right px-2 px-md-0">
        <a href="{{ route('categories.create', [$budget->id]) }}" class="text-muted small ">
            <span class="fa fa-plus"></span> {{ __('Create New Category') }}
        </a>
    </p>

@endsection
