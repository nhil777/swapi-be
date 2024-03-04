<?php

namespace App\Loggers;

use Illuminate\Support\Facades\Redis;

class QueryLog
{
    public static function log($type, $method, $query, $timestamp)
    {
        return Redis::set('logs:' . time(), json_encode([
            'type' => $type,
            'method' => $method,
            'query' => $query,
            'timestamp' => $timestamp,
        ]));
    }

    public static function getLogs()
    {
        $keys = Redis::keys('logs:*');
        $logs = [];

        foreach ($keys as $key) {
            $data = Redis::get(str_replace(env('REDIS_PREFIX'), '', $key));

            $logs[] = json_decode($data, true);
        }

        return $logs;
    }
}
