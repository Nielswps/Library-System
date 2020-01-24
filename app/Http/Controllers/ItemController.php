<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItem;
use App\Item;
use App\MovieDataCollector;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Translation\Tests\StringClass;
use App\Jobs\TryFetchDataAndStoreMovie;

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
        return response(view('items.add'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItem $request)
    {
        if($request->input('itemType') == 'movie'){
            return response($this->storeMovie($request));
        } elseif($request->input('itemType') == 'book'){
            return response($this->storeBook($request));
        } else{
            return response(redirect('/items/add')->with('error', 'You have to chose an item type'));
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
        $item = Item::find($id);
        if($item->type = 'movie'){
            return response(view('items.movies.show')->with('movie', $item));
        } elseif($item->type = 'book'){
            return response(view('items.books.show')->with('book', $item));
        } else{
            return response(view('layouts.dashboard'));
        }
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
        $item = Item::Find($id);

        //Check if movie exists before deleting
        if (!isset($item)){
            return response(redirect('/browse')->with('error', 'Item not Found'));
        }

        // Check for correct user
        if(auth()->user()->id !== $item->user_id){
            return response(redirect('/browse')->with('error', 'Unauthorized Page'));
        }

        $item->delete();
        return response(redirect('/browse')->with('success', 'Item Removed'));
    }

    private function storeMovie(Request $request)
    {
        if ($request->hasFile('fileUpload')) {
            if($request->file('fileUpload')->getClientOriginalExtension() == 'csv'){
                return $this->storeMoviesFromFile($request);
            } else {
                return redirect('/items/add')->with('error', 'File must be a CSV-file');
            }
        } else if (Item::where('title', $request->input('movieTitle'))->where('meta->releaseYear', $request->input('releaseYear'))->count() < 1) {
            $movie = new Item();
            $movie->title = $request->input('movieTitle');
            $movie->user_id = auth()->user()->id;
            $movie->description = "This movie has not yet been fetched";

            $meta = array(
                'releaseYear' => $request->input('releaseYear'),
                'diskType' => $request->input('diskType'),
                'movie_cover' => "N/A",
                'fetched' => false
            );

            $meta = json_encode($meta);
            $movie->meta = $meta;

            $movie->save();
            TryFetchDataAndStoreMovie::dispatch($movie);

            return redirect('/')->with('success', $request->input('movieTitle') . ' has been added to the system and potential data will be fetched from IMDb at a later time');
        } else {
            return redirect('/')->with('error', 'Movie already added to library');
        }
    }

    private  function storeMoviesFromFile(Request $request){
        $file = fopen($request->file('fileUpload'), "r");
        while(!feof($file)){
            $movieFromLine = fgetcsv($file);
            if(!empty(trim($movieFromLine[0]))){
                $movie = new Item();
                $movie->type = 'movie';
                $movie->title = $movieFromLine[0];
                $movie->user_id = auth()->user()->id;
                $movie->setMeta('releaseYear', $movieFromLine[1]);
                $movie->setMeta('diskType', $movieFromLine[2]);
                $movie->setMeta('fetched', false);
                $movie->setMeta('movie_cover', "N/A");
                $movie->save();
                TryFetchDataAndStoreMovie::dispatch($movie);
            }
        }
        return redirect('/')->with('success', 'The list has been added to the system and potential data will be fetched from IMDb at a later time');
    }

    private function storeBook(Request $request){
        if($request->hasFile('fileUpload') and $request->file('fileUpload')->getClientOriginalExtension() == 'csv'){
            return $this->storeBooksFromFile($request);
        } else{
            $book = new Item();
            $book->type = 'book';
            $book->title = $request->input('bookTitle');
            $meta = array(
                'writer' => $request->input('writer')
            );

            if(Item::where('title', $request->input('bookTitle'))->where('meta->writer', $request->input('writer'))->count() < 1){
                if(!empty($request->input('description'))){
                    $book->description = $request->input('description');
                } else {
                    $book->description = $book->title.', written by '.$book->writer;
                }

                $meta = json_encode($meta);
                $book->meta = $meta;

                $book->user_id = auth()->user()->id;

                $book->save();

                return redirect('/')->with('success', $book->title.' Added');
            }
            else{
                return redirect('/')->with('error', 'Book already added to library');
            }
        }
    }

    private function storeBooksFromFile(Request $request){
        $file = fopen($request->file('fileUpload'),"r");
        while (!feof($file)){
            $bookFromFile = fgetcsv($file);
            if(!empty(trim($bookFromFile[0]))){
                $book = new Item();
                $book->user_id = auth()->user()->id;
                $book->type = 'book';
                $book->title = ($bookFromFile[0] != null ? $bookFromFile[0] : 'Title');
                $meta = array(
                    'writer' => $bookFromFile[1]
                );
                $book->description = $bookFromFile[0].', written by '.$bookFromFile[1];

                $meta = json_encode($meta);
                $book->meta = $meta;

                $book->save();
            }
        }
        fclose($file);

        return redirect('/')->with('success', 'Books added');
    }
}
