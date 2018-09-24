@extends('layouts.app')

@section('content')
    <div class="row">
        <h1>Create project</h1>
    </div>
    <div class="row">
        {!! Form::open(['action' => 'ProjectsController@store', 'method' => 'POST', 'files'=> true]) !!}
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'title'])}}
            </div>
            <div class="form-group">
                {{Form::label('text', 'Text')}}
                {{Form::textarea('text', '', ['id' => 'article-ckeditor','class' => 'form-control', 'placeholder' => 'text'])}}
            </div>
            <div class="input-group form-group">
                <label class="input-group-btn">
                        <span class="btn btn-secondary btn-file">
                            Upload afbeelding {{Form::file('images[]', ['multiple'=> true])}}
                        </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>

        @csrf
        {{Form::submit('Voeg project toe', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection