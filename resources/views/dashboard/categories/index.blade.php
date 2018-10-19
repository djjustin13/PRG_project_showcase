@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <h3>Categorieen:</h3>
                    @if(count($categories) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>Naam</th>
                            <th></th>

                        </tr>
                        <tr>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->name}}</td>
                                    <td>
                                        {!! Form::open(['action' => ['CategoriesController@destroy', $category->id], 'method' => 'POST']) !!}
                                        @method('DELETE')
                                        {{Form::submit('Verwijder', ['class' => 'btn btn-danger float-right'])}}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tr>
                    </table>
                        {!! Form::open(['action' => 'CategoriesController@store', 'method' => 'POST', 'files'=> true]) !!}
                        <div class="input-group form-group">
                            {{Form::text('category', '', ['class' => 'form-control', 'placeholder' => 'Nieuwe categorie toevoegen'])}}
                            {{Form::submit('Voeg toe!', ['class' => 'btn btn-primary'])}}
                        </div>
                        {!! Form::close() !!}
                    @else
                         <p>Er zijn geen categorieen...</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
