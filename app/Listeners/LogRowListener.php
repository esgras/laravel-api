<?php

namespace App\Listeners;

use App\Events\LogRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Queue\InteractsWithQueue;

class LogRowListener
{
    private $logFile;
    private Filesystem $fs;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logFile = storage_path('logs/events.txt');
        $this->fs = new Filesystem;
    }

    /**
     * Handle the event.
     *
     * @param  LogRow  $event
     * @return void
     */
    public function handle(LogRow $event)
    {
        $row = $event->getRow();
        $this->fs->append($this->logFile, $row . PHP_EOL);
    }
}
