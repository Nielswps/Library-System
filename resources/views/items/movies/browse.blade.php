@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            @if(isset($movies) and count($movies) > 0)
                @foreach($movies as $movie)
                    <div class="col-4 p-1">
                        <div class="card mb-3 col-12 div-link">
                            <a class="card-as-link" href="/movies/{{ $movie->id }}">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-4">
                                        <div>
                                            <img src="{{ $movie->getMeta('movie_cover') }}" class="card-img p-3">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-8">
                                                    <h3 class="card-title"><strong>{{ str_pad($movie->title, 40) }}</strong></h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col align-self-center border-right">
                                                    <p class="card-text"><strong>Description:</strong><br>{{ substr($movie->description, 0, 50)."..." }}</p>
                                                    <p class="card-text"><strong>Rating:</strong> {{ $movie->getMeta('rating') }}/10</p>
                                                </div>
                                                <div class="col align-self-center">
                                                    <h5 class="card-text"><strong>Genre:</strong> {{ $movie->getMeta('genre') }}</h5>
                                                    <h5 class="card-text"><strong>Director:</strong> {{ $movie->getMeta('director') }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <p class="card-text"><small class="text-muted">Last updated: {{ $movie->updated_at }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection()
