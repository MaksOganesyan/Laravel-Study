<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'title'             => fake()->sentence(6),
            'short_description' => fake()->paragraph(2),
            'content'           => fake()->paragraphs(6, true),
            'preview_image'     => fake()->randomElement(['preview.jpg', 'preview_2.jpg']),
            'full_image'        => fake()->randomElement(['full.jpeg', 'full_2.jpeg']),
            'published_at'      => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }

    /**
     * После создания статьи добавляем к ней комментарии
     */
    public function configure()
    {
        return $this->afterCreating(function (Article $article) {
            // Создаём от 0 до 8 комментариев
            Comment::factory()
                ->count(fake()->numberBetween(0, 8))
                ->create([
                    'article_id' => $article->id,
                    'user_id'    => User::inRandomOrder()->first()->id ?? 1, // случайный существующий пользователь
                ]);
        });
    }
}
