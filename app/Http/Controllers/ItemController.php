<?php

namespace App\Http\Controllers;

use App\Item;
use App\MovieDataCollector;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->input('itemType') == 'movie'){
            $this->storeMovie($request);
        } elseif($request->input('itemType') == 'book'){
            $this->storeBook($request);
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
        //
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
        //
    }

    private function storeMovie(Request $request){
        try {
            $this->validate($request, [
                'title' => 'required_without:fileUpload',
                'release_year' => 'required_without:fileUpload'
            ]);
        } catch (ValidationException $e) {
            return redirect('/')->with('error', 'Validation failed. Title and release year are required');
        }

        if($request->hasFile('fileUpload') and $request->file('fileUpload')->getClientOriginalExtension() == 'csv'){
            $moviesFromFile = array_map('str_getcsv', $request->file('fileUpload'));
            foreach ($moviesFromFile as $movieFromFile){
                $movie = (new MovieDataCollector($request->input('title'), $request->input('release_year')))->getMovie();
                $movie->save();
            }
            return redirect('/')->with('success', 'Added the entire or parts of the list has been added');
        }

        $userDescribedMovie = Item::where('title', $request->input('title'))->where('meta->release_year', $request->input('release_year'));
        if ($userDescribedMovie->count() < 1) {
            $movie = (new MovieDataCollector($request->input('title'), $request->input('release_year')))->getMovie();
            $movie->save();
            return redirect('/')->with('success', $movie->title . ' Added');
        } else{
            return redirect('/')->with('error', 'Movie already added to library');
        }
    }

    private function storeBook(Request $request){
        $this->validate($request, [
            'title' => 'required_without:fileUpload',
            'writer' => 'required_without:fileUpload'
        ]);
        if($request->hasFile('fileUpload') and $request->file('fileUpload')->getClientOriginalExtension() == 'csv'){
            $file = fopen($request->file('fileUpload'),"r");
            while (! feof($file)){
                $bookFromFile = fgetcsv($file);
                if(!empty(trim($bookFromFile[0]))){
                    $book = new Item();
                    $book->user_id = auth()->user()->id;
                    $book->type = 'book';
                    $book->title = ($bookFromFile[0] != null ? $bookFromFile[0] : 'Title');
                    $book->description = $bookFromFile[0].' is a book';
                    $meta = array(
                        'writer' => $bookFromFile[1]
                    );

                    $meta = json_encode($meta);
                    $book->meta = $meta;

                    $book->save();
                }
            }
            fclose($file);

            return redirect('/')->with('success', 'Books added');

        } else{
            $book = new Item();
            $book->title = $request->input('title');
            $meta = array(
                'writer' => $request->input('writer')
            );

            $meta = json_encode($meta);
            $book->meta = $meta;

            $book->user_id = auth()->user()->id;

            $book->save();

            return redirect('/')->with('success', $book->title.' Added');
        }
    }
}
