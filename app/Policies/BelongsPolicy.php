<?php

namespace App\Policies;

use App\Eloquents\Circle;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class BelongsPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function __invoke(Circle $circle)
    {
        $result = $circle->users->where('id', Auth::id())->first();
        
        if (empty($result)) {
            return false;
        }
        return true;
    }
}
