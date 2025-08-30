<?php

namespace App\Services;

use App\Http\Requests\EventSearchRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\SortRequest;
use App\DTO\Responses\BaseResponse;
use App\Models\Event;

class EventService
{
    public function getEvents(EventSearchRequest $search, PaginationRequest $pagination, SortRequest $sort): BaseResponse
    {
        try {
            $query = Event::query();

            $this->attachSearchQuery($query, $search);
            $this->attachSorting($query, $sort);

            $paginator = $query->paginate(
                $pagination->input('size', 12),
                ['*'],
                'page',
                $pagination->input('page', 1)
            );

            $resData = $paginator->getCollection()->map(function (Event $event) {
                return ['event' => $event];
            })->toArray();

            return new BaseResponse(
                true,
                'Events fetched successfully',
                200,
                $resData
            );
        } catch (\Exception $e) {
            return new BaseResponse(false, $e->getMessage(), 500);
        }
    }

    private function attachSearchQuery($query, EventSearchRequest $search)
    {
        if ($search->filled('title')) {
            $query->where('title', 'like', '%' . $search->input('title') . '%');
        }

        if ($search->filled('location')) {
            $query->where('location', 'like', '%' . $search->input('location') . '%');
        }

        if ($search->filled('type')) {
            $query->where('type', $search->input('type'));
        }

        if ($search->filled('start_time')) {
            $query->whereDate('start_time', '>=', $search->input('start_time'));
        }

        if ($search->filled('end_time')) {
            $query->whereDate('end_time', '<=', $search->input('end_time'));
        }

        if ($search->filled('condition')) {
            $now = now();
            if ($search->input('condition') === 'upcoming') {
                $query->where('start_time', '>=', $now);
            } elseif ($search->input('condition') === 'past') {
                $query->where('end_time', '<', $now);
            }
        }


        return $query;
    }

    private function attachSorting($query, SortRequest $sort)
    {
        $allowedSortColumns = ['title', 'start_time', 'end_time', 'created_at', 'updated_at', 'location'];

        $sortBy = $sort->input('sort_by', 'start_time');
        $sortOrder = $sort->input('sort_direction', 'desc');

        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'start_time';
        }

        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        return $query->orderBy($sortBy, $sortOrder);
    }

}
