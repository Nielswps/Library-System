<?php


namespace App;

class MovieDataCollector
{
    private $movieTitle;
    private $movieReleaseYear;
    private $movieDiskType;

    /**
     * MovieDataCollector constructor.
     * @param string $title
     * @param string $releaseYear
     * @param string $diskType
     */
    public function __construct(string $title, string $releaseYear = '', string $diskType = 'DVD')
    {
        $this->movieTitle = $title;
        $this->movieReleaseYear = $releaseYear;
        $this->movieDiskType = $diskType;
    }

    /**
     * @return Item|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getMovie(){
        $movie = new Item();
        $movie->user_id = auth()->user()->id;
        $movie->type = 'movie';

        $fetchedData = $this->fetchIMDbData();

        if ($fetchedData == false) {
            $movie->type = 'false';
            return $movie;
        }

        $movie->title = $fetchedData['Title'];
        $movie->description = $fetchedData['Plot'];

        $meta = array(
            'releaseYear' => $fetchedData['Year'],
            'rating' => (float)(empty($fetchedData['Ratings']) ? 0 : (float)explode('/', $fetchedData['Ratings'][0]['Value'])[0]),
            'runtime' => (int)explode(' ', $fetchedData['Runtime'])[0],
            'genre' => $fetchedData['Genre'],
            'director' => $fetchedData['Director'],
            'writers' => $fetchedData['Writer'],
            'actors' => $fetchedData['Actors'],
            'movie_cover' => $fetchedData['Poster'],
            'diskType' => $this->movieDiskType,
            'fetched' => true
        );

        $meta = json_encode($meta);
        $movie->meta = $meta;

        return $movie;
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
        if($this->movieReleaseYear != ''){
            curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?apikey='.env('OMDB_APIKEY').'&t='.str_replace(' ', '+', $this->movieTitle).'&y='.$this->movieReleaseYear.'&plot=full');
        } else{
            curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?apikey='.env('OMDB_APIKEY').'&t='.str_replace(' ', '+', $this->movieTitle).'&plot=full');
        }
        $result = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $retrieved_movie = json_decode($result,true);

        if($statusCode == 200 and $retrieved_movie['Response'] == 'True' and $retrieved_movie['Title'] == $this->movieTitle) {
            return array_merge($retrieved_movie);
        } else{
            return false;
        }

    }
}
