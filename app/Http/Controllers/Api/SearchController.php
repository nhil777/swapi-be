<?php

namespace App\Http\Controllers\Api;

use App\Events\QueryLog as QueryLogEvent;
use App\Http\Controllers\Controller;
use App\Services\SWAPIService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, $type, SWAPIService $swapi)
    {
        $query = $request->get('query');

        if ($type === 'people') {
            $searchResults = $swapi->searchPeople($query);
        } else if ($type === 'movies') {
            $searchResults = $swapi->searchMovies($query);
        }

        QueryLogEvent::dispatch($type, 'search', $query, time());

        return response()->json($searchResults);
    }
}
