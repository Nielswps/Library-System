<?php


namespace App;

class MovieDataCollector
{
    private $movie;

    /**
     * MovieDataCollector constructor.
     * @param Item $movie
     */
    public function __construct(Item $movie)
    {
        $this->movie = $movie;
    }

    /**
     * @return Item|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getMovie(){

        $fetchedData = $this->fetchIMDbData();

        if ($fetchedData == false) {
            $this->movie->type = 'false';
            return $this->movie;
        }

        $this->movie->title = $fetchedData['Title'];
        $this->movie->description = $fetchedData['Plot'];

        $this->movie->setMeta('releaseYear', $fetchedData['Year']);
        $this->movie->setMeta('rating', (float)(empty($fetchedData['Ratings']) ? 0 : (float)explode('/', $fetchedData['Ratings'][0]['Value'])[0]));
        $this->movie->setMeta('runtime', (int)explode(' ', $fetchedData['Runtime'])[0]);
        $this->movie->setMeta('genre', $fetchedData['Genre']);
        $this->movie->setMeta('director', $fetchedData['Director']);
        $this->movie->setMeta('writers', $fetchedData['Writer']);
        $this->movie->setMeta('actors', $fetchedData['Actors']);
        $this->movie->setMeta('movie_cover', $fetchedData['Poster']);

        /*$meta = [
            'releaseYear' => $fetchedData['Year'],
            'rating' => (float)(empty($fetchedData['Ratings']) ? 0 : (float)explode('/', $fetchedData['Ratings'][0]['Value'])[0]),
            'runtime' => (int)explode(' ', $fetchedData['Runtime'])[0],
            'genre' => $fetchedData['Genre'],
            'director' => $fetchedData['Director'],
            'writers' => $fetchedData['Writer'],
            'actors' => $fetchedData['Actors'],
            'movie_cover' => $fetchedData['Poster'],
            'diskType' => $this->movie->getMeta('diskType'),
        ];

        $meta = json_encode($meta);
        $this->movie->meta = $meta;
        */
        return $this->movie;
    }


    /**
     * Fetches data for a movie from IMDb based on title and release year.
     *
     * @return array|bool
     */
    public function fetchIMDbData(){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($this->movie->getMeta('releaseYear') != ''){
            curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?apikey='.env('OMDB_APIKEY').'&t='.str_replace(' ', '+', $this->movie->title).'&y='.$this->movie->getMeta('releaseYear').'&plot=full');
        } else{
            curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?apikey='.env('OMDB_APIKEY').'&t='.str_replace(' ', '+', $this->movie->title).'&plot=full');
        }
        $result = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $retrieved_movie = json_decode($result,true);

        if($statusCode == 200 and $retrieved_movie['Response'] == 'True') {
            return $retrieved_movie;
        } else{
            return false;
        }

    }
}
