<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use function PHPUnit\Framework\returnSelf;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function view(User $user, Task $task)
    {
        return in_array($user->id, [
            $task->user_id,
            $task->assignee_id,
            ...$task->approvals()->pluck('user_id')->toArray()
        ]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        return $task->user_id == $user->id && !$task->is_closed;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function delete(User $user, Task $task)
    {
        return $task->user_id == $user->id && !$task->is_closed;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function restore(User $user, Task $task)
    {
        return $task->user_id == $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function forceDelete(User $user, Task $task)
    {
        return $task->user_id == $user->id && !$task->is_closed;
    }

    public function approve(User $user, Task $task)
    {
        return $task->approvals()
            ->where('user_id', $user->id)
            ->whereNull('status')
            ->first();
    }

    public function comment(User $user, Task $task)
    {
        return $this->view($user, $task) && in_array($task->status, [Task::STATUS_SUBMITTED, Task::STATUS_ON_PROGRESS, Task::STATUS_FINISHED]);
    }

    public function startExam(User $user, Task $task)
    {
        return $user->id == $task->assignee_id && $task->exam->time_finished == null;
    }

    public function finishExam(User $user, Task $task)
    {
        // TODO: pastikan soal sudah terjawab semua
        return $user->id == $task->assignee_id && $task->exam->time_finished == null;
    }


    public function submitExam(User $user, Task $task)
    {
        return ($user->id == $task->assignee_id) && in_array($task->status, [Task::STATUS_SUBMITTED, Task::STATUS_ON_PROGRESS]);
    }

    public function updateDocument(User $user, Task $task)
    {
        return ($user->id == $task->assignee_id) && in_array($task->status, [Task::STATUS_SUBMITTED, Task::STATUS_ON_PROGRESS]);
    }

    public function attest(User $user, Task $task)
    {
        return $user->id == $task->assignee_id &&
            $task->type == Task::TYPE_ATESTATION &&
            !in_array($task->status, [Task::STATUS_FINISHED, Task::STATUS_CLOSED, Task::STATUS_VOID]);
    }

    public function close(User $user, Task $task)
    {
        return $user->id == $task->user_id && $task->status == Task::STATUS_FINISHED;
    }

    public function void(User $user, Task $task)
    {
        return $user->id == $task->user_id && ($task->status == Task::STATUS_SUBMITTED || $task->status == Task::STATUS_ON_PROGRESS);
    }
}
