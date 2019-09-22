@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Book</h1>
        <form class="row" method="POST" action="{{ route('store-book') }}" enctype="multipart/form-data">
            @csrf
            <button class="btn btn-light col-12 mb-4" type="button" data-toggle="collapse" href="#normalAdd" aria-expanded="false" aria-controls="filters"><h2>Add book by Title and Writer</h2></button>
            <div class="collapse col-12 mb-4" id="normalAdd">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                </div>
                <div class="form-group">
                    <label for="writer">Writer</label>
                    <input type="text" class="form-control" id="writer" name="writer" placeholder="Example: Chris Voss">
                </div>
            </div>
            <button class="btn btn-light col-12 mb-4" type="button" data-toggle="collapse" href="#fileAdd" aria-expanded="false" aria-controls="filters"><h2>Add list of books with CSV-file</h2></button>
            <div class="collapse col-12 mb-4" id="fileAdd">
                <div class="form-group row">
                    <input class="custom-file-input col-11" type="file" name="fileUpload" id="fileUpload">
                    <label class="custom-file-label col-11" for="fileUpload">Upload CSV-file...</label>
                    <a class="m-auto" data-toggle="collapse" href="#fileFormattingInfo" role="button" aria-expanded="false" aria-controls="fileFormattingInfo">?</a>
                    <div class="collapse card card-body" aria-labelledby="fileFormattingInfo" id="fileFormattingInfo">
                        <p class="pr-0 mr-0">The formatting of the file</p>
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-primary m-2 btn-block" value="Add">
        </form>
    </div>
@endsection
