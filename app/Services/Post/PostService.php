<?php
namespace App\Services\Post;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostService{

    public function getPosts(Request $request)
    {
        $query = Post::query();
        $query->when($request->title, function ($q) use ($request) {
            return $q->where('title', 'like', '%' . $request->title . '%');
        });
        $query->when($request->category, function ($q) use ($request) {
            return $q->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request->category);
            });
        });
        return $query->with(['user'])->orderBy('published_at','desc')->paginate(10);
    }

    /**
     * @throws \Exception
     */
    public function createPost(Request $request): Post
    {
        try {
            $post = new Post();
            $post->title = $request->title;
            $post->body = $request->body;
            $post->user_id = Auth::id();
            $post->save();
            $post->categories()->syncWithoutDetaching($request->categories);
            if ($request->hasFile('image')) {
                $post->image()->create(['path'=>$request->file('image')->store('public')]) ;
            }
            return $post;
        }catch (\Exception $exception){
            throw new \Exception('error in create');
        }

    }
    public function showPost(Post $post): Post
    {
        $related=['categories','user','image'];
        return $post->load($related);
    }
    public function getPostComments(Post $post): \Illuminate\Database\Eloquent\Collection
    {
        return Comment::query()->with('user')->where('post_id',$post->id)->where('status','Approve')->get();
    }

    /**
     * @throws \Exception
     */
    public function updatePost(Request $request, Post $post): Post
    {
        try {
            $post->title = $request->title;
            $post->body = $request->body;
            $post->published_at=$request->publish_status == 'Published' ? Carbon::now():null;
            $post->publish_status=$request->publish_status;
            if ($request->hasFile('image'))
            {
                $this->checkImage($post);
                $post->image()->create(['path'=>$request->file('image')->store('public')]) ;
            }
            $post->save();
            $post->categories()->sync($request->categories);
            return $post;

    }catch (\Exception $exception){
    throw new \Exception('error in create');
    }

    }
    public function deletePost(Post $post)
    {
        $this->checkImage($post);
        $post->categories()->detach();
        $post->delete();
    }

    private function checkImage(Post $post): void
    {
    $image=$post->image()->first();
    if ($image)
    {
        Storage::delete($post->image->path);
        $post->image()->delete();
    }
    }
}
