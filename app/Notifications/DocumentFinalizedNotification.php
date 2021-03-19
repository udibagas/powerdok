<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentFinalizedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $task = $this->task;

        return (new MailMessage)
                    ->subject("{$task->document->title} has been finalized by {$task->assignee->name}")
                    ->greeting("Hello {$notifiable->name}!")
                    ->markdown('mail.task.document-finalized', ['task' => $task]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $task = $this->task;

        return [
            'type' => 'task',
            'title' => "Document Finalized",
            'text' => "{$task->document->title} has been finalized by {$task->assignee->name}",
            'url' => '/',
        ];
    }
}
