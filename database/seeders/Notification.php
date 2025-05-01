<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Notification extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lấy người dùng đầu tiên hoặc tạo mới nếu không có
        $user = User::first();
        // Danh sách thông báo mẫu
        $notifications = [
            [
                'message' => 'Có đơn hàng mới #001 cần xử lý!',
                'read_at' => null, // Chưa đọc
                'created_at' => now()->subMinutes(10),
            ],
            [
                'message' => 'Tài khoản của bạn đã được xác minh.',
                'read_at' => now()->subHours(1), // Đã đọc
                'created_at' => now()->subHours(2),
            ],
            [
                'message' => 'Khách hàng Nguyễn Văn A vừa đặt chỗ ở.',
                'read_at' => null, // Chưa đọc
                'created_at' => now()->subMinutes(30),
            ],
            [
                'message' => 'Cập nhật hệ thống Vangxa phiên bản 2.0.',
                'read_at' => now()->subDays(1), // Đã đọc
                'created_at' => now()->subDays(1),
            ],
            [
                'message' => 'Thanh toán #123 đã được xác nhận.',
                'read_at' => null, // Chưa đọc
                'created_at' => now()->subHours(1),
            ],
            [
                'message' => 'Có phản hồi mới từ khách hàng.',
                'read_at' => null, // Chưa đọc
                'created_at' => now()->subMinutes(5),
            ],
            [
                'message' => 'Hệ thống bảo trì từ 2h-4h sáng mai.',
                'read_at' => now()->subHours(3), // Đã đọc
                'created_at' => now()->subHours(4),
            ],
            [
                'message' => 'Khuyến mãi 20% cho chủ nhà mới!',
                'read_at' => null, // Chưa đọc
                'created_at' => now()->subDays(2),
            ],
            [
                'message' => 'Đơn hàng #002 bị hủy.',
                'read_at' => now()->subMinutes(20), // Đã đọc
                'created_at' => now()->subMinutes(25),
            ],
            [
                'message' => 'Chào mừng bạn đến với Vangxa!',
                'read_at' => now()->subDays(3), // Đã đọc
                'created_at' => now()->subDays(3),
            ],
        ];

        // Thêm thông báo vào bảng notifications
        foreach ($notifications as $notification) {
            DB::table('notifications')->insert([
                'id' => Str::uuid()->toString(),
                'type' => 'App\Notifications\Notifications',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $user->id,
                'data' => json_encode(['message' => $notification['message']]),
                'read_at' => $notification['read_at'],
                'created_at' => $notification['created_at'],
                'updated_at' => $notification['created_at'],
            ]);
        }
    }
}
