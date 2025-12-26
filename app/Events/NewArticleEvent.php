<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewArticleEvent implements ShouldBroadcast
{
    use InteractsWithSockets;

    public $article;

    /**
     * Create a new event instance.
     */
    public function __construct($article)
    {
        $this->article = $article;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        return new Channel('test'); // публичный канал
    }

    /**
     * Data to broadcast
     */
    public function broadcastWith()
    {
        return ['article' => $this->article];
    }
}
