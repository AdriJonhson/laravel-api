<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
