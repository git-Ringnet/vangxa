<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'min_points',
        'max_points',
        'icon',
        'color',
        'description'
    ];

    protected $casts = [
        'min_points' => 'integer',
        'max_points' => 'integer'
    ];
} 