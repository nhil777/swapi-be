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

        return response()->json($type);
    }
}
