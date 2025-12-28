<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;   
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewArticleNotification;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Cache::remember('articles_page_' . request('page', 1), 3600, function () {
            return Article::latest('published_at')->paginate(9);
        });

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

        // Сохраняем картинку в storage/app/public/news
        $path = $request->file('preview_image')->store('news', 'public');
        // Создаём статью
        $article = Article::create([
            'title'             => $request->title,
            'short_description' => $request->short_description,
            'content'           => $request->content,
            'preview_image'     => $path,
            'full_image'        => $path,
            'published_at'      => $request->published_at,
        ]);

        // Более эффективная очистка кэша
        $this->clearArticlesCache();
        
        // Отправляем уведомления асинхронно через очередь
        $users = User::where('id', '!=', auth()->id())->get();
        Notification::send($users, new NewArticleNotification($article));

        return redirect()->route('articles.index')->with('success', 'Новость добавлена!');
    }

    public function show(Article $article)
    {
        // Кэширование статьи с комментариями
        $article = Cache::rememberForever('article_' . $article->id, function () use ($article) {
            return $article->load('comments');
        });
        
        // Отмечаем ВСЕ уведомления о этой статье как прочитанные для текущего пользователя
        if (auth()->check()) {
            auth()->user()->unreadNotifications
                ->where('data->article_id', $article->id)
                ->markAsRead();
        }

        return view('articles.show', compact('article'));
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
            // Удаляем старую картинку, если есть
            if ($article->preview_image) {
                Storage::disk('public')->delete($article->preview_image);
            }

            $path = $request->file('preview_image')->store('news', 'public');
            $data['preview_image'] = $path;
            $data['full_image'] = $path;
        }

        $article->update($data);
        
        // Очищаем кэш статьи и списка статей
        Cache::forget('article_' . $article->id);
        $this->clearArticlesCache();

        return redirect()->route('articles.index')
                         ->with('success', 'Новость обновлена!');
    }

    public function destroy(Article $article)
    {
        if ($article->preview_image) {
            Storage::disk('public')->delete($article->preview_image);
        }
        
        // Очищаем кэш перед удалением
        Cache::forget('article_' . $article->id);
        $this->clearArticlesCache();

        $article->delete();

        return redirect()->route('articles.index')
                         ->with('success', 'Новость удалена!');
    }
    
    /**
     * Очистка кэша страниц со статьями
     */
    private function clearArticlesCache()
    {
        // Очищаем несколько первых страниц (можно настроить под ваши нужды)
        for ($i = 1; $i <= 5; $i++) {
            Cache::forget('articles_page_' . $i);
        }
        
        
    }
}
