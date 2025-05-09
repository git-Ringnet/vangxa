<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\User;

class GroupSeeder extends Seeder
{
    /**
     * Tạo 3 nhóm Vangxa là nhóm chính
     */
    public function run()
    {
        // Lấy một số người dùng để làm admin nhóm
        $users = User::inRandomOrder()->limit(3)->get();
        
        // Tạo 3 nhóm Vangxa
        $groups = [
            [
                'name' => 'Vangxa',
                'description' => 'Cộng đồng chia sẻ và khám phá ẩm thực, homestay, du lịch và các vùng lân cận',
                'cover_image' => 'images/groups/hanoi-cover.jpg',
                'avatar' => 'images/groups/hanoi-avatar.jpg',
                'user_id' => $users[0]->id,
                'is_private' => false,
                'member_count' => 0,
                'post_count' => 0
            ],
            [
                'name' => 'Vangxa TP.HCM',
                'description' => 'Cộng đồng chia sẻ và khám phá ẩm thực, homestay, du lịch và các vùng lân cận',
                'cover_image' => 'images/groups/hcm-cover.jpg',
                'avatar' => 'images/groups/hcm-avatar.jpg',
                'user_id' => $users[1]->id,
                'is_private' => false,
                'member_count' => 0,
                'post_count' => 0
            ],
            [
                'name' => 'Vangxa Du lịch Việt Nam',
                'description' => 'Cộng đồng chia sẻ và khám phá các địa điểm du lịch trên khắp Việt Nam',
                'cover_image' => 'images/groups/vietnam-cover.jpg',
                'avatar' => 'images/groups/vietnam-avatar.jpg',
                'user_id' => $users[2]->id,
                'is_private' => false,
                'member_count' => 0,
                'post_count' => 0
            ]
        ];
        
        foreach ($groups as $groupData) {
            Group::create($groupData);
        }
        
        $this->command->info('Đã tạo 3 nhóm Vangxa thành công!');
    }
}
