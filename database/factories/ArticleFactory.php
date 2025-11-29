<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(6),
            'short_description' => fake()->paragraph(2),
            'content' => fake()->paragraphs(6, true),
            'preview_image' => fake()->randomElement(['preview.jpg', 'preview_2.jpg']),
            'full_image'    => fake()->randomElement(['full.jpeg', 'full_2.jpeg']),
            'published_at' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
