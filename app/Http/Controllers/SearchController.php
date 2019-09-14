<?php

namespace App\Http\Controllers;

use App\Book;
use App\Item;
use App\Jobs\ProcessSearch;
use App\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    /**
     * Search function for the movie part of the library.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    **/
    public function movieSearch(Request $request)
    {
        $search = $request->input('search', '');
        $filters =  ['genre' => $request->input('genre', 'All'), 'rating' => $request->input('lowestRating', 0), 'search' => $search];
        $movies = Movie::orderBy('created_at','desc')
            ->where('type', '=', "movie")
            ->where('rating', '>', $filters['rating'])
            ->where(function ($filterResults) use ($filters) {
                if($filters['genre'] != 'All'){
                    $filterResults->where('genre', 'LIKE', '%'.$filters['genre'].'%');
                }
            })
            ->where(function($searchResults) use ($search) {
                if($search != ''){

                    //The columns variable contains every column to be search for the search string
                    $columns = ['title', 'director', 'writers', 'actors'];
                    foreach ($columns as $column)
                    {
                        $searchResults->orWhere($column, 'LIKE', '%'.$search.'%');
                    }
                }
            })
            ->paginate(12);
        return view('items.movies.browse')->with('movies', $movies)->with('filters', $filters);
    }

    /**
     * Search function for the movie part of the library.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     **/
    public function bookSearch(Request $request)
    {
        $search = $request->input('search', '');
        $filters =  ['writer' => $request->input('writer', ''), 'release_year' => $request->input('release_year', ''), 'search' => $search];
        $books = Book::orderBy('created_at','desc')
            ->where('type', '=', "book")
            ->where('release_year', '=', $filters['release_year'])
            ->where(function($searchResults) use ($search) {
                if($search != ''){

                    //The columns variable contains every column to be search for the search string
                    $columns = ['title', 'writers'];
                    foreach ($columns as $column)
                    {
                        $searchResults->orWhere($column, 'LIKE', '%'.$search.'%');
                    }
                }
            })
            ->paginate(12);
        return view('items.books.browse')->with('books', $books)->with('filters', $filters);
    }
}
