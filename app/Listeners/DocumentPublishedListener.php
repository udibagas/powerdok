<?php

namespace App\Listeners;

use App\Notifications\DocumentPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DocumentPublishedListener
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
        // $isPublic = $task->document()->where('is_public', true)->get();
        $task->user->notify(new DocumentPublishedNotification($task));

        // if ($isPublic)
        // {
        //     $task->user->notify(new DocumentPublishedNotification($task));
        // }
        // else notify ke approver, ke task owner, assignee, ke user di department yg dipilih
    }
}
