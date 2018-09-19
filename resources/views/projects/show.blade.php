@extends('layouts.app')

@section('content')
    <br>
    <a href="/projects" class="btn btn-outline-dark">Back</a>
    <h1>{{$project->title}}</h1>
    <img src="/storage/cover_images/{{$project->cover_image}}" style="width: 100%" alt="">
    <br><br>
    <div>
        {!! $project->text !!}
    </div>
    <small>Geplaats op {{$project->created_at}} door {{$project->user->name}}</small>
    @if(! Auth::guest())
        @if(Auth::user()->id == $project->user_id)
            <hr>
            <a href="/projects/{{$project->id}}/edit" class="btn btn-outline-dark">Bewerk</a>
            {!! Form::open(['action' => ['ProjectsController@destroy', $project->id], 'method' => 'POST']) !!}
                @method('DELETE')
                @csrf
                {{Form::submit('Verwijder', ['class' => 'btn btn-danger'])}}
            {!! Form::close() !!}
        @endif
    @endif
@endsection