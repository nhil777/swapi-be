<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class StorePopularHourInRedis
{
    use Dispatchable, SerializesModels;

    public function handle(PopularHourComputed $event): void
    {
        Redis::set('statistics:mostPopularHour', $event->popularHour);
    }
}
