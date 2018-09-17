@extends('layouts.app')

@section('content')
    <div class="row">
        <h1>Edit project</h1>
    </div>
    <div class="row">
        {!! Form::open(['action' => ['ProjectsController@update', $project->id], 'method' => 'POST']) !!}
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', $project->title, ['class' => 'form-control', 'placeholder' => 'title'])}}
            </div>
            <div class="form-group">
                {{Form::label('text', 'Text')}}
                {{Form::textarea('text', $project->text, ['id' => 'article-ckeditor','class' => 'form-control', 'placeholder' => 'text'])}}
            </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection