<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentCreateRequest;
use App\Models\Blog;

class BlogsController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return view('blogs.index', compact('blogs'));
    }

    public function show($id)
    {
        $blog = Blog::with('comments.user', 'tags', 'author')->find($id);
        return view('blogs.show', compact('blog'));
    }

    public function createComment(BlogCommentCreateRequest $request, $blogId)
    {
        try {
            $blog = Blog::findOrFail($blogId);
            
            $comment = $blog->comments()->create([
                'user_id' => auth()->id(),
                'content' => $request->input('content'),
            ]);

            // Load the user relationship for the response
            $comment->load('user');

            // If it's an AJAX request, return JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Comment added successfully.',
                    'comment' => [
                        'id' => $comment->id,
                        'content' => $comment->content,
                        'user_name' => $comment->user->name,
                        'created_at' => $comment->created_at->diffForHumans(),
                        'formatted_date' => $comment->created_at->format('Y-m-d H:i:s')
                    ],
                    'total_comments' => $blog->comments()->count()
                ], 201);
            }

            return redirect()->back()->with('success', 'Comment added successfully.');
            
        } catch (\Exception $e) {
            \Log::error('Comment creation error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while adding the comment.',
                    'errors' => ['general' => ['Something went wrong. Please try again.']]
                ], 500);
            }

            return redirect()->back()->with('error', 'An error occurred while adding the comment.');
        }
    }
}
