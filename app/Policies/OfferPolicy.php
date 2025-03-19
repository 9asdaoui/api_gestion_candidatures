<?php

namespace App\Policies;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OfferPolicy
{

    /**
     * Determine whether the user is Admin.
     */
    public function before(User $user, $ability): ?bool
    {
        if ($user->role->name === 'Admin') {
            return true;
        }
        
        return null;
    }
    
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Offer $offer): bool
    {
        return $user->id == $offer->user_id;
    } 
    
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Offer $offer): bool
    {
        return $user->id == $offer->user_id;
    }




}
