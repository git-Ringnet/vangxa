<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tier;

class TierSeeder extends Seeder
{
    public function run()
    {
        $tiers = [
            [
                'name' => 'Bronze',
                'min_points' => 0,
                'max_points' => 9,
                'icon' => '🥉',
                'color' => '#cd7f32',
                'description' => 'Hạng đồng - Bắt đầu hành trình'
            ],
            [
                'name' => 'Silver',
                'min_points' => 10,
                'max_points' => 19,
                'icon' => '🥈',
                'color' => '#c0c0c0',
                'description' => 'Hạng bạc - Đã có những đóng góp đầu tiên'
            ],
            [
                'name' => 'Gold',
                'min_points' => 20,
                'max_points' => 29,
                'icon' => '🏆',
                'color' => '#ffd700',
                'description' => 'Hạng vàng - Thành viên tích cực'
            ],
            [
                'name' => 'Platinum',
                'min_points' => 30,
                'max_points' => 49,
                'icon' => '⚪',
                'color' => '#e5e4e2',
                'description' => 'Hạng bạch kim - Đóng góp xuất sắc'
            ],
            [
                'name' => 'Diamond',
                'min_points' => 50,
                'max_points' => null,
                'icon' => '💎',
                'color' => '#b9f2ff',
                'description' => 'Hạng kim cương - Thành viên ưu tú'
            ]
        ];

        foreach ($tiers as $tier) {
            Tier::create($tier);
        }
    }
} 