<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected  $fillable = ['post_id', 'user_id', 'title', 'content'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function post()
    {
        return $this->hasOne(Post::class);
    }
}
