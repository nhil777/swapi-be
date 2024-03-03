<?php

namespace Tests\Unit;

use App\Services\SWAPIService;
use PHPUnit\Framework\TestCase;

class SWAPIServiceTest extends TestCase
{
    private $swapi;

    protected function setUp(): void
    {
        parent::setUp();

        $this->swapi = new SWAPIService();
    }

    public function test_search_people_method()
    {
        $searchResults = $this->swapi->searchPeople('Yoda');

        $this->assertNotEmpty($searchResults);

        $this->assertDetailsResult([
            'id',
            'name',
            'birth_year',
            'gender',
            'eye_color',
            'hair_color',
            'height',
            'mass',
        ], $searchResults[0]);
    }

    public function test_get_person_details_method()
    {
        $personDetails = $this->swapi->getPersonDetails(10);

        $this->assertNotEmpty($personDetails);

        $this->assertDetailsResult([
            'id',
            'name',
            'birth_year',
            'gender',
            'eye_color',
            'hair_color',
            'height',
            'mass',
        ], $personDetails);
    }

    public function test_get_unexistent_person_details_method()
    {
        $personDetails = $this->swapi->getMovieDetails(999);

        $this->assertEmpty($personDetails);
    }

    public function test_search_movies_method()
    {
        $searchResults = $this->swapi->searchMovies('Attack of the Clones');

        $this->assertNotEmpty($searchResults);

        $this->assertDetailsResult(['title', 'opening_crawl', 'id'], $searchResults[0]);
    }

    public function test_get_movie_details_method()
    {
        $movieDetails = $this->swapi->getMovieDetails(5);

        $this->assertNotEmpty($movieDetails);

        $this->assertDetailsResult(['title', 'opening_crawl', 'id'], $movieDetails);
    }

    public function test_get_unexistent_movie_details_method()
    {
        $movieDetails = $this->swapi->getMovieDetails(999);

        $this->assertEmpty($movieDetails);
    }

    private function assertDetailsResult(array $expectedKeys, array $resultArray)
    {
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $resultArray);
        }
    }
}
