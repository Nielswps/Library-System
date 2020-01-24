@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mb-3 col-12">
            <nav class="navbar">
                <div class="dropdown ml-auto">
                    <a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a href="{{ route('delete-movie', $movie->id) }}" class="btn dropdown-item pr-0 mr-0" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </div>
            </nav>
            <div class="row align-items-center">
                <div class="col-xl-3">
                    <div class="img-fluid">
                        <img class="card-img p-3 mb-4" src="{{ $movie->getMeta('movie_cover') == "N/A" ? "/storage/no_image_found.png" : $movie->getMeta('movie_cover') }}">
                    </div>
                </div>
                <div class="col-1"></div>
                <div class="col-xl-7">
                    <h1 class="text-center card-title ml-3 d-inline-block"><strong>{{ $movie->title }}</strong></h1>
                    <span class="ml-2 badge badge-secondary align-top">{{ $movie->getMeta('fetched') }}</span>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 align-self-center">
                                <p class="card-text"><strong>Description:</strong><br>{{ $movie->description }}</p>
                                <h4 class="card-text"><strong>Release year:</strong> {{ $movie->getMeta('releaseYear') }}</h4>
                                <h4 class="card-text"><strong>Rating:</strong> {{ $movie->getMeta('rating') }}/10</h4>
                                <h4 class="card-text"><strong>Runtime:</strong> {{ $movie->getMeta('runtime') }} min</h4>
                            </div>
                            <div class="border-right"></div>
                            <div class="col-6 align-self-center">
                                <h5 class="card-text"><strong>Genre:</strong> {{ $movie->getMeta('genre') }}</h5>
                                <h5 class="card-text"><strong>Director:</strong> {{ $movie->getMeta('director') }}</h5>
                                <h5 class="card-text"><strong>Writers:</strong> {{ $movie->getMeta('writers') }}</h5>
                                <h5 class="card-text"><strong>Actors:</strong> {{ $movie->getMeta('actors') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="card-text text-muted">Last updated: {{ $movie->updated_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
