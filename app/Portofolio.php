<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    protected $fillable = ['user_id', 'title', 'body'];

    public function comments()
    {
        return $this->morphToMany(Comment::class, 'commantable');
    }
}
