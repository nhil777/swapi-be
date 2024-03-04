<?php

namespace App\Http\Controllers\Api;

use App\Events\QueryLog as QueryLogEvent;
use App\Http\Controllers\Controller;
use App\Loggers\QueryLog;
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

        QueryLogEvent::dispatch($type, 'search', $query, time());

        return response()->json($searchResults);
    }

    public function details($type, $id, SWAPIService $swapi)
    {
        if ($type === 'people') {
            $details = $swapi->getPersonDetails($id);
        } else if ($type ==='movies') {
            $details = $swapi->getMovieDetails($id);
        }

        QueryLogEvent::dispatch($type, 'details', $id, time());

        return response()->json($details, sizeof($details) > 0 ? 200 : 404);
    }

    public function getLogs()
    {
        return QueryLog::getLogs();
    }
}
