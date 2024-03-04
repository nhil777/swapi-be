<?php

namespace App\Jobs;

use App\Events\PopularHourComputed;
use App\Events\TopQueriesComputed;
use App\Loggers\QueryLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ComputeStatistics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $calculator;

    public function __construct()
    {
        $this->calculator = new \App\Services\StatisticsCalculator();
    }

    public function handle(): void
    {
        $logs = QueryLog::getLogs();

        $topQueries = $this->calculator->topFiveQueriesWithPercentages($logs);
        $popularHour = $this->calculator->mostPopularHourOfDay($logs);

        event(new TopQueriesComputed($topQueries));
        event(new PopularHourComputed($popularHour));
    }
}
