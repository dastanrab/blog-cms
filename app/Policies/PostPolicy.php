<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{

    public function view(User $user, Post $post)
    {
    return true;
    }

    public function create(User $user)
    {
    return $user->isAuthor() || $user->isAdmin();
    }

    public function update(User $user,Post $post)
    {
    return $user->isAdmin() || $user->id == $post->user_id ;
    }

    public function delete(User $user,Post $post)
    {
    return $user->isAdmin() || $user->id == $post->user_id;
    }
}
