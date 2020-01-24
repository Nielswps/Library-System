@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card mb-3 col-12">
            <nav class="navbar">
                <div class="dropdown ml-auto">
                    <a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a href="{{ route('delete-book', $book->id) }}" class="btn dropdown-item pr-0 mr-0" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </div>
            </nav>
            <div class="row align-items-center">
                <div class="col-xl-3">
                    <div class="img-fluid">
                        <!--Cover image-->
                    </div>
                </div>
                <div class="col-1"></div>
                <div class="col-xl-7">
                    <h1 class="text-center card-title"><strong>{{ $book->title }}</strong></h1>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 align-self-center">
                                <p class="card-text"><strong>Description:</strong><br>{{ $book->description }}</p>
                            </div>
                            <div class="border-right"></div>
                            <div class="col-6 align-self-center">
                                <h5 class="card-text"><strong>Writer:</strong> {{ $book->getMeta('writer') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="card-text text-muted">Last updated: {{ $book->updated_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
