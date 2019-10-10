<?php

namespace App\Http\Controllers;

use App\Item;
use App\MovieDataCollector;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Item::orderBy('meta->rating','desc')
            ->where('items.type', "movie")
            ->paginate(12);
        return view('items.movies.browse')->with('movies', $movies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.movies.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Item::find($id);
        return view('items.movies.show')->with('movie', $movie);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Item::Find($id);

        //Check if movie exists before deleting
        if (!isset($movie)){
            return redirect('/movies/browse')->with('error', 'Movie not Found');
        }

        // Check for correct user
        if(auth()->user()->id !== $movie->user_id){
            return redirect('/movies/browse')->with('error', 'Unauthorized Page');
        }

        $movie->delete();
        return redirect('/movies/browse')->with('success', 'Movie Removed');
    }
}
