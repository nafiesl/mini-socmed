<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userIds = $user->friends()->pluck('id');
        $userIds[] = $user->id;

        return Post::whereIn('user_id', $userIds)->get();
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $newPost = new Post(['content' => $request->get('content')]);
        $post = $user->posts()->save($newPost);
        $post->load('user');

        return response()->json($post->toArray(), 201);
    }
}
