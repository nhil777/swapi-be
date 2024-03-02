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
     * @return array|null JSON decoded response if successful, null otherwise
     */
    public function searchPeople(string $query): ?array
    {
        return $this->makeRequest(self::TYPE_PEOPLE, $query);
    }

    /**
     * Get person details from the Star Wars API.
     *
     * @param int $id The ID of the person to retrieve
     * @return array|null JSON decoded response if successful, null otherwise
     */
    public function getPersonDetails(int $id): ?array
    {
        return $this->makeRequest(self::TYPE_PEOPLE.'/'.$id);
    }

    /**
     * Search for movies in the Star Wars API.
     *
     * @param string $query Search query string
     * @return array|null JSON decoded response if successful, null otherwise
     */
    public function searchMovies(string $query): ?array
    {
        return $this->makeRequest(self::TYPE_MOVIES, $query);
    }

    /**
     * Get movie details from the Star Wars API.
     *
     * @param int $id The ID of the movie to retrieve
     * @return array|null JSON decoded response if successful, null otherwise
     */
    public function getMovieDetails(int $id): ?array
    {
        return $this->makeRequest(self::TYPE_MOVIES.'/'.$id);
    }

    /**
     * Make a request to the Star Wars API.
     *
     * @param string $type Type of resource (people or films)
     * @param string|null $query Optional query string
     * @return array|null JSON decoded response if successful, null otherwise
     */
    private function makeRequest(string $type, ?string $query = null): ?array
    {
        $uri = $this->constructUri($type, $query);

        try {
            $response = $this->client->request('GET', $uri);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        return $this->parseResponse($response);
    }

    /**
     * Returns a URI with the specified type and query string.
     *
     * @param string $type The type of resource, e.g. 'people' or 'films'.
     * @param string|null $query An optional search query string.
     * @return string The constructed URI.
     */
    private function constructUri(string $type, ?string $query): string
    {
        if ($query !== null) {
            return "{$type}?search={$query}";
        }

        return $type;
    }

    private function parseResponse(object $response): ?array
    {
        if ($response && $response->getBody()) {
            $decodedResponse = json_decode($response->getBody()->getContents(), true);

            return isset($decodedResponse['results']) ? $decodedResponse['results'] : $decodedResponse;
        }

        return null;
    }
}
