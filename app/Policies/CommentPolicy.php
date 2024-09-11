<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{

    public function view(User $user)
    {
        return  $user->isAdmin();
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Comment $comment)
    {
        return  $user->id === $comment->user_id;
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->isAdmin();
    }

    public function approve(User $user)
    {
        return $user->isAdmin();
    }
    public function reject(User $user)
    {
        return $user->isAdmin();
    }
}
