<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Review;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    /**
     * Tạo dữ liệu mẫu cho bảng reviews
     */
    public function run()
    {
        // Lấy danh sách người dùng ngẫu nhiên
        $users = User::inRandomOrder()->take(35)->get();
        
        // Lấy danh sách bài viết (tập trung vào các bài viết loại dining hoặc cần đánh giá)
        $posts = Post::whereIn('type', [2, 'dining', 1, 'lodging'])
            ->inRandomOrder()
            ->take(60)
            ->get();
        
        // Nội dung đánh giá mẫu
        $reviewTemplates = [
            'Món ăn ngon, giá cả hợp lý.',
            'Dịch vụ tốt, nhân viên thân thiện.',
            'Món ăn khá ngon nhưng giá hơi cao.',
            'Không gian đẹp, phù hợp để hẹn hò.',
            'Thức ăn ở đây rất tươi và ngon miệng.',
            'Tôi thích không gian và cách trang trí ở đây.',
            'Dịch vụ khá chậm vào giờ cao điểm.',
            'Vị trí thuận tiện, dễ tìm.',
            'Giá cả hợp lý cho chất lượng nhận được.',
            'Thức uống đặc biệt và ngon.',
            'Phục vụ nhanh và nhiệt tình.',
            'Không gian khá ồn ào vào buổi tối.',
            'Thực đơn đa dạng, phù hợp với nhiều khẩu vị.',
            'Chỗ đậu xe hơi hạn chế.',
            'Tôi đã thưởng thức một bữa tối tuyệt vời ở đây.',
            'Phòng ốc sạch sẽ, tiện nghi đầy đủ.',
            'Vị trí thuận tiện để tham quan du lịch.',
            'Nhân viên lễ tân rất thân thiện và nhiệt tình.',
            'Wi-Fi miễn phí và tốc độ ổn định.',
            'Giá hơi cao so với dịch vụ nhận được.',
        ];
        
        // Thống kê cho seed
        $totalReviews = 0;
        $postsWithReviews = [];
        
        foreach ($posts as $post) {
            // Quyết định số lượng đánh giá cho mỗi bài viết
            $postPopularity = rand(1, 10);
            $reviewCount = 0;
            
            if ($postPopularity <= 4) {
                // 40% bài viết không có đánh giá
                continue;
            } elseif ($postPopularity <= 7) {
                // 30% bài viết có 1-3 đánh giá
                $reviewCount = rand(1, 3);
            } elseif ($postPopularity <= 9) {
                // 20% bài viết có 4-6 đánh giá
                $reviewCount = rand(4, 6);
            } else {
                // 10% bài viết có 7-10 đánh giá (bài viết nổi tiếng)
                $reviewCount = rand(7, 10);
            }
            
            // Nếu bài viết có đánh giá, thêm vào danh sách
            if ($reviewCount > 0) {
                $postsWithReviews[] = $post->id;
            }
            
            // Chọn người dùng ngẫu nhiên để đánh giá bài viết này
            $postReviewers = $users->random(min($reviewCount, count($users)));
            
            foreach ($postReviewers as $user) {
                // Kiểm tra xem người dùng đã đánh giá bài viết này chưa
                $exists = Review::where('user_id', $user->id)
                    ->where('post_id', $post->id)
                    ->exists();
                
                if (!$exists) {
                    // Tạo đánh giá
                    $review = new Review();
                    $review->post_id = $post->id;
                    $review->user_id = $user->id;
                    $review->food_rating = rand(1, 5); // Đánh giá từ 1-5 sao
                    $review->satisfaction_level = rand(1, 5); // Mức độ hài lòng 1-5
                    $review->comment = $reviewTemplates[array_rand($reviewTemplates)];
                    
                    // Tạo ngẫu nhiên thời gian tạo trong 30 ngày qua
                    $createdAt = Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
                    $review->created_at = $createdAt;
                    $review->updated_at = $createdAt;
                    
                    $review->save();
                    $totalReviews++;
                }
            }
        }
        
        $this->command->info('Đã tạo ' . $totalReviews . ' đánh giá cho ' . count($postsWithReviews) . ' bài viết.');
        $avgReviewsPerPost = count($postsWithReviews) > 0 ? round($totalReviews / count($postsWithReviews), 2) : 0;
        $this->command->info('Trung bình: ' . $avgReviewsPerPost . ' đánh giá/bài viết.');
    }
}
