<?php

namespace App\Jobs;

use App\Item;
use App\MovieDataCollector;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use phpDocumentor\Reflection\Types\Integer;

class TryFetchDataAndStoreMovie implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $movie;

    /**
     * Create a new job instance.
     *
     * @param Item $inputMovie
     */
    public function __construct(Item $inputMovie)
    {
        $this->movie = $inputMovie;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fetchedMovie = (new MovieDataCollector($this->movie->title, $this->movie->getMeta('releaseYear'), $this->movie->getMeta('diskType')))->getMovie();
        if($fetchedMovie->type == 'movie'){
            $this->movie = $fetchedMovie;
        } else{
            $this->movie->setMeta('fetched', 'no_data');
        }
        $this->movie->update();
    }
}
