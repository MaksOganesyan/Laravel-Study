<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function index()
    {
        $file = public_path('storage/news/articles.json');
        $json = file_get_contents($file);
        $articles = json_decode($json, true);

        // Добавляем id каждому элементу (по индексу + 1)
        foreach ($articles as $index => $article) {
            $articles[$index]['id'] = $index + 1;
        }

        return view('articles.index', compact('articles'));
    }

    public function show($id)
    {
        $file = public_path('storage/news/articles.json');
        $json = file_get_contents($file);
        $articles = json_decode($json, true);

        foreach ($articles as $index => $article) {
            $article['id'] = $index + 1;
            if ($article['id'] == $id) {
                return view('articles.show', ['article' => $article]);
            }
        }

        abort(404, 'Новость не найдена');
    }
}
