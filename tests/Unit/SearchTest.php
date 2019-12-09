<?php

namespace Test\Unit;

use App\MovieDataCollector;
use App\Item;
use Illuminate\Support\Facades\App;
use ReflectionClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    public function testSearch_SearchQueryTheGodfather_ReturnsTheGodFather()
    {
        //Arrange
        $title = 'The Godfather';
        $releaseYear = '1972';

        //Act


        //Asset

    }
}
