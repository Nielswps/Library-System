<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItem;
use App\Item;
use App\MovieDataCollector;
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
        return view('items.add');
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
            return $this->storeMovie($request);
        } elseif($request->input('itemType') == 'book'){
            return $this->storeBook($request);
        } else{
            return redirect('/')->with('error', 'You have to chose an item type');
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

    private function storeMovie(Request $request)
    {
        if ($request->hasFile('fileUpload')) {
            if($request->file('fileUpload')->getClientOriginalExtension() == 'csv'){
                return $this->storeMoviesFromFile($request);
            } else {
                return redirect('/items/add')->with('error', 'File must be a CSV-file');
            }
        } else if (Item::where('title', $request->input('movie_title'))->where('meta->release_year', $request->input('release_year'))->count() < 1) {
            TryFetchDataAndStoreMovie::dispatch($request);
            return redirect('/')->with('success', $request->input('movie_title') . ' will be added to the system');
        } else {
            return redirect('/')->with('error', 'Movie already added to library');
        }
    }

    private  function storeMoviesFromFile(Request $request){
        $file = fopen($request->file('fileUpload'), "r");
        while(!feof($file)){
            $movieFromLine = fgetcsv($file);
            if(!empty(trim($movieFromLine[0]))){
                TryFetchDataAndStoreMovie::dispatch($request);
            }
        }
        return redirect('/')->with('success', 'The list has been added to a queue and will be added to the system');
    }

    private function storeBook(Request $request){
        if($request->hasFile('fileUpload') and $request->file('fileUpload')->getClientOriginalExtension() == 'csv'){
            return $this->storeBooksFromFile($request);
        } else{
            $book = new Item();
            $book->type = 'book';
            $book->title = $request->input('book_title');
            $meta = array(
                'writer' => $request->input('writer')
            );

            if(Item::where('title', $request->input('book_title'))->where('meta->writer', $request->input('writer'))->count() < 1){
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
