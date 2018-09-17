@extends('layouts.app')

@section('content')
    <div class="row">
        <h1>Create project</h1>
    </div>
    <div class="row">
        {!! Form::open(['action' => 'ProjectsController@store', 'method' => 'POST']) !!}
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'title'])}}
            </div>
            <div class="form-group">
                {{Form::label('text', 'Text')}}
                {{Form::textarea('text', '', ['id' => 'article-ckeditor','class' => 'form-control', 'placeholder' => 'text'])}}
            </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection