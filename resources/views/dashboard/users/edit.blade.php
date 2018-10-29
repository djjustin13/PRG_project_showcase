@extends('layouts.app')

@section('content')
    <div class="row">
        {!! Form::open(['action' => 'UsersController@store', 'method' => 'POST']) !!}

        <div class="form-group">
            {{Form::label('name', 'Naam:')}}
            {{Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'title'])}}
        </div>
        {{Form::submit('Update profiel', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection