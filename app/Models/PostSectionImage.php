<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSectionImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_section_id', 'image_path', 'order'
    ];

    public function section()
    {
        return $this->belongsTo(PostSection::class, 'post_section_id');
    }
} 