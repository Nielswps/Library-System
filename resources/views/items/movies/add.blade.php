@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Movie</h1>
        <form method="POST" action="{{ route('store-movie') }}">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="release_year">Release Year</label>
                <input type="text" class="form-control" id="release_year" name="release_year" placeholder="Example: 1999">
            </div>
            <input type="submit" class="btn btn-primary" value="Add">
        </form>
    </div>
@endsection
