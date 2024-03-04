<?php

namespace App\Http\Controllers;

use App\Events\QueryLog;
use App\Services\SWAPIService;
use Illuminate\Http\Request;

class DetailsController extends Controller
{
    public function index($type, $id, SWAPIService $swapi)
    {
        if ($type === 'people') {
            $details = $swapi->getPersonDetails($id);
        } else if ($type ==='movies') {
            $details = $swapi->getMovieDetails($id);
        }

        QueryLog::dispatch($type, 'details', $id, time());

        return response()->json($details, sizeof($details) > 0 ? 200 : 404);
    }
}
