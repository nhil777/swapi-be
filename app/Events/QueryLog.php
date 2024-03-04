<?php

namespace App\Events;

use App\Loggers\QueryLog as LoggersQueryLog;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QueryLog implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct($type, $method, $query, $timestamp)
    {
        LoggersQueryLog::log($type, $method, $query, $timestamp);
    }
}
