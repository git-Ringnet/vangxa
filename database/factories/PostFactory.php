<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'address' => $this->faker->address(),
            'description' => $this->faker->paragraphs(3, true),
            'user_id' => 1,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            // Tạo 1-5 ảnh cho mỗi bài viết
            $numberOfImages = rand(5, 10);
            for ($i = 0; $i < $numberOfImages; $i++) {
                $post->images()->create([
                    'image_path' => '/image/posts/' . 'anh1.jpg',
                ]);
            }
        });
    }
} 