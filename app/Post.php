<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $guarded = [];

    public function writer() : BelongsTo
    {
    	return $this->belongsTo(User::class, 'author_id');
    }

    public function comments() : HasMany	
    {
    	return $this->hasMany(Comment::class);
    }
}
