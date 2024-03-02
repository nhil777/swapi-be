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
            'name',
            'height',
            'mass',
            'hair_color',
            'skin_color',
            'eye_color',
            'birth_year',
            'gender',
            'homeworld',
            'films',
            'species',
            'vehicles',
            'starships',
            'created',
            'edited',
            'url',
        ], $searchResults[0]);
    }

    public function test_get_person_details_method()
    {
        $personDetails = $this->swapi->getPersonDetails(10);

        $this->assertNotEmpty($personDetails);

        $this->assertDetailsResult([
            'name',
            'height',
            'mass',
            'hair_color',
            'skin_color',
            'eye_color',
            'birth_year',
            'gender',
            'homeworld',
            'films',
            'species',
            'vehicles',
            'starships',
            'created',
            'edited',
            'url',
        ], $personDetails);
    }

    public function test_get_unexistent_person_details_method()
    {
        $personDetails = $this->swapi->getMovieDetails(999);

        $this->assertNotEmpty($personDetails);
        $this->assertArrayHasKey('detail', $personDetails);
        $this->assertEquals('Not found', $personDetails['detail']);
    }

    public function test_search_movies_method()
    {
        $searchResults = $this->swapi->searchMovies('Attack of the Clones');

        $this->assertNotEmpty($searchResults);

        $this->assertDetailsResult([
            'title',
            'episode_id',
            'opening_crawl',
            'director',
            'producer',
            'release_date',
            'characters',
            'planets',
            'starships',
            'vehicles',
            'species',
            'created',
            'edited',
            'url',
        ], $searchResults[0]);
    }

    public function test_get_movie_details_method()
    {
        $movieDetails = $this->swapi->getMovieDetails(5);

        $this->assertNotEmpty($movieDetails);

        $this->assertDetailsResult([
            'title',
            'episode_id',
            'opening_crawl',
            'director',
            'producer',
            'release_date',
            'characters',
            'planets',
            'starships',
            'vehicles',
            'species',
            'created',
            'edited',
            'url',
        ], $movieDetails);
    }

    public function test_get_unexistent_movie_details_method()
    {
        $movieDetails = $this->swapi->getMovieDetails(999);

        $this->assertNotEmpty($movieDetails);
        $this->assertArrayHasKey('detail', $movieDetails);
        $this->assertEquals('Not found', $movieDetails['detail']);
    }

    private function assertDetailsResult(array $expectedKeys, array $resultArray)
    {
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $resultArray);
        }
    }
}
