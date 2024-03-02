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

    private function assertSearchResults(array $expectedKeys)
    {
        $keysToCheck = ['count', 'next', 'previous', 'results'];
        foreach ($keysToCheck as $key) {
            $this->assertArrayHasKey($key, (array)$this->searchResults);
        }

        $this->assertNotEmpty($this->searchResults->results);

        $resultArray = (array) $this->searchResults->results[0];
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $resultArray);
        }
    }
}
