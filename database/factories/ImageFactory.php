<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = PostImage::class;

    public function definition()
    {
        // Danh sách các ảnh mẫu có sẵn
        $sampleImages = [
            'posts/anh1.jpg',
        ];
        
        return [
            'post_id' => Post::factory(),
            'image_path' => $this->faker->randomElement($sampleImages),
        ];
    }
} 