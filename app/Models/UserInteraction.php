<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class UserInteraction extends Model
{
    protected $fillable = [
        'user_id',
        'interaction_type',
        'points'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getTopContributors($limit = 10)
    {
        return self::select('user_id')
            ->selectRaw('SUM(points) as total_points')
            ->selectRaw('SUM(CASE WHEN interaction_type = "post" THEN 1 ELSE 0 END) as posts_count')
            ->selectRaw('SUM(CASE WHEN interaction_type = "trustlist" THEN 1 ELSE 0 END) as trustlist_count')
            ->selectRaw('SUM(CASE WHEN interaction_type = "share" THEN 1 ELSE 0 END) as share_count')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->groupBy('user_id')
            ->orderByDesc('total_points')
            ->with('user')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                $item->tier = self::getUserTier($item->total_points);
                return $item;
            });
    }

    public static function getUserTier($points)
    {
        if ($points >= 50) return 'Diamond';
        if ($points >= 30) return 'Platinum';
        if ($points >= 20) return 'Gold';
        if ($points >= 10) return 'Silver';
        return 'Bronze';
    }

    public static function getTierColor($tier)
    {
        return match($tier) {
            'Diamond' => '#b9f2ff',
            'Platinum' => '#e5e4e2',
            'Gold' => '#ffd700',
            'Silver' => '#c0c0c0',
            'Bronze' => '#cd7f32',
            default => '#cd7f32'
        };
    }

    public static function getTierIcon($tier)
    {
        return match($tier) {
            'Diamond' => '💎',
            'Platinum' => '⚪',
            'Gold' => '🏆',
            'Silver' => '🥈',
            'Bronze' => '🥉',
            default => '��'
        };
    }

    public static function checkTierUpgrade($userId)
    {
        $currentPoints = self::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('points');
    
        $currentTier = self::getUserTier($currentPoints);
        
        // Lấy hạng cao nhất đã đạt được trong tháng
        $highestTier = self::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->value('highest_tier') ?? 'Bronze';
    
        // Debug thông tin điểm và hạng
        \Log::info('Tier Upgrade Debug:', [
            'user_id' => $userId,
            'current_points' => $currentPoints,
            'current_tier' => $currentTier,
            'highest_tier' => $highestTier,
            'tier_comparison' => self::compareTiers($currentTier, $highestTier)
        ]);
    
        // Nếu hạng hiện tại cao hơn hạng cao nhất đã đạt
        if (self::compareTiers($currentTier, $highestTier) > 0) {
            // Cập nhật hạng cao nhất
            self::where('user_id', $userId)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->update(['highest_tier' => $currentTier]);
    
            \Log::info('Tier Upgrade Success:', [
                'new_tier' => $currentTier,
                'old_tier' => $highestTier
            ]);
    
            return [
                'upgraded' => true,
                'new_tier' => $currentTier,
                'old_tier' => $highestTier,
                'points' => $currentPoints,
                'icon' => self::getTierIcon($currentTier),
                'color' => self::getTierColor($currentTier),
                'message' => 'Chúc mừng! Bạn đã thăng hạng lên ' . $currentTier . '!'
            ];
        }
    
        \Log::info('No Tier Upgrade:', [
            'current_tier' => $currentTier,
            'points' => $currentPoints
        ]);
    
        return [
            'upgraded' => false,
            'current_tier' => $currentTier,
            'points' => $currentPoints
        ];
    }

    private static function compareTiers($tier1, $tier2)
    {
        $tierOrder = ['Bronze' => 1, 'Silver' => 2, 'Gold' => 3, 'Platinum' => 4, 'Diamond' => 5];
        return $tierOrder[$tier1] - $tierOrder[$tier2];
    }
} 