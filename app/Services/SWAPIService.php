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
        return $this->makeRequest(self::TYPE_PEOPLE, resourceId: $id);
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
        return $this->makeRequest(self::TYPE_MOVIES, resourceId: $id);
    }

    /**
     * Make a request to the Star Wars API.
     *
     * @param string $type Type of resource (people or films)
     * @param string|null $query Optional query string
     * @return array|null JSON decoded response if successful, null otherwise
     */
    private function makeRequest(string $type, ?string $query = null, ?int $resourceId = null): ?array
    {
        $uri = $this->constructUri($type, $query, $resourceId);

        try {
            $response = $this->client->request('GET', $uri);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        return $this->parseResponse($response, $type, $resourceId !== null);
    }

    private function parseResponse(?object $response, string $type, bool $isDetails = false): ?array
    {
        if (!$response || $response->getStatusCode() === 404) {
            return [];
        }

        $decodedResponse = json_decode($response->getBody()->getContents(), true);
        $results = isset($decodedResponse['results']) ? $decodedResponse['results'] : $decodedResponse;

        switch ($type) {
            case self::TYPE_PEOPLE:
                return $this->processPeople($results, $isDetails);
                break;
            case self::TYPE_MOVIES:
                return $this->processMovies($results, $isDetails);
                break;
            default:
                return $results;
        }
    }

    private function processPeople(array $people, bool $details = false): array
    {
        if ($details) {
            return $this->processPerson($people);
        }

        return array_map(function ($person) {
            return $this->processPerson($person);
        }, $people);
    }

    private function processPerson(array $person): array
    {
        $person['id'] = $this->extractIdFromUrl($person['url']);

        return [
            'id' => $person['id'],
            'name' => $person['name'],
            'birth_year' => $person['birth_year'],
            'gender' => $person['gender'],
            'eye_color' => $person['eye_color'],
            'hair_color' => $person['hair_color'],
            'height' => $person['height'],
            'mass' => $person['mass'],
        ];
    }

    private function processMovies(array $movies, bool $details = false): array
    {
        if ($details) {
            return $this->processMovie($movies);
        }

        return array_map(function ($movie) {
            return $this->processMovie($movie);
        }, $movies);
    }

    private function processMovie(array $movie): array
    {
        $movie['id'] = $this->extractIdFromUrl($movie['url']);

        return [
            'id' => $movie['id'],
            'title' => $movie['title'],
            'opening_crawl' => $movie['opening_crawl'],
        ];
    }

    private function extractIdFromUrl(string $url): ?int
    {
        $parts = explode('/', rtrim($url, '/'));
        return (int) end($parts);
    }

    /**
     * Returns a URI with the specified type and query string.
     *
     * @param string $type The type of resource, e.g. 'people' or 'films'.
     * @param string|null $query An optional search query string.
     * @return string The constructed URI.
     */
    private function constructUri(string $type, ?string $query, ?int $resourceId = null): string
    {
        if ($query !== null) {
            return "{$type}?search={$query}";
        }

        if ($resourceId !== null) {
            return "{$type}/{$resourceId}";
        }

        return $type;
    }
}
