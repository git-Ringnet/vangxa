<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@ringnet.vn',
            'password' => Hash::make('Admin@123'),
        ]);

        // Tạo 20 bài viết với ảnh
        Post::factory(100)->create();

        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            TierSeeder::class,
        ]);
    }
}
