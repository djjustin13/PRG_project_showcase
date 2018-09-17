@extends('layouts.app')

@section('content')
    <br>
    <a href="/projects" class="btn btn-outline-dark">Back</a>
    <h1>{{$project->title}}</h1>
    <div>
        {!! $project->text !!}
    </div>
    <small>Geplaats op {{$project->created_at}}</small>
@endsection