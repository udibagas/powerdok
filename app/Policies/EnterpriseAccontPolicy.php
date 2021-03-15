<?php

namespace App\Policies;

use App\Models\AccessControl;
use App\Models\EnterpriseAccont;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnterpriseAccontPolicy
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
        return AccessControl::check($user, EnterpriseAccont::class, 'viewAny');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EnterpriseAccont  $enterpriseAccont
     * @return mixed
     */
    public function view(User $user, EnterpriseAccont $enterpriseAccont)
    {
        return AccessControl::check($user, EnterpriseAccont::class, 'view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return AccessControl::check($user, EnterpriseAccont::class, 'create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EnterpriseAccont  $enterpriseAccont
     * @return mixed
     */
    public function update(User $user, EnterpriseAccont $enterpriseAccont)
    {
        return AccessControl::check($user, EnterpriseAccont::class, 'update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EnterpriseAccont  $enterpriseAccont
     * @return mixed
     */
    public function delete(User $user, EnterpriseAccont $enterpriseAccont)
    {
        return AccessControl::check($user, EnterpriseAccont::class, 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EnterpriseAccont  $enterpriseAccont
     * @return mixed
     */
    public function restore(User $user, EnterpriseAccont $enterpriseAccont)
    {
        return AccessControl::check($user, EnterpriseAccont::class, 'restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EnterpriseAccont  $enterpriseAccont
     * @return mixed
     */
    public function forceDelete(User $user, EnterpriseAccont $enterpriseAccont)
    {
        return AccessControl::check($user, EnterpriseAccont::class, 'forceDelete');
    }
}
