<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Services\Category\CategoryService;
use App\Services\Post\PostService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    private PostService $post_service;

    public function __construct(PostService $post_service)
    {
        $this->post_service=$post_service;

    }
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth:sanctum', except: ['index', 'show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = $this->post_service->getPosts($request);
        $categories=Category::all();
        return view('posts.index', compact('posts','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Post::class);
        $categories = Category::all();
        return view('posts.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $status='success';
        $message='post created!';
        try {
            $this->post_service->createPost($request);

        }catch (\Exception $exception)
        {
            $status='fail';
            $message=$exception->getMessage();
        }
        return view('posts.create')->with($status,$message)->with('categories', Category::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $view_data=[];
        $view_data['post']=$this->post_service->showPost($post);
        if (\auth()->id() == $post->user_id)
        {
            $view_data['comments']= $this->post_service->getPostComments($post);
        }
        return view('posts.show',$view_data);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        $post=$this->post_service->showPost($post);
        $categories=Category::all();
        return view('posts.edit', compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $status='success';
        $message='post updated!';
        try {
            $this->post_service->updatePost($request,$post);

        }catch (\Exception $exception)
        {
            $status='fail';
            $message=$exception->getMessage();
        }
        return redirect()->back()->with($status,$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);
        $this->post_service->deletePost($post);
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');

    }
}
