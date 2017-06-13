<?php

namespace App\Traits;

use App\Friendship;
use App\User;

/**
* Friendable Trait
*/
trait Friendable {
    public function addFriend(User $user)
    {
        $friendship = Friendship::create([
            'requester_id' => $this->id,
            'requested_id' => $user->id,
        ]);
    }

    public function hasRequestedAsFriend(User $user)
    {
        $friendship = Friendship::where([
            'requester_id' => $this->id,
            'requested_id' => $user->id,
        ])->first();

        return !! $friendship;
    }
}