<?php

namespace App\Jobs;

use App\IDataCollector;
use App\Item;
use App\MovieDataCollector;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use mysql_xdevapi\Exception;
use phpDocumentor\Reflection\Types\Integer;

class TryFetchDataAndStoreMovie implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $movie;
    private $dataCollector;

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
        try{
            $fetchedMovie = (new MovieDataCollector($this->movie))->getData();
            if($fetchedMovie->type == 'movie'){
                $this->movie = $fetchedMovie;
                $this->movie->setMeta('fetched', 'Data fetched');
            } else{
                $this->movie->type = 'movie';
                $this->movie->setMeta('fetched', 'No data found');
                $this->movie->setMeta('movie_cover', "N/A");
                $this->release();
            }
            $this->movie->update();
        }
        catch (Exception $exception) {
            log($exception->getMessage());
        }
    }
}
