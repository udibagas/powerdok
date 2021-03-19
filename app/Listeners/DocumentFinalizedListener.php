<?php

namespace App\Listeners;

use App\Notifications\DocumentFinalizedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DocumentFinalizedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $task = $event->task;

        $task->user->notify(new DocumentFinalizedNotification($task));
    }
}
