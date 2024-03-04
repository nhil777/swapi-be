<?php

namespace App\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class StoreTopQueriesInRedis implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    public function handle(TopQueriesComputed $event): void
    {
        Redis::set('statistics:topQueries', json_encode([
            'created_at' => time(),
            'data' => $event->topQueries,
        ]));
    }
}
