<?php

namespace App\Listeners;

use App\Notifications\NewTaskNotitifiation;
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

        foreach ($task->assignees as $user) {
            $user->notify(new NewTaskNotitifiation($task));
        }
    }
}
