<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest('published_at')->paginate(9);
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'short_description' => 'required|string',
            'content'           => 'required|string',
            'preview_image'     => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'published_at'      => 'required|date',
        ]);

        $path = $request->file('preview_image')->store('news', 'public');

        Article::create([
            'title'             => $request->title,
            'short_description' => $request->short_description,
            'content'           => $request->content,
            'preview_image'     => $path,
            'full_image'        => $path,
            'published_at'      => $request->published_at,
        ]);

        return redirect()->route('articles.index')->with('success', 'Новость добавлена!');
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'short_description' => 'required|string',
            'content'           => 'required|string',
            'preview_image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'published_at'      => 'required|date',
        ]);

        $data = $request->only(['title', 'short_description', 'content', 'published_at']);

        if ($request->hasFile('preview_image')) {
            if ($article->preview_image) {
                Storage::disk('public')->delete($article->preview_image);
            }
            $path = $request->file('preview_image')->store('news', 'public');
            $data['preview_image'] = $path;
            $data['full_image']    = $path;
        }

        $article->update($data);

        return redirect()->route('articles.index')->with('success', 'Новость обновлена!');
    }

    public function destroy(Article $article)
    {
        if ($article->preview_image) {
            Storage::disk('public')->delete($article->preview_image);
        }
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Новость удалена!');
    }
}
