<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\ApprovalRequestNotification;
use App\Notifications\TaskApprovalCompletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class ApprovalRequestListener
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
        $a = $task->approvals()->whereNull('status')->orderBy('level', 'asc')->first();

        if ($a) {
            $userList = $task->approvals()->whereLevel($a->level)->pluck('user_id')->toArray();
            $users = User::whereIn('id', $userList)->get();
            Notification::send($users, new ApprovalRequestNotification($task));
        } else {
            $task->assignee->notify(new TaskApprovalCompletedNotification($task));
        }
    }
}
