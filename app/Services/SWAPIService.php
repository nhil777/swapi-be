<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SWAPIService
{
    const TYPE_PEOPLE = 'people';
    const TYPE_MOVIES = 'films';

    private $baseUrl = 'https://swapi.dev/api/';
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'User-Agent' => 'swapi-php-yanbeindevatgmailcom',
            ]
        ]);
    }

    /**
     * Search for people in the Star Wars API.
     *
     * @param string $query Search query string
     * @return mixed|null JSON decoded response if successful, null otherwise
     */
    public function searchPeople(string $query): ?object
    {
        return $this->makeRequest(self::TYPE_PEOPLE, $query);
    }

    /**
     * Get person details from the Star Wars API.
     *
     * @param int $id The ID of the person to retrieve
     * @return object|null JSON decoded response if successful, null otherwise
     */
    public function getPersonDetails(int $id): ?object
    {
        return $this->makeRequest(self::TYPE_PEOPLE.'/'.$id);
    }

    /**
     * Search for movies in the Star Wars API.
     *
     * @param string $query Search query string
     * @return mixed|null JSON decoded response if successful, null otherwise
     */
    public function searchMovies(string $query): ?object
    {
        return $this->makeRequest(self::TYPE_MOVIES, $query);
    }

    /**
     * Get movie details from the Star Wars API.
     *
     * @param int $id The ID of the movie to retrieve
     * @return object|null JSON decoded response if successful, null otherwise
     */
    public function getMovieDetails(int $id): ?object
    {
        return $this->makeRequest(self::TYPE_MOVIES.'/'.$id);
    }

    /**
     * Make a request to the Star Wars API.
     *
     * @param string $type Type of resource (people or films)
     * @param string|null $query Optional query string
     * @return mixed|null JSON decoded response if successful, null otherwise
     */
    private function makeRequest(string $type, ?string $query = null): ?object
    {
        // Construct the URI
        $uri = $query ? $type.'?search='.urlencode($query) : $type;

        try {
            $response = $this->client->request('GET', $uri);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        return $response ? json_decode($response->getBody()->getContents()) : null;
    }
}
