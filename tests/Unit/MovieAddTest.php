<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovieAddTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function fetchDataForTheGodfatherFromIMDbSuccessfullyWithTitleAndReleaseYear()
    {
        $title = "The Godfather";
        $releaseYear = 1972;



        $this->assertTrue(true);
    }
}