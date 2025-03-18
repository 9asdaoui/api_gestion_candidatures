<?php

namespace App\Policies;

use App\Models\User;
use App\Models\offer;
use Illuminate\Auth\Access\Response;

class OfferPolicy
{
  /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, offer $offer): bool
    {
        
    }
}
