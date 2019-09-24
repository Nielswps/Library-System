@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Movie</h1>
        <form class="row" method="POST" action="{{ route('store-movie') }}" enctype="multipart/form-data">
            @csrf
            <button class="btn btn-light col-12 mb-4" type="button" data-toggle="collapse" href="#normalAdd" aria-expanded="false" aria-controls="filters"><h2>Add movie by Title and Release Year</h2></button>
            <div class="collapse col-12 mb-4" id="normalAdd">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                </div>
                <div class="form-group">
                    <label for="release_year">Release Year</label>
                    <input type="text" class="form-control" id="release_year" name="release_year" placeholder="Example: 1999">
                </div>
            </div>
            <button class="btn btn-light col-12 mb-4" type="button" data-toggle="collapse" href="#fileAdd" aria-expanded="false" aria-controls="filters"><h2>Add list of books with CSV-file</h2></button>
            <div class="collapse col-12 mb-4" id="fileAdd">
                <div class="form-group row">
                    <input class="custom-file-input col-11" type="file" name="fileUpload" id="fileUpload" accept="text/csv">
                    <label class="custom-file-label col-11" for="fileUpload">Upload CSV-file...</label>
                    <a class="m-auto" data-toggle="collapse" href="#fileFormattingInfo" role="button" aria-expanded="false" aria-controls="fileFormattingInfo">?</a>
                    <div class="collapse card card-body" aria-labelledby="fileFormattingInfo" id="fileFormattingInfo">
                        <p class="pr-0 mr-0">
                            The uploaded file has to be a .CSV-file in the format:<br>
                            Title, Release Year, Type [DVD, Blu-Ray, digital] <b>(optional)</b><br>
                            Example: <i>The Godfather, 1972, DVD</i>
                        </p>
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-primary m-2 btn-block" value="Add">
        </form>
    </div>
@endsection
