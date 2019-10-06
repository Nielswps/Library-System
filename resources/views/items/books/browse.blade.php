@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            @if(isset($books) and count($books) > 0)
                @foreach($books as $book)
                    <div class="card mb-3 col-2 div-link m-2">
                        <a class="card-as-link p-2" href="/books/{{$book->id}}">
                            <div class="row no-gutters align-items-center">

                                <div class="card-body">
                                    <div class="row">
                                        <h3 class="card-title">{{ $book->title }}</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col align-self-center">
                                            <h5 class="card-text"><strong>Writer:</strong> {{ $book->getMeta('writer') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center row">
                                <p class="card-text"><small class="text-muted">Last updated: {{ $book->updated_at }}</small></p>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection()
