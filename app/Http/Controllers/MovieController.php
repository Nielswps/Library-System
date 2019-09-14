<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Runtime;

const OMDBapikey = "f8fca87a";

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Item::orderByMeta('rating','desc')
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
        $this->validate($request, [
            'title' => 'required',
            'release_year' => 'required'
        ]);

        $userDescribedMovie = Item::where('title', $request->input('title'))->whereMeta('release_year', $request->input('release_year'));

        if($userDescribedMovie->count() < 1){
            $movie = new Item();
            $movie->user_id = auth()->user()->id;
            $movie->type = 'movie';

            //Retrieve movie information from OMDB and store the values in the '$movie' object
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?apikey='.OMDBapikey.'&t='.str_replace(' ', '+', $request->input('title').'&y='.$request->input('release_year')).'&plot=full');
            $result = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $retrieved_movie = json_decode($result,true);

            if($statusCode == 200 and $retrieved_movie['Response'] == 'True' and $retrieved_movie['Title'] == $request->input('title')){
                $movie->title = $retrieved_movie['Title'];
                $movie->description = $retrieved_movie['Plot'];

                $meta = array(
                    'release_year' => $retrieved_movie['Year'],
                    'rating' => (float) $movie->get_string_between('START'.$retrieved_movie['Ratings'][0]['Value'], 'START', '/'),
                    'runtime' => (int) $movie->get_string_between('START'.$retrieved_movie['Runtime'], 'START', ' min'),
                    'genre' => $retrieved_movie['Genre'],
                    'director' => $retrieved_movie['Director'],
                    'writers' => $retrieved_movie['Writer'],
                    'actors' => $retrieved_movie['Actors'],
                    'movie_cover' => $retrieved_movie['Poster']
                );

                $meta = json_encode($meta);
                $movie->meta = $meta;

                $movie->save();

                return redirect('/')->with('success', $movie->title.' Added');

            }else{
                return redirect('/')->with('error', 'Movie not found at IMDb');
            }
        }else{
            return redirect('/')->with('error', 'Movie already added to library');
        }
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
