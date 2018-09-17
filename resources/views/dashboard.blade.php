@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="/projects/create" class="btn btn-primary"> Maak nieuw project</a>
                    <hr>
                    <h3>Jouw projecten:</h3>
                    @if(count($projects) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>Title</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            @foreach($projects as $project)
                                <tr>
                                    <td>{{$project->title}}</td>
                                    <td><a href="/projects/{{$project->id}}/edit" class="btn btn-outline-dark float-right">Bewerk</a></td>
                                    <td>
                                        {!! Form::open(['action' => ['ProjectsController@destroy', $project->id], 'method' => 'POST']) !!}
                                        @method('DELETE')
                                        @csrf
                                        {{Form::submit('Verwijder', ['class' => 'btn btn-danger float-right'])}}
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
