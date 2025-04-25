<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostOwner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'role',
    ];

    /**
     * Lấy thông tin bài đăng
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Lấy thông tin người dùng (chủ sở hữu)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
