<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'provider',
        'verification_code',
        'verification_code_expires_at',
        'is_verified',
        'avatar',
        'referral_source',
        'experience_expectation',
        'phone',
        'tiktok_id',
        'tiktok_token',
        'last_activity_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function getAvatarAttribute($value)
    {
        return $value ? asset($value) : asset('image/default/default-group-avatar.jpg');
    }

    public function trustlists()
    {
        return $this->hasMany(Trustlist::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'favorites');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Người dùng theo dõi user này
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * User này đang theo dõi những người dùng nào
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    /**
     * Kiểm tra xem user hiện tại có đang theo dõi user được chỉ định không
     */
    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    /**
     * Kiểm tra xem user được chỉ định có đang theo dõi user hiện tại không
     */
    public function isFollowedBy(User $user)
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    /**
     * Get the posts that belong to the user via post_owners table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ownedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_owners', 'user_id', 'post_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get the stories that belong to the vendor.
     */
    public function stories()
    {
        return $this->hasMany(VendorStory::class);
    }
}
