 @extends('layouts.app')

 @section('content')
     {!! Form::open(['action' => 'ProjectsController@index', 'method' => 'GET']) !!}
     <div class="row">
         <h1 class="col-md-3">Projects</h1>
         <div class="col-md-6">
             <div class="form-group input-group">
                 {{Form::text('search', '', ['class' => 'form-control', 'placeholder' => 'Zoeken..', 'style' => 'width: 45%'])}}
                 {{Form::select('category', $categories, null, ['class' => 'form-control']) }}
                 {{Form::button('<i class="fas fa-search"></i>', ['type' => 'submit','class' => 'btn btn-outline-dark'])}}
             </div>
         </div>
         <div class="col-md-3">
             <span>Sorteer op: </span><a href="#" onclick="sort(event,'created_at')">Datum</a> | <a href="#" onclick="sort(event,'rating')">Rating</a>
         </div>
     </div>
     {!! Form::close() !!}
     <div class="row">
         @if(count($projects) > 0)
            @foreach($projects as $project)
            <div class="col-md-6 col-lg-4">
                <a href="/projects/{{$project->id}}"><div class="card project-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 text-center" style="height: 180px">
                                <img src="/storage/cover_images/{{ $project->images->first()['filename']  }}" class="img-responsive" style=" height: auto ; max-width: 100%; max-height: 178px;" alt="">
                            </div>
                            <div class="col-sm-12 ">
                                <hr>
                                <h3>{{$project->title}}</h3>
                                <p>Gemiddelede rating: {{$project->avgRating}}</p>
                                <small>Geplaatst op {{$project->created_at}} door {{$project->user->name}}</small>
                            </div>
                        </div>
                    </div>
                    </div></a>
            </div>
            @endforeach
         @else
            <p class="col">Er zijn geen projecten...</p>
         @endif
     </div>
 @endsection