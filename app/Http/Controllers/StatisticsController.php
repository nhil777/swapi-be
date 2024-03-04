<?php

namespace App\Http\Controllers;

use App\Services\StatisticsCalculator;

class StatisticsController extends Controller
{
    public function statistics(StatisticsCalculator $calculator) {
        return response()->json([
            'popularHour' => $calculator->getMostPopularHour(),
            'topQueries' => $calculator->getTopQueries(),
        ]);
    }
}
