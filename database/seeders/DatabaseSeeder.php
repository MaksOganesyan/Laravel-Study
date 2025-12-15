<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   public function run(): void
{
    $articles = \App\Models\Article::factory(10)->create();

    
    foreach ($articles as $article) {
        \App\Models\Comment::factory(rand(3, 8))->create(['article_id' => $article->id]);
    }
}
}
