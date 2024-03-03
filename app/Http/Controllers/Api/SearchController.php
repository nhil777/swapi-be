<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SWAPIService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request, $type, SWAPIService $swapi)
    {
        $query = $request->get('query');

        if ($type === 'people') {
            $searchResults = $swapi->searchPeople($query);
        } else if ($type === 'movies') {
            $searchResults = $swapi->searchMovies($query);
        }

        return response()->json($searchResults);
    }

    public function details($type, $id, SWAPIService $swapi)
    {
        if ($type === 'people') {
            $details = $swapi->getPersonDetails($id);
        } else if ($type ==='movies') {
            $details = $swapi->getMovieDetails($id);
        }

        return response()->json($details, sizeof($details) > 0 ? 200 : 404);
    }
}
