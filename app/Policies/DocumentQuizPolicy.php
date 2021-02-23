<?php

namespace App\Policies;

use App\Models\AccessControl;
use App\Models\DocumentQuiz;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentQuizPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return AccessControl::check($user, DocumentQuiz::class, 'viewAny');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DocumentQuiz  $documentQuiz
     * @return mixed
     */
    public function view(User $user, DocumentQuiz $documentQuiz)
    {
        return AccessControl::check($user, DocumentQuiz::class, 'view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return AccessControl::check($user, DocumentQuiz::class, 'create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DocumentQuiz  $documentQuiz
     * @return mixed
     */
    public function update(User $user, DocumentQuiz $documentQuiz)
    {
        return AccessControl::check($user, DocumentQuiz::class, 'update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DocumentQuiz  $documentQuiz
     * @return mixed
     */
    public function delete(User $user, DocumentQuiz $documentQuiz)
    {
        return AccessControl::check($user, DocumentQuiz::class, 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DocumentQuiz  $documentQuiz
     * @return mixed
     */
    public function restore(User $user, DocumentQuiz $documentQuiz)
    {
        return AccessControl::check($user, DocumentQuiz::class, 'restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DocumentQuiz  $documentQuiz
     * @return mixed
     */
    public function forceDelete(User $user, DocumentQuiz $documentQuiz)
    {
        return AccessControl::check($user, DocumentQuiz::class, 'forceDelete');
    }
}
