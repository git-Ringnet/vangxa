<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    /**
     * Chạy tất cả các seeder liên quan đến nhóm cộng đồng.
     */
    public function run()
    {
        $this->call([
            GroupSeeder::class,           // Tạo các nhóm Vangxa
            GroupMemberSeeder::class,     // Thêm thành viên vào nhóm
            GroupPostSeeder::class,       // Tạo bài viết trong nhóm
            GroupCommentSeeder::class,    // Thêm bình luận cho bài viết
            GroupLikeSeeder::class,       // Thêm like cho bài viết
        ]);
    }
}
