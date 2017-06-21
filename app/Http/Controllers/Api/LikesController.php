<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function like(Post $post)
    {
        $user = auth()->user();

        if ($user->liked($post) == true) {
            $user->unlike($post);
            return response()->json(['id' => $user->id, 'name' => $user->name], 204);
        }

        $user->like($post);
        return response()->json(['id' => $user->id, 'name' => $user->name], 201);
    }
}
