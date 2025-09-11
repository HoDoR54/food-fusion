<?php

namespace App\Services;

use App\DTO\Responses\BaseResponse;
use App\DTO\Responses\PaginatedResponse;
use App\Enums\TagType;
use App\Http\Requests\BlogSearchRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\SortRequest;
use App\Http\Requests\StoreBlogRequest;
use App\Models\Blog;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlogService
{
    public function getBlogs(PaginationRequest $pagination, BlogSearchRequest $search, SortRequest $sort): BaseResponse
    {
        try {
            $query = Blog::query();

            $query->with(['author', 'tags', 'votes']);
            $this->attachSearchQuery($query, $search);
            $this->attachSortQuery($query, $sort);

            $paginator = $query->paginate(
                $pagination->input('size', 12),
                ['*'],
                'page',
                $pagination->input('page', 1)
            );

            $resData = $paginator->getCollection()->toArray();
            $paginatedRes = PaginatedResponse::fromPaginator($paginator, $resData);

            return new BaseResponse(true, 'Blogs retrieved successfully', 200, $paginatedRes);
        } catch (\Exception $e) {
            Log::error('Error retrieving paginated blogs: '.$e->getMessage());

            return new BaseResponse(false, 'Failed to retrieve blogs', 500);
        }
    }

    public function getBlogById($id): BaseResponse
    {
        try {
            $blog = Blog::findOrFail($id);

            return new BaseResponse(true, 'Blog retrieved successfully', 200, $blog);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return new BaseResponse(false, 'Blog not found', 404);
        } catch (\Exception $e) {
            Log::error('Error retrieving blog: '.$e->getMessage());

            return new BaseResponse(false, 'Failed to retrieve blog', 500);
        }
    }

    public function getBlogWithRelations($id): BaseResponse
    {
        try {
            $blog = Blog::with([
                'comments' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'comments.user',
                'tags',
                'author',
            ])->find($id);

            if (! $blog) {
                return new BaseResponse(false, 'Blog not found', 404);
            }

            return new BaseResponse(true, 'Blog retrieved successfully', 200, $blog);
        } catch (\Exception $e) {
            Log::error('Error retrieving blog with relations: '.$e->getMessage());

            return new BaseResponse(false, 'Failed to retrieve blog', 500);
        }
    }

    public function createComment($blogId, $userId, $content): BaseResponse
    {
        try {
            DB::beginTransaction();

            $blog = Blog::findOrFail($blogId);
            Log::info('Blog found: '.$blog->id);

            $comment = $blog->comments()->create([
                'user_id' => $userId,
                'content' => $content,
            ]);
            Log::info('Comment created: '.$comment->id);

            // Load user relationship for front-end display
            $comment->load('user');

            $responseData = [
                'comment' => $comment,
                'total_comments' => $blog->comments()->count(),
            ];

            DB::commit();

            return new BaseResponse(
                true,
                'Comment added successfully',
                201,
                $responseData
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();
            Log::error('Error creating comment: '.$e->getMessage());

            return new BaseResponse(false, 'Blog not found', 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating comment: '.$e->getMessage());

            return new BaseResponse(false, 'Failed to create comment', 500);
        }
    }

    public function upvoteBlog($blogId, User $user): BaseResponse
    {
        try {
            Log::info('Upvote service method called for blog ID: '.$blogId);
            Log::info('User authenticated: '.$user->id);

            $blog = Blog::findOrFail($blogId);
            Log::info('Blog found: '.$blog->id);

            $existingVote = $blog->getUserVote($user->id);
            Log::info('Existing vote: '.($existingVote ? $existingVote->direction : 'none'));

            DB::beginTransaction();

            if ($existingVote) {
                if ($existingVote->isUpvote()) {
                    $existingVote->delete();
                    $message = 'Upvote removed';
                    Log::info('Upvote removed');
                } else {
                    $existingVote->update(['direction' => 'up']);
                    $message = 'Changed to upvote';
                    Log::info('Changed to upvote');
                }
            } else {
                $newVote = $user->voteOnBlog($blog, 'up');
                $message = 'Upvoted successfully';
                Log::info('New upvote created: '.$newVote->id);
            }

            $upvotes = $blog->upvotes()->count();
            $downvotes = $blog->downvotes()->count();
            $voteScore = $upvotes - $downvotes;

            Log::info('Vote counts - Upvotes: '.$upvotes.', Downvotes: '.$downvotes.', Score: '.$voteScore);

            $responseData = [
                'upvotes' => $upvotes,
                'downvotes' => $downvotes,
                'vote_score' => $voteScore,
                'user_vote' => $blog->getUserVote($user->id)?->direction,
            ];

            DB::commit();

            return new BaseResponse(true, $message, 200, $responseData);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();

            return new BaseResponse(false, 'Blog not found', 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Upvote error: '.$e->getMessage());

            return new BaseResponse(false, 'An error occurred while voting', 500);
        }
    }

    public function downvoteBlog($blogId, User $user): BaseResponse
    {
        try {
            Log::info('Downvote service method called for blog ID: '.$blogId);
            Log::info('User authenticated: '.$user->id);

            $blog = Blog::findOrFail($blogId);
            Log::info('Blog found: '.$blog->id);

            // Check if user already voted
            $existingVote = $blog->getUserVote($user->id);
            Log::info('Existing vote: '.($existingVote ? $existingVote->direction : 'none'));

            DB::beginTransaction();

            if ($existingVote) {
                if ($existingVote->isDownvote()) {
                    // User already downvoted, remove the vote
                    $existingVote->delete();
                    $message = 'Downvote removed';
                    Log::info('Downvote removed');
                } else {
                    // User upvoted, change to downvote
                    $existingVote->update(['direction' => 'down']);
                    $message = 'Changed to downvote';
                    Log::info('Changed to downvote');
                }
            } else {
                // Create new downvote
                $newVote = $user->voteOnBlog($blog, 'down');
                $message = 'Downvoted successfully';
                Log::info('New downvote created: '.$newVote->id);
            }

            // Get fresh counts
            $upvotes = $blog->upvotes()->count();
            $downvotes = $blog->downvotes()->count();
            $voteScore = $upvotes - $downvotes;

            Log::info('Vote counts - Upvotes: '.$upvotes.', Downvotes: '.$downvotes.', Score: '.$voteScore);

            $responseData = [
                'upvotes' => $upvotes,
                'downvotes' => $downvotes,
                'vote_score' => $voteScore,
                'user_vote' => $blog->getUserVote($user->id)?->direction,
            ];

            DB::commit();

            return new BaseResponse(true, $message, 200, $responseData);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();

            return new BaseResponse(false, 'Blog not found', 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Downvote error: '.$e->getMessage());

            return new BaseResponse(false, 'An error occurred while voting', 500);
        }
    }

    public function getVoteStatus($blogId, ?User $user = null): BaseResponse
    {
        try {
            $blog = Blog::findOrFail($blogId);

            $upvotes = $blog->upvotes()->count();
            $downvotes = $blog->downvotes()->count();
            $voteScore = $upvotes - $downvotes;
            $userVote = $user ? $blog->getUserVote($user->id)?->direction : null;

            $responseData = [
                'upvotes' => $upvotes,
                'downvotes' => $downvotes,
                'vote_score' => $voteScore,
                'user_vote' => $userVote,
            ];

            return new BaseResponse(true, 'Vote status retrieved successfully', 200, $responseData);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return new BaseResponse(false, 'Blog not found', 404);
        } catch (\Exception $e) {
            Log::error('Get vote status error: '.$e->getMessage());

            return new BaseResponse(false, 'Failed to retrieve vote status', 500);
        }
    }

    public function attachSortQuery(Builder $query, SortRequest $sort): void
    {
        $allowedSortBy = ['created_at', 'updated_at', 'popularity'];

        $sortBy = $sort['sort_by'];
        $sortDirection = $sort['sort_direction'];

        if ($sortBy && $sortDirection && in_array($sortBy, $allowedSortBy)) {
            switch ($sortBy) {
                case 'popularity':
                    $query->withCount(['upvotes', 'downvotes'])
                        ->orderByRaw('(upvotes_count - downvotes_count) '.$sortDirection);
                    break;
                default:
                    $query->orderBy($sortBy, $sortDirection);
                    break;
            }
        }
    }

    public function attachSearchQuery(Builder $query, BlogSearchRequest $search): void
    {
        // TO-DO
    }

    public function storeBlog(StoreBlogRequest $request, ?string $userId = null, ?string $imageUrl = null): BaseResponse
    {
        try {
            DB::beginTransaction();

            $newBlog = Blog::create([
                'author_id' => $userId,
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'image_url' => $imageUrl,
            ]);

            // Attach tags if provided
            if ($request->has('tags')) {
                $this->attachTags($newBlog, $request->input('tags'));
            }

            DB::commit();

            return new BaseResponse(true, 'Blog post created successfully!', 201, $newBlog);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating blog: '.$e->getMessage(), [
                'request_data' => $request->validated(),
            ]);

            return new BaseResponse(false, 'Failed to create blog post. Please try again.', 500);
        }
    }

    // Support Methods
    public function getBlogCategories(): array
    {
        return Tag::where('type', TagType::BlogCategory->value)
            ->distinct()
            ->pluck('name')
            ->toArray();
    }

    public function getBlogTopics(): array
    {
        return Tag::where('type', TagType::BlogTopic->value)
            ->distinct()
            ->pluck('name')
            ->toArray();
    }

    // Helper Methods
    private function attachTags(Blog $blog, array $tags): void
    {
        $tagIds = [];

        foreach ($tags as $tagData) {
            if (empty($tagData['name'])) {
                continue;
            }

            $tag = Tag::firstOrCreate(
                [
                    'name' => $tagData['name'],
                    'type' => $tagData['type'] ?? TagType::BlogTopic->value,
                ]
            );

            $tagIds[] = $tag->id;
        }

        $blog->tags()->attach($tagIds);
    }
}
