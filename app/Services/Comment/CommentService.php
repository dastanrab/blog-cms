<?php

namespace App\Services\Comment;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function getComments()
    {
        return Comment::query()->with(['user','post'])->get();
    }

    public function createComment(Request $request)
    {
        $comment = new Comment();
        $comment->text = $request->text;
        $comment->post_id = $request->post_id;
        $comment->save();
    }
    private function userPostIds()
    {
        return Post::query()->where('user_id',\auth()->id())->get()->pluck('id');
    }
}
