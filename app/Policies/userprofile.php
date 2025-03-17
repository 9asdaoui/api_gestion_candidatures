<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class userprofile
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, user $model): bool
    {
        return $user->id === $model->id;
    }

}
