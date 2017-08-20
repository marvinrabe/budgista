@extends('layouts.budget')

@section('content')

    <div class="float-right my-4">
        To be Budgeted: <strong>0€</strong>
        &middot; Previous Month: <strong>0€</strong>
        &middot; Funds: <strong>0€</strong>
        &middot; Budgeted: <strong>0€</strong>
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
        @forelse ($budget->categories as $category)
            <tr>
                <td>
                    {{ $category->name }}
                    <a href="{{ route('categories.edit', [$budget->id, $category->id]) }}" title="Edit Category" class="text-muted">
                        <span class="fa fa-pencil"></span>
                    </a>
                </td>
                <td>0€</td>
                <td>0€</td>
                <td>0€</td>
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
