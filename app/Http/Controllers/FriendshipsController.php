<?php

namespace App\Http\Controllers;

use App\Notifications\Friendships\AcceptRequest;
use App\Notifications\Friendships\NewRequest;
use App\User;
use Illuminate\Http\Request;

class FriendshipsController extends Controller
{
    public function check($currentUserId, $friendUserId)
    {
        $currentUser = User::findOrFail($currentUserId);
        $friendUser = User::findOrFail($friendUserId);

        if ($currentUser->isFriendWith($friendUser))
            return ['status' => 'friends'];
        if ($currentUser->hasRequestedAsFriend($friendUser))
            return ['status' => 'waiting'];
        if ($friendUser->hasRequestedAsFriend($currentUser))
            return ['status' => 'pending'];

        return ['status' => 0];
    }

    public function request($currentUserId, $friendUserId)
    {
        $currentUser = User::findOrFail($currentUserId);
        $friendUser = User::findOrFail($friendUserId);
        $currentUser->request($friendUser);

        $friendUser->notify(new NewRequest($currentUser));

        return ['status' => 'waiting'];
    }

    public function accept($currentUserId, $friendUserId)
    {
        $currentUser = User::findOrFail($currentUserId);
        $friendUser = User::findOrFail($friendUserId);
        $currentUser->accept($friendUser);

        $friendUser->notify(new AcceptRequest($currentUser));

        return ['status' => 'friends'];
    }

    public function remove($currentUserId, $friendUserId)
    {
        $currentUser = User::findOrFail($currentUserId);
        $friendUser = User::findOrFail($friendUserId);
        $currentUser->remove($friendUser);

        return ['status' => 0];
    }
}
