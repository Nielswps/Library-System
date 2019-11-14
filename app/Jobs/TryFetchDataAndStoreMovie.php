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

class TryFetchDataAndStoreMovie implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $request;

    /**
     * Create a new job instance.
     *
     * @param Request $inputRequest
     */
    public function __construct(Request $inputRequest)
    {
        $this->request = $inputRequest;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $movie = (new MovieDataCollector($this->request->input('movie_title'), $this->request->input('release_year'), $this->request->input('diskType')))->getMovie();
        if($movie->type == false){
            $movie = new Item();
            $movie->title = $this->request->input('movie_title');
            $movie->user_id = auth()->user()->id;

            $meta = array(
                'release_year' => $this->request->input('release_year'),
                'disk_type' => $this->request->input('diskType')
            );
            $meta = json_encode($meta);
            $movie->meta = $meta;
        }
        $movie->type = 'movie';
        $movie->save();
    }
}
