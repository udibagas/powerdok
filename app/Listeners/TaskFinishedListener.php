<?php

namespace App\Listeners;

use App\Models\Task;
use App\Notifications\TaskFinishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaskFinishedListener
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
        $task->track($task->assignee_id, Task::STATUS_FINISHED);
        $task->user->notify(new TaskFinishedNotification($task));
    }
}
