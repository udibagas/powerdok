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
            ...$task->assignees()->pluck('user_id')->toArray(),
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
        return $task->user_id == $user->id;
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
        return $task->user_id == $user->id;
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
        return $task->user_id == $user->id;
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
        return $this->view($user, $task);
    }
}
