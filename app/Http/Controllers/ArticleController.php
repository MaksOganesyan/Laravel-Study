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
        'title' => 'required|string|max:255',
        'short_description' => 'required|string',
        'content' => 'required|string',
        'preview_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'published_at' => 'required|date',
    ]);

    $filename = time() . '_' . $request->preview_image->getClientOriginalName();
    $request->preview_image->move(public_path('storage/news'), $filename);

    Article::create([
        'title' => $request->title,
        'short_description' => $request->short_description,
        'content' => $request->content,
        'preview_image' => $filename,  
        'full_image' => $filename,
        'published_at' => $request->published_at,
    ]);

    return redirect()->route('articles.index')->with('success', 'Новость добавлена!');
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
        // Удаляем старую
        if ($article->preview_image && file_exists(public_path('storage/news/' . $article->preview_image))) {
            unlink(public_path('storage/news/' . $article->preview_image));
        }

        $filename = time() . '_' . $request->preview_image->getClientOriginalName();
        $request->preview_image->move(public_path('storage/news'), $filename);

        $data['preview_image'] = $filename;
        $data['full_image'] = $filename;
    }

    $article->update($data);

    return redirect()->route('articles.index')->with('success', 'Новость обновлена!');
}

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

   
    public function destroy(Article $article)
    {
        if ($article->preview_image) {
            Storage::disk('public')->delete($article->preview_image);
        }
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Новость удалена!');
    }
    public function show(Article $article)
{
    return view('articles.show', compact('article'));
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('success', 'Вы вышли из аккаунта');
}
}
