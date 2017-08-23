@extends('layouts.general')

@section('content')
    <div class="container">
        <div class="card panel-default">
            <div class="card-header">{{ __('Create Budget') }}</div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ Form::open(['route' => ['budgets.store']]) }}

                <div class="form-group">
                    {{ Form::label('name', __('Name')) }}
                    {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('currency', __('Currency')) }}
                    {{ Form::select('currency', Intl::getCurrencyBundle()->getCurrencyNames(), Input::old('currency'), ['class' => 'form-control']) }}
                </div>
                {{ Form::submit(__('Create Budget'), array('class' => 'btn btn-primary')) }}

                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
