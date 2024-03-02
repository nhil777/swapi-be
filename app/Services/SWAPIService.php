<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SWAPIService
{
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

    // TODO: validate $type (people or movies only)
    // TODO: validate $option -- same as $type

    private function makeRequest (string $option, string $query = null) {
        $uri = $query ? $option."?{$query}" : $option;

        try {
            $response = $this->client->request('GET', $uri);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        return json_decode($response->getBody()->getContents());
    }

    public function search(string $option, string $query)
    {
        if ($option === 'people') {
            return $this->searchPeople($query);
        } else {
            return $this->searchMovies($query);
        }
    }

    private function searchPeople(string $query)
    {
        return $this->makeRequest('people', $query);
    }

    private function searchMovies(string $query)
    {
        return $this->makeRequest('movies', $query);
    }
}