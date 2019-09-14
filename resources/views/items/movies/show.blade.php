@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mb-3 col-12">
            <nav class="navbar">
                <div class="dropdown ml-auto">
                    <a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a href="{{ route('delete-movie', $movie->id) }}" class="btn dropdown-item pr-0 mr-0" onclick="return confirm('Are you sure?')"></a>
                    </div>
                </div>
            </nav>
            <div class="row align-items-center">
                <div class="col-xl-3">
                    <div class="img-fluid">
                        <img class="card-img p-3" src="{{$movie->movie_cover}}">
                    </div>
                </div>
                <div class="col-1"></div>
                <div class="col-xl-7">
                    <h1 class="text-center card-title"><strong>{{$movie->title}}</strong></h1>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 align-self-center">
                                <p class="card-text"><strong>Description:</strong><br>{{$movie->description}}</p>
                                <h4 class="card-text"><strong>Release year:</strong> {{$movie->release_year}}</h4>
                                <h4 class="card-text"><strong>Rating:</strong> {{$movie->rating}}/10</h4>
                                <h4 class="card-text"><strong>Runtime:</strong> {{$movie->runtime}} min</h4>
                            </div>
                            <div class="border-right"></div>
                            <div class="col-6 align-self-center">
                                <h5 class="card-text"><strong>Genre:</strong> {{$movie->genre}}</h5>
                                <h5 class="card-text"><strong>Director:</strong> {{$movie->director}}</h5>
                                <h5 class="card-text"><strong>Writers:</strong> {{$movie->writers}}</h5>
                                <h5 class="card-text"><strong>Actors:</strong> {{$movie->actors}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="card-text text-muted">Last updated: {{$movie->updated_at}}</p>
                    </div>
                </div>
            </div>
            <!--
            <div class="row align-items-center">
                <div class="col-6">
                </div>
                <div class="col-6">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            -->
        </div>
    </div>
@endsection()
