<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Group;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class GroupLikeSeeder extends Seeder
{
    /**
     * Tạo like cho các bài viết trong nhóm Vangxa
     */
    public function run()
    {
        $faker = Faker::create('vi_VN');
        
        // Lấy các bài viết thuộc các nhóm Vangxa
        $posts = Post::whereNotNull('group_id')
                     ->whereHas('group', function($query) {
                         $query->where('name', 'like', 'Vangxa%');
                     })
                     ->get();
        
        if ($posts->isEmpty()) {
            $this->command->error('Không tìm thấy bài viết nào trong các nhóm Vangxa. Hãy chạy GroupPostSeeder trước!');
            return;
        }
        
        $likeCount = 0;
        
        foreach ($posts as $post) {
            // Lấy danh sách thành viên trong nhóm của bài viết
            $groupMembers = DB::table('group_members')
                ->where('group_id', $post->group_id)
                ->pluck('user_id')
                ->toArray();
                
            if (empty($groupMembers)) {
                continue;
            }
            
            // Mỗi bài viết có 0-30 like
            $likesPerPost = rand(0, 10);
            
            // Một số bài viết phổ biến có nhiều like hơn
            if (rand(1, 10) <= 2) {
                $likesPerPost = rand(5, 10); // 20% bài viết có 50-100 like
            }
            
            // Đảm bảo số lượng like không vượt quá số lượng thành viên
            $likesPerPost = min($likesPerPost, count($groupMembers));
            
            // Chọn ngẫu nhiên các thành viên để tạo like
            $likers = [];
            if ($likesPerPost > 0 && count($groupMembers) > 0) {
                // Shuffle mảng thành viên
                shuffle($groupMembers);
                // Lấy số phần tử cần thiết
                $likers = array_slice($groupMembers, 0, $likesPerPost);
            }
            
            foreach ($likers as $userId) {
                // Kiểm tra xem đã like chưa
                $existingLike = DB::table('likes')
                    ->where('user_id', $userId)
                    ->where('post_id', $post->id)
                    ->exists();
                
                if (!$existingLike) {
                    // Tạo like mới
                    DB::table('likes')->insert([
                        'user_id' => $userId,
                        'post_id' => $post->id,
                        'created_at' => $faker->dateTimeBetween($post->created_at, 'now'),
                        'updated_at' => now()
                    ]);
                    
                    $likeCount++;
                }
            }
        }
        
        $this->command->info("Đã tạo {$likeCount} like cho bài viết trong các nhóm Vangxa!");
    }
}
