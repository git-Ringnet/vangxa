<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id', 'title', 'content', 'order', 'embed_type', 'embed_url'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function images()
    {
        return $this->hasMany(PostSectionImage::class)->orderBy('order');
    }
} 