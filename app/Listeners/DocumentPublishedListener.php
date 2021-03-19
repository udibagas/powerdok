<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\DocumentPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

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
        $isPublic = $task->document()->where('is_public', true)->first();

        if ($isPublic) {
            $users = User::get();
        } else {
            $users = User::whereIn('id', [
                $task->user_id,
                ...$task->approvals()->pluck('user_id')->toArray()
            ])->when($task->document->departments, function($q) use ($task) {
                $q->whereIn('department_id', $task->document->departments);
            })->get();
        }

        Notification::send($users, new DocumentPublishedNotification($task));
    }
}
