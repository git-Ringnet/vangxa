<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserInteraction;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Tạo người dùng gần đạt hạng Silver (9 điểm)
        $user1 = User::create([
            'name' => 'User Near Silver',
            'email' => 'near_silver@example.com',
            'password' => Hash::make('password')
        ]);

        // Tạo tương tác cho user1 (9 điểm)
        for ($i = 0; $i < 9; $i++) {
            UserInteraction::create([
                'user_id' => $user1->id,
                'interaction_type' => 'post',
                'points' => 1,
                'created_at' => now()->subDays($i)
            ]);
        }

        // Tạo người dùng gần đạt hạng Gold (19 điểm)
        $user2 = User::create([
            'name' => 'User Near Gold',
            'email' => 'near_gold@example.com',
            'password' => Hash::make('password')
        ]);

        // Tạo tương tác cho user2 (19 điểm)
        for ($i = 0; $i < 19; $i++) {
            UserInteraction::create([
                'user_id' => $user2->id,
                'interaction_type' => 'post',
                'points' => 1,
                'created_at' => now()->subDays($i)
            ]);
        }

        // Tạo người dùng gần đạt hạng Platinum (29 điểm)
        $user3 = User::create([
            'name' => 'User Near Platinum',
            'email' => 'near_platinum@example.com',
            'password' => Hash::make('password')
        ]);

        // Tạo tương tác cho user3 (29 điểm)
        for ($i = 0; $i < 29; $i++) {
            UserInteraction::create([
                'user_id' => $user3->id,
                'interaction_type' => 'post',
                'points' => 1,
                'created_at' => now()->subDays($i)
            ]);
        }

        // Tạo người dùng gần đạt hạng Diamond (49 điểm)
        $user4 = User::create([
            'name' => 'User Near Diamond',
            'email' => 'near_diamond@example.com',
            'password' => Hash::make('password')
        ]);

        // Tạo tương tác cho user4 (49 điểm)
        for ($i = 0; $i < 49; $i++) {
            UserInteraction::create([
                'user_id' => $user4->id,
                'interaction_type' => 'post',
                'points' => 1,
                'created_at' => now()->subDays($i)
            ]);
        }
    }
} 