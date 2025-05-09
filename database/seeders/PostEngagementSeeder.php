<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostEngagementSeeder extends Seeder
{
    /**
     * Chạy các seeder liên quan đến tương tác bài viết của vendor (reviews, trustlist)
     */
    public function run()
    {
        $this->command->info('Bắt đầu tạo dữ liệu mẫu cho các tương tác với bài viết của vendor...');
        
        // Chạy các seeder con
        $this->call([
            ReviewSeeder::class,
            TrustlistSeeder::class, // Seeder này đã có sẵn
        ]);
        
        $this->command->info('Hoàn tất tạo dữ liệu mẫu cho tương tác bài viết!');
    }
}
