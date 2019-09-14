<?php

namespace App\Http\Controllers;

use App\Book;
use App\Item;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderBy('created_at','desc')
            ->where('type', '=', "book")
            ->paginate(12);
        return view('items.books.browse')->with('books', $books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.books.add');
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
            'writer' => 'required'
        ]);

        $book = new Item();
        $book->title = $request->input('title');
        $book->setMeta('writer', $request->input('writer'));
        $book->user_id = auth()->user()->id;

        $book->save();

        return redirect('/')->with('success', $book->title.' Added');

        /*$userDescribedBook = Book::where('title', $request->input('title'))->where('writer', $request->input('writer'));

        if($userDescribedBook->count() < 1){
            $book = new Book;
            $book->user_id = auth()->user()->id;

            //Retrieve movie information from OMDB and store the values in the '$movie' object
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?apikey='.OMDBapikey.'&t='.str_replace(' ', '+', $request->input('title').'&y='.$request->input('release_year')).'&plot=full');
            $result = curl_exec($ch);
            curl_close($ch);
            $retrieved_book = json_decode($result,true);

            if($retrieved_book['Title'] != null and $retrieved_book['Plot'] != null){
                if($request->input('title') == $retrieved_book['Title']){
                    $movie->title = $retrieved_book['Title'];
                    $movie->description = $retrieved_book['Plot'];

                    $movie->release_year = $request->input('release_year');
                    $movie->rating = (float) $movie->get_string_between('START'.$retrieved_book['Ratings'][0]['Value'], 'START', '/');
                    $movie->runtime = (int) $movie->get_string_between('START'.$retrieved_book['Runtime'], 'START', ' min');
                    $movie->genre = $retrieved_book['Genre'];
                    $movie->director = $retrieved_book['Director'];
                    $movie->writers = $retrieved_book['Writer'];
                    $movie->actors = $retrieved_book['Actors'];

                    $movie->movie_cover = $retrieved_book['Poster'];

                    $movie->save();

                    return redirect('/')->with('success', $movie->title.' Added');
                }else{
                    return redirect('/')->with('error', 'Movie not found');
                }
            }else{
                return redirect('/')->with('error', 'Movie not found');
            }
        }else{
            return redirect('/')->with('error', 'Movie already added');
        }*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Item::find($id);
        return view('items.books.show')->with('book', $book);
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
        $book = Item::Find($id);

        //Check if movie exists before deleting
        if (!isset($book)){
            return redirect('/books/browse')->with('error', 'Book not Found');
        }

        // Check for correct user
        if(auth()->user()->id !== $book->user_id){
            return redirect('/books/browse')->with('error', 'Unauthorized Page');
        }

        $book->delete();
        return redirect('/books/browse')->with('success', 'Book Removed');
    }
}
