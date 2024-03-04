<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class StatisticsCalculator
{
    public function getMostPopularHour()
    {
        return json_decode(Redis::get('statistics:mostPopularHour'));
    }

    public function getTopQueries()
    {
        return json_decode(Redis::get('statistics:topQueries'));
    }

    public function topFiveQueriesWithPercentages($data)
    {
        $queriesCount = collect($data)->groupBy('query')
            ->map(function ($entries) {
                return [
                    'count' => $entries->count(),
                    'query_details' => $entries->first(),
                ];
            })
            ->sortByDesc('count')
            ->take(5)
            ->map(function ($item) use ($data) {
                $percentage = ($item['count'] / count($data)) * 100;
                return [
                    'query' => $item['query_details'],
                    'count' => $item['count'],
                    'percentage' => $percentage,
                ];
            })
            ->toArray();

        return $queriesCount;
    }

    public function mostPopularHourOfDay($data)
    {
        $searchesByHour = collect($data)->map(function ($entry) {
            return date('H', $entry['timestamp']);
        })
        ->countBy()
        ->toArray();

        $maxSearchesHour = array_search(max($searchesByHour), $searchesByHour);

        return $maxSearchesHour;
    }
}
