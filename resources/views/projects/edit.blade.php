@extends('layouts.app')

@section('content')
    <div class="row">
        <h1>Edit project</h1>
    </div>
    <div class="row">
        {!! Form::open(['action' => ['ProjectsController@update', $project->id], 'method' => 'POST', 'files'=> true]) !!}
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', $project->title, ['class' => 'form-control', 'placeholder' => 'title'])}}
            </div>
            <div class="form-group">
                {{Form::label('text', 'Text')}}
                {{Form::textarea('text', $project->text, ['id' => 'article-ckeditor','class' => 'form-control', 'placeholder' => 'text'])}}
            </div>
            <div class="form-group">
                {{Form::label('categories[]', 'Categorieën')}}
                {{ Form::select('categories[]', $categories, $project->categories, ['class' => 'form-control', 'multiple' => 'multiple']) }}
            </div>
            <div class="input-group form-group">
                <label class="input-group-btn">
                            <span class="btn btn-secondary btn-file">
                                Upload afbeelding {{Form::file('images[]', ['multiple'=> true])}}
                            </span>
                </label>
                <input id="file-display" type="text" class="form-control" readonly>
            </div>
        @method('PUT')
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection