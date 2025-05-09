<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Group;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class GroupCommentSeeder extends Seeder
{
    /**
     * Tạo các bình luận cho bài viết trong nhóm Vangxa
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
        
        $commentCount = 0;
        
        foreach ($posts as $post) {
            // Lấy danh sách thành viên trong nhóm của bài viết
            $groupMembers = DB::table('group_members')
                ->where('group_id', $post->group_id)
                ->pluck('user_id')
                ->toArray();
                
            if (empty($groupMembers)) {
                continue;
            }
            
            // Mỗi bài viết có 0-15 bình luận
            $commentsPerPost = rand(0, 10);
            
            // Một số bài viết phổ biến có nhiều bình luận hơn
            if (rand(1, 10) <= 2) {
                $commentsPerPost = rand(5, 10); // 20% bài viết có 20-40 bình luận
            }
            
            // Tạo các bình luận
            for ($i = 0; $i < $commentsPerPost; $i++) {
                // Chọn ngẫu nhiên một thành viên làm người bình luận
                $commenterId = $groupMembers[array_rand($groupMembers)];
                
                // Tạo nội dung bình luận
                $commentContent = '';
                $commentType = rand(1, 4);
                
                switch ($commentType) {
                    case 1: // Ngắn
                        $commentContent = $faker->sentence(rand(3, 8));
                        break;
                    case 2: // Vừa
                        $commentContent = $faker->paragraph(rand(1, 2));
                        break;
                    case 3: // Dài
                        $commentContent = $faker->paragraphs(rand(1, 3), true);
                        break;
                    case 4: // Cảm xúc
                        $emotions = ['❤️', '👍', '😍', '🔥', '👏', '😊', '🙌', '💯', '🥰', '❤️‍🔥'];
                        $commentContent = $faker->sentence(rand(2, 5)) . ' ' . $emotions[array_rand($emotions)];
                        break;
                }
                
                // Xác định xem đây có phải là trả lời cho bình luận khác không
                $parentId = null;
                if ($i > 0 && rand(1, 4) <= 1) { // 25% bình luận là trả lời
                    // Lấy một bình luận đã tồn tại của bài viết này
                    $existingComment = Comment::where('post_id', $post->id)
                        ->whereNull('parent_id') // Chỉ chọn bình luận gốc, không phải trả lời
                        ->inRandomOrder()
                        ->first();
                    
                    if ($existingComment) {
                        $parentId = $existingComment->id;
                    }
                }
                
                // Tạo bình luận
                Comment::create([
                    'content' => $commentContent,
                    'user_id' => $commenterId,
                    'post_id' => $post->id,
                    'parent_id' => $parentId,
                    'created_at' => $faker->dateTimeBetween($post->created_at, 'now'),
                    'updated_at' => now()
                ]);
                
                $commentCount++;
            }
        }
        
        $this->command->info("Đã tạo {$commentCount} bình luận cho bài viết trong các nhóm Vangxa!");
    }
}
