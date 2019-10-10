<?php

namespace App\Http\Controllers;

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
        $books = Item::orderBy('created_at','desc')
            ->where('items.type', "book")
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

        //Check if book exists before deleting
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
