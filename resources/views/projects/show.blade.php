@extends('layouts.app')

@section('content')
    <br>
    <a href="/projects" class="btn btn-outline-dark">Back</a>
    <h1>{{$project->title}}</h1>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($project->images as $image)
                @if ($loop->first)
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="/storage/cover_images/{{$image->filename}}" alt="First slide">
                    </div>
                @else
                    <div class="carousel-item">
                        <img class="d-block w-100" src="/storage/cover_images/{{$image->filename}}" alt="First slide">
                    </div>
                @endif
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <br><br>
    <div>
        {!! $project->text !!}
    </div>
    <small>Geplaats op {{$project->created_at}} door {{$project->user->name}}</small>
    <div class="categories">
        @foreach($project->categories as $cat)
            <span class="project-category">{{$cat->name}}</span>
        @endforeach
    </div>
    @if(! Auth::guest())
        @if(Auth::user()->id == $project->user_id)
            <hr>
            <a href="/projects/{{$project->id}}/edit" class="btn btn-outline-dark">Bewerk</a>
            {!! Form::open(['action' => ['ProjectsController@destroy', $project->id], 'method' => 'POST']) !!}
                @method('DELETE')
                @csrf
                {{Form::submit('Verwijder', ['class' => 'btn btn-danger'])}}
            {!! Form::close() !!}
        @else
            <rating-component project="{{$project->id}}"></rating-component>
        @endif
    @endif
@endsection