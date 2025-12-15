<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Article;
use App\Policies\ArticlePolicy; // если у тебя Article, а не News
use App\Models\Comment;
use App\Policies\CommentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    public function boot(): void
    {
        // САМОЕ ВАЖНОЕ: Gate::before ДОЛЖЕН БЫТЬ ПЕРЕД registerPolicies() !
        Gate::before(function ($user, $ability) {
            if ($user->role?->name === 'moderator') {
                return true; // модератор может всё
            }
        });

        // Теперь регистрируем политики
        $this->registerPolicies();

    }
}
