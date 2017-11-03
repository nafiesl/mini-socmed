<?php

namespace App;

use App\Traits\Friendable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'likes');
    }

    public function like(Post $post)
    {
        return $this->likedPosts()->attach($post);
    }

    public function unlike(Post $post)
    {
        return $this->likedPosts()->detach($post);
    }

    public function liked(Post $post)
    {
        if (in_array($post->id, $this->likedPosts->pluck('id')->all()))
            return true;

        return false;
    }
}
