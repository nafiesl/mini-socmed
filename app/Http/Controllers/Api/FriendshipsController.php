<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
            return response()->json(['status' => 'friends'], 200);
        if ($currentUser->hasRequestedAsFriend($friendUser))
            return response()->json(['status' => 'waiting'], 200);
        if ($friendUser->hasRequestedAsFriend($currentUser))
            return response()->json(['status' => 'pending'], 200);

        return response()->json(['status' => 0], 200);
    }

    public function request($currentUserId, $friendUserId)
    {
        $currentUser = User::findOrFail($currentUserId);
        $friendUser = User::findOrFail($friendUserId);

        if ($friendUser->hasRequestedAsFriend($currentUser)) {
            $currentUser->accept($friendUser);
            $friendUser->notify(new AcceptRequest($currentUser));
            return ['status' => 'friends'];
        }

        $currentUser->request($friendUser);

        $friendUser->notify(new NewRequest($currentUser));

        return response()->json(['status' => 'waiting'], 201);
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
