<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class JokePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param \App\User $user
     * @return bool
     */
    public function update(\App\User $user)
    {
//        return $user->id === $post->user_id;
        return $user->isSuperAdmin();
    }

    /**
     * Determine if the given post can be store by the user.
     *
     * @param \App\User $user
     * @return bool
     */
    public function store(\App\User $user)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine if the given post can be index by the user.
     *
     * @param \App\User $user
     * @return bool
     */
    public function index(\App\User $user)
    {
        return $user->isSuperAdmin();
    }
}
