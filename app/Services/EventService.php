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

            $resData['data'] = $paginator->getCollection()->toArray();
            $resData['pagination'] = [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ];

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

    public function getEventById (string $id): BaseResponse
    {
        try {
            $event = Event::findOrFail($id);
            return new BaseResponse(
                true,
                'Event fetched successfully',
                200,
                $event
            );
        } catch (\Exception $e) {
            return new BaseResponse(false, $e->getMessage(), 500);
        }
    }

    public function registerUserToEvent(string $eventId): BaseResponse
    {
        try {
            $event = Event::findOrFail($eventId);
            $user = auth()->user();

            if (!$user) {
                return new BaseResponse(false, 'User not authenticated', 401);
            }

            // TO-DO: add real validation
            // if (!$event->canUserAttend($user)) {
            //     if ($event->attendees->contains($user)) {
            //         return new BaseResponse(false, 'You are already registered for this event', 400);
            //     }
                
            //     if ($event->end_time->isPast()) {
            //         return new BaseResponse(false, 'This event has already ended', 400);
            //     }
                
            //     if ($event->status !== \App\Enums\EventStatus::SCHEDULED) {
            //         return new BaseResponse(false, 'This event is not available for registration', 400);
            //     }
                
            //     return new BaseResponse(false, 'Cannot register for this event', 400);
            // }

            $event->attendees()->attach($user->id);

            return new BaseResponse(
                true,
                'Successfully registered for event',
                200,
                $event->load('attendees')
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

        if ($search->filled('status')) {
            $query->where('status', $search->input('status'));
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
