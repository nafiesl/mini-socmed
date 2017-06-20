<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $with = ['user'];
    protected $appends = ['published'];
    protected $fillable = ['content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPublishedAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
