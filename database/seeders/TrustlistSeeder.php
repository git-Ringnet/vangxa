<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrustlistSeeder extends Seeder
{
    /**
     * Tạo dữ liệu mẫu cho bảng trustlist
     */
    public function run()
    {
        // Lấy danh sách người dùng ngẫu nhiên
        $users = User::inRandomOrder()->take(30)->get();
        
        // Lấy danh sách bài viết
        $posts = Post::inRandomOrder()->take(50)->get();
        
        // Thống kê cho seed
        $totalEntries = 0;
        $usersWithTrustlist = 0;
        
        // Tạo dữ liệu trustlist cho các người dùng ngẫu nhiên
        foreach ($users as $user) {
            $hasAddedTrustlist = false;
            
            // Quyết định số lượng mục trustlist cho mỗi người dùng
            $userPattern = rand(1, 10);
            $maxItems = 1; // Mặc định là 1
            
            if ($userPattern <= 3) {
                // 30% người dùng thêm nhiều bài viết (3-5)
                $maxItems = rand(3, 5);
            } elseif ($userPattern <= 6) {
                // 30% người dùng thêm 2 bài viết
                $maxItems = 2;
            }
            
            // Tạo các mục trustlist cho người dùng
            $selectedPosts = $posts->random(min($maxItems, count($posts)));
            foreach ($selectedPosts as $post) {
                // Kiểm tra xem cặp user_id và post_id đã tồn tại chưa
                $exists = DB::table('trustlist')
                    ->where('user_id', $user->id)
                    ->where('post_id', $post->id)
                    ->exists();
                
                if (!$exists) {
                    // Tạo ngẫu nhiên thời gian tạo trong 30 ngày qua
                    $createdAt = Carbon::now()->subDays(rand(0, 30));
                    
                    DB::table('trustlist')->insert([
                        'user_id' => $user->id,
                        'post_id' => $post->id,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);
                    
                    $totalEntries++;
                    $hasAddedTrustlist = true;
                }
            }
            
            if ($hasAddedTrustlist) {
                $usersWithTrustlist++;
            }
        }
        
        $this->command->info('Đã tạo ' . $totalEntries . ' mục trustlist cho ' . $usersWithTrustlist . ' người dùng.');
        $this->command->info('Trung bình: ' . round($totalEntries / max(1, $usersWithTrustlist), 2) . ' mục/người dùng.');
    }
}
