 @extends('layouts.app')

 @section('content')
     <div class="row">
         <h1 class="col">Projects</h1>
     </div>
     <div class="row">
         @if(count($projects) > 0)
            @foreach($projects as $project)
            <div class="col-md-6 col-lg-4">
                <a href="/projects/{{$project->id}}"><div class="card project-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 text-center" style="height: 180px">
                                <img src="/storage/cover_images/{{$project->cover_image}}" class="img-responsive" style=" height: auto ; max-width: 100%; max-height: 178px;" alt="">
                            </div>
                            <div class="col-sm-12 ">
                                <hr>
                                <h3>{{$project->title}}</h3>
                                <small>Geplaatst op {{$project->created_at}} door {{$project->user->name}}</small>
                            </div>
                        </div>
                    </div>
                    </div></a>
            </div>
            @endforeach
             {{$projects->links()}}
         @else
            <p class="col">Er zijn geen projecten...</p>
         @endif
     </div>
 @endsection