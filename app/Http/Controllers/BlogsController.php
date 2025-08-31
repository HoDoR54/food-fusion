<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentCreateRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\BlogSearchRequest;
use App\Http\Requests\SortRequest;
use App\Services\BlogService;
use Illuminate\Support\Facades\Log;

class BlogsController extends Controller
{
    protected BlogService $_blogService;

    public function __construct(BlogService $blogService) {
        $this->_blogService = $blogService;
    }

    public function index(PaginationRequest $pagination, BlogSearchRequest $search, SortRequest $sort)
    {
        $response = $this->_blogService->getBlogs($pagination, $search, $sort);

        if (!$response->isSuccess()) {
            // Flash error message
            session()->flash('toastMessage', $response->getMessage());
            session()->flash('toastType', 'error');

            // Optional: redirect back instead of home, depending on UX
            return redirect()->back();
        }

        // Extract data from BaseResponse for cleaner view usage
        $resData = $response->getData() ?? [];
        $blogs = $resData['data'] ?? [];
        $pagination = $resData['pagination'] ?? [];

        return view('blogs.index', [
            'blogs' => $blogs,
            'pagination' => $pagination,
            'title' => 'Community Cookbook',
        ]);
    }

    // For AJAX
    public function getAll(PaginationRequest $pagination, BlogSearchRequest $search, SortRequest $sort) {
        $response = $this->_blogService->getBlogs($pagination, $search, $sort);

        if (!$response->isSuccess()) {
            return response()->json(['success' => false, 'message' => $response->getMessage()], $response->getStatusCode());
        }

        $data = $response->getData();
        return response()->json(['success' => true, 'data' => $data], 200);
    }


    public function show($id)
    {
        $response = $this->_blogService->getBlogWithRelations($id);
        
        if (!$response->isSuccess()) {
            if ($response->getStatusCode() === 404) {
                abort(404, $response->getMessage());
            }
            return redirect()->back()->with('error', $response->getMessage());
        }
        
        $blog = $response->getData();
        return view('blogs.show', compact('blog'));
    }

    public function createComment(BlogCommentCreateRequest $request, $blogId)
    {
        $response = $this->_blogService->createComment(
            $blogId, 
            auth()->id(), 
            $request->input('content')
        );

        Log::info('Comment creation response: ' . $response->getMessage());

        if ($response->isSuccess()) {
            $data = $response->getData();
            Log::info('Response:' . json_encode($data));
            return response()->json([
                'success' => true,
                'message' => $response->getMessage(),
                'comment' => [
                    'id' => $data['comment']->id,
                    'content' => $data['comment']->content,
                    'user_name' => $data['comment']->user->name,
                    'created_at' => $data['comment']->created_at->diffForHumans(),
                    'formatted_date' => $data['comment']->created_at->format('Y-m-d H:i:s')
                ],
                'total_comments' => $data['total_comments']
            ], $response->getStatusCode());
        } else {
            Log::error('Comment creation failed: ' . $response->getMessage());
            return response()->json([
                'success' => false,
                'message' => $response->getMessage(),
                'errors' => ['general' => [$response->getMessage()]]
            ], $response->getStatusCode());
        }
    }

    public function upvote($blogId) {
        $user = auth()->user();

        $response = $this->_blogService->upvoteBlog($blogId, $user);
        
        if ($response->isSuccess()) {
            $data = $response->getData();
            return response()->json([
                'success' => true,
                'message' => $response->getMessage(),
                'upvotes' => $data['upvotes'],
                'downvotes' => $data['downvotes'],
                'vote_score' => $data['vote_score'],
                'user_vote' => $data['user_vote']
            ], $response->getStatusCode());
        } else {
            return response()->json([
                'success' => false, 
                'message' => $response->getMessage()
            ], $response->getStatusCode());
        }
    }

    public function downvote($blogId) {
        $user = auth()->user();
        if (!$user) {
            \Log::warning('User not authenticated for downvote');
            return response()->json(['success' => false, 'message' => 'You must be logged in to vote.'], 401);
        }

        $response = $this->_blogService->downvoteBlog($blogId, $user);
        
        if ($response->isSuccess()) {
            $data = $response->getData();
            return response()->json([
                'success' => true,
                'message' => $response->getMessage(),
                'upvotes' => $data['upvotes'],
                'downvotes' => $data['downvotes'],
                'vote_score' => $data['vote_score'],
                'user_vote' => $data['user_vote']
            ], $response->getStatusCode());
        } else {
            return response()->json([
                'success' => false, 
                'message' => $response->getMessage()
            ], $response->getStatusCode());
        }
    }

    public function getVoteStatus($blogId) {
        $user = auth()->user();
        $response = $this->_blogService->getVoteStatus($blogId, $user);
        
        if ($response->isSuccess()) {
            $data = $response->getData();
            return response()->json([
                'success' => true,
                'upvotes' => $data['upvotes'],
                'downvotes' => $data['downvotes'],
                'vote_score' => $data['vote_score'],
                'user_vote' => $data['user_vote']
            ], $response->getStatusCode());
        } else {
            return response()->json([
                'success' => false, 
                'message' => $response->getMessage()
            ], $response->getStatusCode());
        }
    }

}
