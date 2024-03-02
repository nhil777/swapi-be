<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    public function test_search_endpoint()
    {
        $response = $this->get('api/search/people');

        $response->assertStatus(200);
    }

    public function test_search_endpoint_type_movies()
    {
        $response = $this->get('api/search/movies');

        $response->assertStatus(200);
    }
}
