<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ArticleView;

class LogArticleView
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->route('article')) {
            ArticleView::create([
                'article_id' => $request->route('article')->id,
                'ip' => $request->ip(),
            ]);
        }

        return $next($request);
    }
}
