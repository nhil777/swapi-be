<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    public function test_search_endpoint_type_people()
    {
        $response = $this->get('api/search/people?query=Luke');

        $response->assertStatus(200);
    }

    public function test_details_endpoint_type_people()
    {
        $response = $this->get('api/details/people/20');

        $response->assertStatus(200);
    }

    public function test_unexistent_details_endpoint_type_people()
    {
        $response = $this->get('api/details/people/999');

        $response->assertStatus(404);
    }

    public function test_search_endpoint_type_movies()
    {
        $response = $this->get('api/search/movies?query=Star%20Wars');

        $response->assertStatus(200);
    }

    public function test_details_endpoint_type_movies()
    {
        $response = $this->get('api/details/movies/2');

        $response->assertStatus(200);
    }

    public function test_unexistent_details_endpoint_type_movies()
    {
        $response = $this->get('api/details/movies/999');

        $response->assertStatus(404);
    }
}
