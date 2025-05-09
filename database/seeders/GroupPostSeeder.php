<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class GroupPostSeeder extends Seeder
{
    /**
     * Tạo các bài viết trong các nhóm Vangxa
     */
    public function run()
    {
        $faker = Faker::create('vi_VN');
        
        // Lấy 3 nhóm Vangxa đã tạo
        $groups = Group::where('name', 'like', 'Vangxa%')->get();
        
        if ($groups->isEmpty()) {
            $this->command->error('Không tìm thấy nhóm Vangxa nào. Hãy chạy GroupSeeder trước!');
            return;
        }
        
        $postCount = 0;
        
        foreach ($groups as $group) {
            // Lấy danh sách thành viên trong nhóm
            $groupMembers = DB::table('group_members')
                ->where('group_id', $group->id)
                ->pluck('user_id')
                ->toArray();
                
            if (empty($groupMembers)) {
                $this->command->info("Nhóm {$group->name} không có thành viên nào. Bỏ qua.");
                continue;
            }
            
            // Số lượng bài viết mỗi nhóm (5-10)
            $postsPerGroup = rand(5, 10);
            
            for ($i = 0; $i < $postsPerGroup; $i++) {
                // Chọn ngẫu nhiên một thành viên làm tác giả
                $authorId = $groupMembers[array_rand($groupMembers)];
                
                // Tạo tiêu đề và nội dung
                $postTopics = [
                    'Chia sẻ địa điểm ăn uống', 'Review quán ăn', 'Review homestay',
                    'Địa điểm du lịch', 'Kinh nghiệm du lịch', 'Món ăn đặc sản',
                    'Phòng trọ giá rẻ', 'Khách sạn chất lượng', 'Quán cà phê đẹp',
                    'Địa điểm chụp ảnh đẹp', 'Lịch trình du lịch', 'Ẩm thực đường phố'
                ];
                
                $topic = $postTopics[array_rand($postTopics)];
                $location = '';
                
                if (Str::contains($group->name, 'Hà Nội')) {
                    $location = $faker->randomElement(['Hà Nội', 'Hạ Long', 'Ninh Bình', 'Hải Phòng', 'Sapa', 'Tam Đảo']);
                } elseif (Str::contains($group->name, 'Hồ Chí Minh')) {
                    $location = $faker->randomElement(['TP.HCM', 'Vũng Tàu', 'Đà Lạt', 'Phan Thiết', 'Cần Thơ', 'Tây Ninh']);
                } else {
                    $location = $faker->randomElement(['Hà Nội', 'TP.HCM', 'Đà Nẵng', 'Huế', 'Nha Trang', 'Phú Quốc', 'Hội An', 'Sapa', 'Hạ Long']);
                }
                
                $title = "[{$topic}] {$faker->sentence(rand(4, 8))} - {$location}";
                $description = $faker->paragraphs(rand(3, 6), true);
                
                // Tạo bài viết
                Post::create([
                    'title' => $title,
                    'description' => $description,
                    'user_id' => $authorId,
                    'type' => 3, // 3: cộng đồng
                    'status' => 1, // 1: đã đăng
                    'group_id' => $group->id,
                    'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                    'updated_at' => now()
                ]);
                
                $postCount++;
            }
            
            // Cập nhật số lượng bài viết trong nhóm
            $actualPostCount = Post::where('group_id', $group->id)->count();
            $group->update(['post_count' => $actualPostCount]);
        }
        
        $this->command->info("Đã tạo {$postCount} bài viết trong các nhóm Vangxa!");
    }
}
