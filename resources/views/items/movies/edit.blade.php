@extends('layouts.app')

@section('content')
    <h1>Edit Movie</h1>
    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    {!! Form::open(['action' => ['MovieController', $movie->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('title', 'Title')}}
        {{Form::text('title', $movie->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
    </div>
    <div class="form-group">
        {{Form::label('releaseYear', 'Release Year')}}
        {{Form::text('releaseYear', $movie->releaseYear,['class' => 'form-control'])}}
    </div>
    {{Form::hidden('_method','PUT')}}
    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
