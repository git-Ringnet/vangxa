<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Comment extends Model
{
    use NodeTrait;

    protected $fillable = ['post_id', 'user_id', 'content', 'parent_id', '_lft', '_rgt'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id')->defaultOrder();
    }
}
