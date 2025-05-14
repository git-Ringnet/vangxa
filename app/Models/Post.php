<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'group_id',
        'owner_id', // Vẫn giữ lại để tương thích ngược
        'min_price',
        'max_price',
        'cuisine',
        'styles',
        'latitude',
        'longitude',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Lưu vendor bài đăng
     */
    public function owners(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_owners', 'post_id', 'user_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Lấy danh sách vendors được tag trong bài viết
     */
    public function taggedVendors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_tagged_vendors', 'post_id', 'vendor_id')
            ->withTimestamps();
    }

    /**
     * Trả về đường dẫn đến trang chi tiết dựa vào loại bài đăng
     *
     * @return string
     */
    public function getDetailUrlAttribute(): string
    {
        return in_array($this->type, [2, 'dining'])
            ? route('dining.detail-dining', ['id' => $this->id])
            : route('detail', ['id' => $this->id]);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function trustlist()
    {
        return $this->hasMany(Trustlist::class);
    }

    public function getSavesCountAttribute()
    {
        return $this->trustlist()->count();
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')
            ->withTimestamps();
    }

    public function sections()
    {
        return $this->hasMany(PostSection::class)->orderBy('order');
    }
}
