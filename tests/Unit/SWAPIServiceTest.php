<?php

namespace Tests\Unit;

use App\Services\SWAPIService;
use PHPUnit\Framework\TestCase;

class SWAPIServiceTest extends TestCase
{
    private $swapi;
    private $searchResults;

    protected function setUp(): void
    {
        parent::setUp();

        $this->swapi = new SWAPIService();
    }

    public function test_search_people_method()
    {
        $this->searchResults = $this->swapi->searchPeople('Yoda');
        $this->assertSearchResults([
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
        ]);
    }

    public function test_get_person_details_method()
    {
        $personDetails = (array) $this->swapi->getPersonDetails(10);

        $this->assertSearchResult([
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
        $personDetails = (array) $this->swapi->getMovieDetails(999);

        $this->assertArrayHasKey('detail', $personDetails);
        $this->assertEquals('Not found', $personDetails['detail']);
    }

    public function test_search_movies_method()
    {
        $this->searchResults = $this->swapi->searchMovies('Attack of the Clones');
        $this->assertSearchResults([
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
        ]);
    }

    public function test_get_movie_details_method()
    {
        $movieDetails = (array) $this->swapi->getMovieDetails(5);

        $this->assertSearchResult([
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
        $movieDetails = (array) $this->swapi->getMovieDetails(999);

        $this->assertArrayHasKey('detail', $movieDetails);
        $this->assertEquals('Not found', $movieDetails['detail']);
    }

    private function assertSearchResults(array $expectedKeys)
    {
        $keysToCheck = ['count', 'next', 'previous', 'results'];
        foreach ($keysToCheck as $key) {
            $this->assertArrayHasKey($key, (array)$this->searchResults);
        }

        $this->assertNotEmpty($this->searchResults->results);

        $resultArray = (array) $this->searchResults->results[0];

        $this->assertSearchResult($expectedKeys, $resultArray);
    }

    private function assertSearchResult(array $expectedKeys, array $resultArray)
    {
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $resultArray);
        }
    }
}
