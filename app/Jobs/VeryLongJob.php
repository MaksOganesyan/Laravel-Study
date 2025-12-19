<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VeryLongJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $articleTitle;

    public function __construct($articleTitle)
    {
        $this->articleTitle = $articleTitle;
    }

    public function handle(): void
    {
        // "Долго выполняемая задача" — просто пишем в лог
        Log::info('НОВАЯ НОВОСТЬ ДОБАВЛЕНА: ' . $this->articleTitle);
        
        // Можно добавить sleep(10); для имитации долгой задачи
        // sleep(10);
    }
}
