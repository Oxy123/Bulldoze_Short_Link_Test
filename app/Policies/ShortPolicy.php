<?php

namespace App\Policies;

use App\Models\Short;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShortPolicy
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

    public function create(User $user){
//        $shorts = User::withCount("shorts")->find($user->id);
//        dd($shorts);
        return false;
    }
}
