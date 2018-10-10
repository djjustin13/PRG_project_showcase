@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <h3>Alle gebruikers:</h3>
                        @if(count($users) > 0)
                            <table class="table table-striped">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                                <tr>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            {!! Form::open(['action' => ['UsersController@destroy', $user->id], 'method' => 'POST']) !!}
                                            @method('DELETE')
                                            @csrf
                                            {{Form::submit('Verwijder', ['class' => 'btn btn-danger float-right'])}}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tr>
                            </table>
                        @else
                            <p>Er zijn geen gebruikers...</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
