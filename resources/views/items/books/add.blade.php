@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Book</h1>
        <form method="POST" action="{{ route('store-book') }}">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="writer">Writer</label>
                <input type="text" class="form-control" id="writer" name="writer" placeholder="Example: Chris Voss">
            </div>
            <input type="submit" class="btn btn-primary" value="Add">
        </form>
    </div>
@endsection
