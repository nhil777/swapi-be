<?php

namespace App\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PopularHourComputed implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    public $popularHour;

    public function __construct(string $popularHour)
    {
        $this->popularHour = $popularHour;
    }
}
