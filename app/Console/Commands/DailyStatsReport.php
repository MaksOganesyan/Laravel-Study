<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ArticleView;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class DailyStatsReport extends Command
{
    protected $signature = 'stats:daily';
    protected $description = 'Отправка ежедневной статистики модераторам';

   public function handle()
{
    $today = Carbon::today();

    $viewsCount = ArticleView::whereDate('created_at', $today)->count();
    $commentsCount = Comment::whereDate('created_at', $today)->count();

    
    $text = "Ежедневная статистика сайта за " . $today->format('d.m.Y') . "\n\n";
    $text .= "Просмотров статей: {$viewsCount}\n";
    $text .= "Новых комментариев: {$commentsCount}\n";

    // Отправляем письмо
    Mail::raw($text, function ($message) {
        $message->to('oganesyanlaravel@yandex.ru')
                ->subject('Ежедневная статистика сайта');
    });

    $this->info('Отчёт отправлен на oganesyanlaravel@yandex.ru');
}
}
