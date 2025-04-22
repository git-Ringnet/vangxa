<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cover_image',
        'avatar',
        'user_id',
        'is_private',
        'member_count',
        'post_count'
    ];

    protected $casts = [
        'is_private' => 'boolean',
        'member_count' => 'integer',
        'post_count' => 'integer'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function isMember(User $user)
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    public function isAdmin(User $user)
    {
        return $this->members()
            ->where('user_id', $user->id)
            ->where('role', 'admin')
            ->exists();
    }

    public function isModerator(User $user)
    {
        return $this->members()
            ->where('user_id', $user->id)
            ->where('role', 'moderator')
            ->exists();
    }
} 