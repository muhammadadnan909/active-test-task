<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
        protected $model = Post::class;

    public function definition()
    {
        return [
            //

                'title' => $this->faker->sentence,
                'content' => $this->faker->paragraph(5),
                'user_id' => rand(1, 2)

        ];
    }
}
