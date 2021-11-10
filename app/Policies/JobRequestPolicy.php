<?php

namespace App\Policies;

use App\Models\JobRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobRequest  $jobRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, JobRequest $jobRequest)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $roles = $user->roles()->pluck('type')->toArray();
        $status = array_uintersect($roles, [Role::ROLE_HR_MANAGER, Role::ROLE_OTHER_MANAGER ], "strcmp");
        if(!empty($status)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobRequest  $jobRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, JobRequest $jobRequest)
    {

        $roles = $user->roles;
        if( $roles->contains('type', Role::ROLE_HR_MANAGER)){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobRequest  $jobRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, JobRequest $jobRequest)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobRequest  $jobRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, JobRequest $jobRequest)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobRequest  $jobRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, JobRequest $jobRequest)
    {
        //
    }
}
