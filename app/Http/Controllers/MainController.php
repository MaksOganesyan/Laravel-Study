<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    // Главная — список новостей из JSON
    public function index()
    {
        $json = file_get_contents(public_path('storage/news/articles.json'));
        $articles = json_decode($json, true);

        foreach ($articles as $i => $article) {
            $articles[$i]['id'] = $i + 1;
        }

        return view('news.index', compact('articles'));
    }

    // Галерея — одна новость 
    public function gallery($id)
    {
        $json = file_get_contents(public_path('storage/news/articles.json'));
        $articles = json_decode($json, true);

        foreach ($articles as $i => $article) {
            $article['id'] = $i + 1;
            if ($article['id'] == $id) {
                return view('news.gallery', ['article' => $article]);
            }
        }

        abort(404);
    }
}
