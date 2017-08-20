@extends('layouts.budget')

@section('content')

    <div class="float-right my-4">
        To be Budgeted: <strong>{{ $sheet->getAvailable() }}</strong>
        &middot; Previous Month: <strong>{{ $sheet->getPreviousMonthAvailable() }}</strong>
        &middot; Funds: <strong>{{ $sheet->getFunds() }}</strong>
        &middot; Budgeted: <strong>{{ $sheet->getBudgeted() }}</strong>
    </div>

    <p class="display-4">
        <a href="{{ route('sheet', [$budget->id, (string) $month->previous()]) }}">&laquo;</a>
        {{ $month }}
        <a href="{{ route('sheet', [$budget->id, (string) $month->next()]) }}">&raquo;</a>
    </p>

    <table class="table">
        <thead>
        <tr>
            <th>
                Category
                <a href="{{ route('categories.create', [$budget->id]) }}" title="Create New Category" class="text-muted">
                    <span class="fa fa-plus"></span>
                </a>
            </th>
            <th>Budgeted</th>
            <th>Activity</th>
            <th>Available</th>
        </tr>
        </thead>
        @forelse ($sheet->getRows() as $row)
            <tr>
                <td>
                    {{ $row->getCategory()->name }}
                    <a href="{{ route('categories.edit', [$budget->id, $row->getCategory()->id]) }}" title="Edit Category" class="text-muted">
                        <span class="fa fa-pencil"></span>
                    </a>
                </td>
                <td>
                    <a href="{{ route('categories.budget', [$budget->id, $row->getCategory()->id, (string) $month]) }}">
                        {{ $row->getBudgeted() }}
                    </a>
                </td>
                <td>{{ $row->getActivity() }}</td>
                <td>{{ $row->getAvailable() }}</td>
            </tr>
        @empty
                <tr>
                    <td colspan="4" class="text-muted text-center">
                        No categories available.
                    </td>
                </tr>
        @endforelse
    </table>

@endsection
