@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <h3>Alle projecten:</h3>
                    @if(count($projects) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>Titel</th>
                            <th>Gebruiker</th>
                            <th></th>
                        </tr>
                        <tr>
                            @foreach($projects as $project)
                                <tr>
                                    <td><a href="/projects/{{$project->id}}">{{$project->title}}</a></td>
                                    <td>{{$project->user->name}}</td>
                                    <td>
                                        {!! Form::open(['action' => ['ProjectsController@destroy', $project->id], 'method' => 'POST']) !!}
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
                         <p>Je hebt nog geen projecten...</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
