<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;  // ← Важно!

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest('published_at')->paginate(9);

        $articles->getCollection()->transform(function ($article) {
            if ($article->preview_image) {
                $article->preview_image_url = asset('storage/' . $article->preview_image);
            }
            return $article;
        });

        return response()->json($articles);
    }

    public function show(Article $article)
    {
        if ($article->preview_image) {
            $article->preview_image_url = asset('storage/' . $article->preview_image);
        }

        return response()->json($article);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'content' => 'required|string',
            'preview_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'published_at' => 'required|date',
        ]);

        $path = $request->file('preview_image')->store('news', 'public');

        $article = Article::create([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'content' => $request->content,
            'preview_image' => $path,
            'full_image' => $path,
            'published_at' => $request->published_at,
        ]);

        $article->preview_image_url = asset('storage/' . $path);

        return response()->json($article, 201);
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'content' => 'required|string',
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'published_at' => 'required|date',
        ]);

        $data = $request->only(['title', 'short_description', 'content', 'published_at']);

        if ($request->hasFile('preview_image')) {
            if ($article->preview_image) {
                Storage::disk('public')->delete($article->preview_image);
            }

            $path = $request->file('preview_image')->store('news', 'public');
            $data['preview_image'] = $path;
            $data['full_image'] = $path;
        }

        $article->update($data);

        if ($article->preview_image) {
            $article->preview_image_url = asset('storage/' . $article->preview_image);
        }

        return response()->json($article);
    }

    public function destroy(Article $article)
    {
        if ($article->preview_image) {
            Storage::disk('public')->delete($article->preview_image);
        }

        $article->delete();

        return response()->json(['message' => 'Статья удалена']);
    }
}
