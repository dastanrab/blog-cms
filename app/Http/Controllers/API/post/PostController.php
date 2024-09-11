<?php

namespace App\Http\Controllers\API\post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostApiCreateRequest;
use App\Http\Requests\Api\PostApiUpdateRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    private PostService $post_service;

    public function __construct(PostService $post_service)
    {
        $this->post_service=$post_service;

    }
    public function index(Request $request)
    {
        $posts = $this->post_service->getPosts($request);
        return (new ApiResponse((object)[
            'status' => 'success',
            'message' => 'post list',
            'data'=>$posts
        ]));

    }
    public function store(PostApiCreateRequest $request)
    {
        try {
            $post=$this->post_service->createPost($request);
            return (new ApiResponse((object)[
                'status' => 'success',
                'message' => 'post create',
                'data'=>$post
            ]))->response()->setStatusCode(201);
        }catch (\Exception $exception)
        {
            return (new ApiResponse((object)[
                'status' => 'fail',
                'message' => $exception->getMessage(),
            ]))->response()->setStatusCode(500);
        }
    }
    public function update(PostApiUpdateRequest $request, Post $post)
    {
        try {
            Gate::authorize('update', $post);
            $this->post_service->updatePost($request,$post);
            return (new ApiResponse((object)[
                'status' => 'success',
                'message' => 'post update',
                'data'=>$post
            ]))->response()->setStatusCode(200);
        }catch (AuthorizationException $authorizationException)
        {
            return (new ApiResponse((object)[
                'status' => 'fail',
                'message' => 'only admin or author can update',
            ]))->response()->setStatusCode(403);
        }
        catch (\Exception $exception) {
            return (new ApiResponse((object)[
                'status' => 'fail',
                'message' => $exception->getMessage(),
            ]))->response()->setStatusCode(500);
        }
    }
    public function destroy(Post $post)
    {
        try {
            Gate::authorize('delete', $post);
            $this->post_service->deletePost($post);
            return (new ApiResponse((object)[
                'status' => 'success',
                'message' => 'post delete',
                'data'=>$post
            ]))->response()->setStatusCode(200);
        }catch (AuthorizationException $authorizationException)
        {
            return (new ApiResponse((object)[
                'status' => 'fail',
                'message' => 'only admin  can delete',
            ]))->response()->setStatusCode(403);
        }
        catch (\Exception $exception) {
            return (new ApiResponse((object)[
                'status' => 'fail',
                'message' => $exception->getMessage(),
            ]))->response()->setStatusCode(500);
        }

    }
}
