@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @if(isset($books) and count($books) > 0)
                @foreach($books as $book)
                    <div class="card mb-3 col-4 div-link">
                        <a class="card-as-link" href="/books/{{$book->id}}">
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-4">
                                    <div>
                                        <img src="{{$book->book_cover}}" class="card-img p-3">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <h3 class="card-title">{{$book->title}}</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col align-self-center border-right">
                                                <p class="card-text"><strong>Description:</strong><br>{{substr($book->description, 0, 50)."..."}}</p>
                                                <p class="card-text"><strong>Rating:</strong> {{$book->rating}}/10</p>
                                            </div>
                                            <div class="col align-self-center">
                                                <h5 class="card-text"><strong>Writer:</strong> {{$book->writer}}</h5>
                                                <h5 class="card-text"><strong>Release year:</strong> {{$book->release_year}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <p class="card-text"><small class="text-muted">Last updated: {{$book->updated_at}}</small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection()
