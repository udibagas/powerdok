<?php

namespace App\Listeners;

use App\Models\Task;
use App\Notifications\NewTaskNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewTaskListener
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
        $task->track($task->user_id, Task::STATUS_SUBMITTED);
        $task->assignee->notify(new NewTaskNotification($task));
    }
}
