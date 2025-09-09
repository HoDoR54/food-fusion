<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentCreateRequest;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\BlogSearchRequest;
use App\Http\Requests\SortRequest;
use App\Services\BlogService;
use App\Services\CloudinaryService;
use Illuminate\Support\Facades\Log;

class BlogsController extends Controller
{
    protected BlogService $_blogService;
    protected CloudinaryService $_cloudinaryService;

    public function __construct(BlogService $blogService, CloudinaryService $cloudinaryService) {
        $this->_blogService = $blogService;
        $this->_cloudinaryService = $cloudinaryService;
    }

    public function index(PaginationRequest $pagination, BlogSearchRequest $search, SortRequest $sort)
    {
        Log::info('controller index called');
        $response = $this->_blogService->getBlogs($pagination, $search, $sort);

        if (!$response->isSuccess()) {
            // Flash error message
            session()->flash('toastMessage', $response->getMessage());
            session()->flash('toastType', 'error');

            // Optional: redirect back instead of home, depending on UX
            return redirect()->back();
        }

        $data = $response->getData();
        $blogs = $data->getItems();
        $pagination = $data->getPagination();

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
        return response()->json(['success' => true, 'data' => $data->toArray()], 200);
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

    public function create()
    {
        return view('blogs.create', [
            'title' => 'Create New Blog Post',
        ]);
    }

    public function store(StoreBlogRequest $request)
    {
        $userId = auth()->id();
        $imageUrl = null;
        
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $result = $this->_cloudinaryService->uploadImage($request->file('image'), 'blogs');
            if (!$result->isSuccess()) {
                Log::warning('Blog image upload failed', [
                    'user_id' => $userId,
                    'error' => $result->getMessage(),
                    'file_name' => $request->file('image')->getClientOriginalName()
                ]);
                session()->flash('toastMessage', $result->getMessage());
                session()->flash('toastType', 'error');
                return back()->withInput();
            }
            $imageUrl = $result->getData()->secure_url;
            Log::info('Blog image uploaded successfully', [
                'user_id' => $userId,
                'image_url' => $imageUrl
            ]);
        }

        $res = $this->_blogService->storeBlog($request, $userId, $imageUrl);

        if ($res->isSuccess()) {
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'success');
            return redirect()->route('blogs.index');
        } else {
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');
            return back()->withInput();
        }
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
