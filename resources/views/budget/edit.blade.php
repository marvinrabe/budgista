@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card panel-default">
            <div class="card-header">Edit Budget</div>

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

                {{ Form::model($budget, array('route' => array('budget.update', $budget->id), 'method' => 'PUT', 'id' => 'form')) }}

                <div class="form-group">
                    {{ Form::label('name', 'Name') }}
                    {{ Form::text('name', null, array('class' => 'form-control')) }}
                </div>

                {{ Form::close() }}

                <div class="row">
                    <div class="col">
                        <button form="form" class="btn btn-primary">Edit Budget</button>
                    </div>
                    <div class="col text-right">
                        <div class="d-inline">
                            {{ Form::open(array('url' => 'budget/' . $budget->id, 'class' => 'pull-right')) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::submit('Delete Budget', array('class' => 'btn btn-outline-danger')) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
