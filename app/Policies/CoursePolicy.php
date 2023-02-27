<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

   /**
     * Determine whether the user can approve the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseUser  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function approve(User $model)
    {
        return $model->hasRole(['super-admin','supervisor']);
    }
}
