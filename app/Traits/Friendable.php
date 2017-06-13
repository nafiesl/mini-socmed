<?php

namespace App\Traits;

use App\Friendship;
use App\User;

/**
* Friendable Trait
*/
trait Friendable
{
    public function request(User $user)
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

    public function accept(User $user)
    {
        $friendship = Friendship::where([
            'requester_id' => $user->id,
            'requested_id' => $this->id,
        ])->first();

        if ($friendship) {
            $friendship->approved = 1;
            $friendship->save();

            return 1;
        }

        return false;
    }

    public function isFriendWith(User $user)
    {
        $friendship = Friendship::where([
            'requester_id' => $this->id,
            'requested_id' => $user->id,
            'approved' => 1,
        ])->first();

        if ($friendship) {
            return !! $friendship;
        }

        $friendship = Friendship::where([
            'requester_id' => $user->id,
            'requested_id' => $this->id,
            'approved' => 1,
        ])->first();

        return !! $friendship;
    }

    public function pendingFriendRequests()
    {
        $requesterIds = Friendship::where([
            'requested_id' => $this->id,
            'approved' => 0,
        ])->pluck('requester_id')->all();

        $requesters = User::whereIn('id', $requesterIds)->get();

        return $requesters;
    }

    public function sentFriendRequests()
    {
        $requestedUserIds = Friendship::where([
            'requester_id' => $this->id,
            'approved' => 0,
        ])->pluck('requested_id')->all();

        $requestedUsers = User::whereIn('id', $requestedUserIds)->get();

        return $requestedUsers;
    }

    public function friends()
    {
        $requestedFriendIds = Friendship::where([
            'requester_id' => $this->id,
            'approved' => 1,
        ])->pluck('requested_id')->all();

        $approvedFriendIds = Friendship::where([
            'requested_id' => $this->id,
            'approved' => 1,
        ])->pluck('requester_id')->all();

        $friendIds = array_merge($requestedFriendIds, $approvedFriendIds);
        return User::whereIn('id', $friendIds)->get();
    }

    public function remove(User $user)
    {
        $friendship = Friendship::where([
            'requester_id' => $this->id,
            'requested_id' => $user->id,
            'approved' => 1,
        ])->first();

        if ($friendship) {
            $friendship->delete();
            return true;
        }

        $friendship = Friendship::where([
            'requester_id' => $user->id,
            'requested_id' => $this->id,
            'approved' => 1,
        ])->first();

        if ($friendship) {
            $friendship->delete();
            return true;
        }

        return false;
    }
}