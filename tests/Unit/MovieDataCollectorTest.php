<?php

namespace Test\Unit;

use App\MovieDataCollector;
use App\Item;
use Illuminate\Support\Facades\App;
use ReflectionClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovieDataCollectorTest extends TestCase
{
    public function testMovieDataCollector_ConstructorReceivedTwoStrings_InstanceWasCreated()
    {
        //Arrange
        $title = 'title';
        $releaseYear = '1999';

        $movieDataCollector = new MovieDataCollector($title, $releaseYear);

        //Act
        $result = is_a($movieDataCollector,MovieDataCollector::class);

        //Asset
        $this->assertTrue($result);
    }

    //Integration test
    /*
    public function testMovieDataCollector_ReceivedTitleAndReleaseYearOfTheGodfather_FetchedCorrectPlotFromIMDb()
    {
        //Arrange
        $title = "The Godfather";
        $releaseYear = 1972;

        $movieDataCollector = new MovieDataCollector($title, $releaseYear);

        //Act
        $result = $movieDataCollector->fetchIMDbData();

        $expected = 'When the aging head of a famous crime family decides to transfer his position to one of his subalterns, a series of unfortunate events start happening to the family, and a war begins between all the well-known families leading to insolence, deportation, murder and revenge, and ends with the favorable successor being finally chosen.';

        //Asset
        $this->assertEquals($expected, $result['Plot']);
    }
    */
    public function testMovieDataCollector_ConstructorReceivedInt_ExceptionThrown()
    {
        //Arrange
        $title = 2;

        //Act
        try{
            $movieDataCollector = new MovieDataCollector($title);
            $result = false;
        } catch (\Exception $e){
            $result = true;
        }

        //Asset
        $this->assertTrue($result);
    }
}
