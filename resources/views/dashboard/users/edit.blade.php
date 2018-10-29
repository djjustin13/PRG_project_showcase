@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Profiel aanpassen</div>
                    <div class="card-body">
                        {!! Form::open(['action' => ['UsersController@update', $user->id], 'method' => 'POST']) !!}
                        @method('PUT')
                        <div class="form-group">
                            {{Form::label('name', 'Naam:')}}
                            {{Form::text('name', $user->name, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('email', 'Email:')}}
                            {{Form::text('email', $user->email, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::submit('Update profiel', ['class' => 'btn btn-primary'])}}
                        </div>
                        <div class="form-group">
                            <a href="/dashboard/profile/resetpassword" class="btn btn-outline-dark">Wijzig wachtwoord</a>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection