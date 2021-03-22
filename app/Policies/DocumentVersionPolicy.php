<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\DocumentVersion;
use App\Models\User;
use App\Models\AccessControl;

class DocumentVersionPolicy
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
        return AccessControl::check($user, DocumentVersion::class, 'viewAny');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DocumentVersion  $documentVersion
     * @return mixed
     */
    public function view(User $user, DocumentVersion $documentVersion)
    {
        return AccessControl::check($user, DocumentVersion::class, 'view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return AccessControl::check($user, DocumentVersion::class, 'create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DocumentVersion  $documentVersion
     * @return mixed
     */
    public function update(User $user, DocumentVersion $documentVersion)
    {
        return AccessControl::check($user, DocumentVersion::class, 'update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DocumentVersion  $documentVersion
     * @return mixed
     */
    public function delete(User $user, DocumentVersion $documentVersion)
    {
        return AccessControl::check($user, DocumentVersion::class, 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DocumentVersion  $documentVersion
     * @return mixed
     */
    public function restore(User $user, DocumentVersion $documentVersion)
    {
        return AccessControl::check($user, DocumentVersion::class, 'restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DocumentVersion  $documentVersion
     * @return mixed
     */
    public function forceDelete(User $user, DocumentVersion $documentVersion)
    {
        return AccessControl::check($user, DocumentVersion::class, 'forceDelete');
    }
}
