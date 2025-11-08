<?php

namespace App\Observers;

use App\Models\User_plans;
use App\Models\User;

class UserPlansObserver
{
    /**
     * Handle the User_plans "creating" event.
     */
    public function creating(User_plans $userPlan): void
    {
        $this->fillCacheFields($userPlan);
    }

    /**
     * Handle the User_plans "updating" event.
     */
    public function updating(User_plans $userPlan): void
    {
        // Eğer user ID değiştiyse cache alanlarını güncelle
        if ($userPlan->isDirty('user')) {
            $this->fillCacheFields($userPlan);
        }
    }

    /**
     * Cache alanlarını doldur
     */
    private function fillCacheFields(User_plans $userPlan): void
    {
        if ($userPlan->user && empty($userPlan->user_name)) {
            $user = User::find($userPlan->user);
            if ($user) {
                $userPlan->user_name = $user->name;
                $userPlan->user_email = $user->email;
            }
        }
    }
}