<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Models\Comment;
use App\Services\Comment\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controllers\Middleware;


class CommentController extends Controller
{
    private CommentService $comment_service;

    public function __construct(CommentService $comment_service)
    {
        $this->comment_service=$comment_service;
    }
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth:sanctum', except: ['store']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view', Comment::class);
        $comments= $this->comment_service->getComments();
        return view('comment.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentCreateRequest $request)
    {
        $this->comment_service->createComment($request);
        return redirect()->back()->with('success','comment added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function approve(Comment $comment)
    {
        Gate::authorize('approve', $comment);

        $comment->status = 'Approve';
        $comment->save();

        return redirect()->back()->with('success', 'Comment approved successfully.');
    }
    public function reject(Comment $comment)
    {
        Gate::authorize('reject', $comment);
        $comment->status = 'Reject';
        $comment->save();

        return redirect()->back()->with('success', 'Comment rejected successfully.');
    }

}
