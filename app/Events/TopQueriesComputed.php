<?php

namespace App\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TopQueriesComputed implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    public $topQueries;

    public function __construct(array $topQueries)
    {
        $this->topQueries = $topQueries;
    }
}
