 @extends('layouts.app')

 @section('content')
     <div class="row">
         <h1>Projects</h1>
     </div>
     <div class="row">
         @if(count($projects) > 0)
            @foreach($projects as $project)
            <div class="card col-md-12">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <img src="/storage/cover_images/{{$project->cover_image}}" style="width: 100%" alt="">
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <h3><a href="/projects/{{$project->id}}">{{$project->title}}</a></h3>
                            <small>Geplaatst op {{$project->created_at}} door {{$project->user->name}}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
             {{$projects->links()}}
         @else
            <p>Er zijn geen projecten...</p>
         @endif
     </div>
 @endsection