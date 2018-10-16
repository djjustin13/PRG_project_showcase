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
            <div class="form-group">
                {{Form::label('categories[]', 'Categorieën')}}
                {{ Form::select('categories[]', $categories, null, ['class' => 'form-control', 'multiple' => 'multiple']) }}
            </div>
            <div class="input-group form-group">
                <label class="input-group-btn">
                        <span class="btn btn-secondary btn-file">
                            Upload afbeeldingen {{Form::file('images[]', ['id' => 'input-id','multiple'=> true])}}
                        </span>
                </label>
                <input id="file-display" type="text" class="form-control" readonly>
            </div>
        {{Form::submit('Voeg project toe', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection