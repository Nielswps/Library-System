<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
        $movies = Item::orderBy('created_at','desc')
            ->where('type', 'movie')
            ->where('meta->rating', '>', $filters['rating'])
            ->where(function ($filterResults) use ($filters) {
                if($filters['genre'] != 'All'){
                    $filterResults->where('meta->genre', 'LIKE', '%'.$filters['genre'].'%');
                }
            })
            ->where(function($searchResults) use ($search) {
                if($search != ''){
                    $searchResults->where('title', 'LIKE', '%'.$search.'%');
                }
            })
            ->where(function($searchResults) use ($search) {
                if($search != ''){

                    //The columns variable contains every column to be search for the search string
                    $columns = ['director', 'writers', 'actors'];
                    foreach ($columns as $column)
                    {
                        $searchResults->orWhere('meta->'.$column, 'LIKE', '%'.$search.'%');
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
        $books = Item::orderBy('created_at','desc')
            ->where('type', 'book')
            ->where('meta->release_year', $filters['release_year'])
            ->where(function($searchResults) use ($search) {
                if($search != ''){

                    //The columns variable contains every column to be search for the search string
                    $columns = ['title', 'meta->writer'];
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
