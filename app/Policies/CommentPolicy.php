<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    // Просмотр комментариев — всем (и даже гостям)
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Comment $comment): bool
    {
        return true;
    }

    // Создание комментария — только авторизованным (читатели и модераторы)
    public function create(User $user): bool
    {
        return true; // модератор и так пройдёт через Gate::before
    }

    // Редактирование — только владелец или модератор
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
        // модератор пройдёт через Gate::before и получит true автоматически
    }

    // Удаление — только владелец или модератор
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }
}
