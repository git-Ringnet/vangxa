<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'address',
        'description',
        'user_id',
        'status',
        'type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereIsRoot(); // chỉ lấy comment gốc
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }
}
