<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserActivitySeeder extends Seeder
{
    /**
     * Tạo dữ liệu mẫu cho việc tính toán DAU/WAU và Retention Rate
     */
    public function run()
    {
        // Xóa dữ liệu cũ nếu cần
        // DB::table('users')->where('email', 'like', 'test_activity%')->delete();
        
        // Tổng số người dùng mẫu để tạo
        $totalUsers = 10;
        
        // Mảng lưu trữ user theo ngày để tính toán retention
        $usersByDay = [];
        
        for ($i = 0; $i < $totalUsers; $i++) {
            // Tạo người dùng
            $user = User::create([
                'name' => 'Test User ' . ($i + 1),
                'email' => 'test_activity_' . ($i + 1) . '@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            
            // Tạo lịch sử hoạt động ngẫu nhiên cho người dùng
            $this->createRandomActivityHistory($user, $usersByDay);
        }
        
        // Hiển thị thông tin về retention dự kiến
        $this->displayRetentionStats($usersByDay);
    }
    
    /**
     * Tạo lịch sử hoạt động ngẫu nhiên cho người dùng
     */
    private function createRandomActivityHistory($user, &$usersByDay)
    {
        // Tạo ngày đăng ký - ngẫu nhiên trong 30 ngày gần đây
        $registrationDay = rand(1, 30);
        $registrationDate = Carbon::now()->subDays($registrationDay);
        
        // Cập nhật ngày tạo người dùng
        $user->created_at = $registrationDate;
        $user->save();
        
        // Tạo danh sách các ngày hoạt động ngẫu nhiên sau ngày đăng ký
        $activityDays = [];
        
        // Mô phỏng mẫu hoạt động người dùng - kết hợp ngẫu nhiên và mẫu:
        // 1. Một số người dùng hoạt động hàng ngày
        // 2. Một số người dùng hoạt động không đều
        // 3. Một số người dùng chỉ hoạt động 1-2 lần rồi bỏ
        
        $activityPattern = rand(1, 10);
        
        if ($activityPattern <= 2) {
            // 20% người dùng rất tích cực - hoạt động hầu hết các ngày
            for ($day = $registrationDay; $day >= 0; $day--) {
                // 80% khả năng hoạt động mỗi ngày
                if (rand(1, 100) <= 80) {
                    $activityDays[] = $day;
                }
            }
        } elseif ($activityPattern <= 5) {
            // 30% người dùng trung bình - hoạt động 2-3 lần/tuần
            for ($day = $registrationDay; $day >= 0; $day--) {
                // 40% khả năng hoạt động mỗi ngày
                if (rand(1, 100) <= 40) {
                    $activityDays[] = $day;
                }
            }
        } elseif ($activityPattern <= 8) {
            // 30% người dùng thỉnh thoảng - hoạt động 1 lần/tuần
            for ($day = $registrationDay; $day >= 0; $day--) {
                // 15% khả năng hoạt động mỗi ngày
                if (rand(1, 100) <= 15) {
                    $activityDays[] = $day;
                }
            }
        } else {
            // 20% người dùng bỏ - chỉ hoạt động trong vài ngày đầu
            // Hoạt động ngày đầu tiên
            $activityDays[] = $registrationDay;
            
            // 50% khả năng hoạt động vào ngày hôm sau
            if (rand(1, 100) <= 50 && $registrationDay > 1) {
                $activityDays[] = $registrationDay - 1;
                
                // 20% khả năng hoạt động thêm một ngày nữa
                if (rand(1, 100) <= 20 && $registrationDay > 2) {
                    $activityDays[] = $registrationDay - 2;
                }
            }
        }
        
        // Ghi lại hoạt động cho người dùng
        foreach ($activityDays as $day) {
            $activityDate = Carbon::now()->subDays($day);
            
            // Cập nhật last_activity_at
            if ($day == min($activityDays)) {
                $user->last_activity_at = $activityDate;
                $user->save();
            }
            
            // Thêm người dùng vào mảng theo ngày để tính toán retention
            if (!isset($usersByDay[$day])) {
                $usersByDay[$day] = [];
            }
            $usersByDay[$day][] = $user->id;
        }
    }
    
    /**
     * Hiển thị thông tin về retention dự kiến từ dữ liệu đã tạo
     */
    private function displayRetentionStats($usersByDay)
    {
        // Tính Day 1 Retention dự kiến
        $day1Retention = $this->calculateExpectedRetention($usersByDay, 1);
        
        // Tính Day 7 Retention dự kiến
        $day7Retention = $this->calculateExpectedRetention($usersByDay, 7);
        
        $this->command->info('Dữ liệu hoạt động người dùng đã được tạo thành công!');
        $this->command->info('Day 1 Retention dự kiến: ' . $day1Retention . '%');
        $this->command->info('Day 7 Retention dự kiến: ' . $day7Retention . '%');
    }
    
    /**
     * Tính toán retention dự kiến từ dữ liệu đã tạo
     */
    private function calculateExpectedRetention($usersByDay, $days)
    {
        $totalRetention = 0;
        $sampleCount = 0;
        
        // Kiểm tra retention trong dữ liệu cho các ngày khác nhau
        for ($startDay = 30; $startDay > $days + 1; $startDay--) {
            if (isset($usersByDay[$startDay]) && count($usersByDay[$startDay]) > 0) {
                $startUsers = $usersByDay[$startDay];
                $endDay = $startDay - $days;
                
                if (isset($usersByDay[$endDay])) {
                    $endUsers = $usersByDay[$endDay];
                    
                    // Đếm số người dùng xuất hiện ở cả hai ngày
                    $retainedUsers = count(array_intersect($startUsers, $endUsers));
                    
                    if (count($startUsers) > 0) {
                        $retentionRate = ($retainedUsers / count($startUsers)) * 100;
                        $totalRetention += $retentionRate;
                        $sampleCount++;
                    }
                }
            }
        }
        
        // Tính trung bình retention
        return $sampleCount > 0 ? round($totalRetention / $sampleCount, 2) : 0;
    }
}
