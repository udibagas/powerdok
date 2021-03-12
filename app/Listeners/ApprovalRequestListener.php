<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\ApprovalRequestNotification;
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
        // TODO: ambil approval dengan level paling rendah, kemudian notify
        $users = User::whereIn('id', $task->approvals()->pluck('user_id')->toArray())->get();
        Notification::send($users, new ApprovalRequestNotification($task));
    }
}
