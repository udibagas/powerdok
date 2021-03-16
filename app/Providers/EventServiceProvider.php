<?php

namespace App\Providers;

use App\Events\ApprovalRequestEvent;
use App\Events\NewCommentEvent;
use App\Events\NewTaskEvent;
use App\Events\TaskApprovedEvent;
use App\Events\TaskFinishedEvent;
use App\Listeners\ApprovalRequestListener;
use App\Listeners\NewCommentListener;
use App\Listeners\NewTaskListener;
use App\Listeners\TaskApprovedListener;
use App\Listeners\TaskFinishedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [SendEmailVerificationNotification::class],
        NewTaskEvent::class => [NewTaskListener::class],
        NewCommentEvent::class => [NewCommentListener::class],
        TaskFinishedEvent::class => [TaskFinishedListener::class],
        ApprovalRequestEvent::class => [ApprovalRequestListener::class],
        TaskApprovedEvent::class => [TaskApprovedListener::class, ApprovalRequestListener::class]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
