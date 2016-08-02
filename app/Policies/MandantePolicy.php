<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class MandantePolicy
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

    public function before(\App\User $user, $ability)
    {
        return $user->isSuperAdmin();
    }
}
