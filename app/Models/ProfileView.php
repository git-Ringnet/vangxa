<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileView extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendor_id',
        'ip_address',
        'user_agent',
        'referrer_platform',
    ];

    /**
     * Người xem profile
     */
    public function viewer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Người bán (vendor) được xem profile
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
