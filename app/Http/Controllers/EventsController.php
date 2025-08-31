<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\EventSearchRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\SortRequest;
use App\Services\EventService;

class EventsController extends Controller
{   
    protected EventService $_eventService;

    public function __construct(EventService $eventService) {
        $this->_eventService = $eventService;
    }

    // Page view
    public function index(EventSearchRequest $search, PaginationRequest $pagination, SortRequest $sort) {
        $serviceRes = $this->_eventService->getEvents($search, $pagination, $sort);

        if (!$serviceRes->isSuccess()) {
            return redirect()->back()->with([
                'toastMessage' => $serviceRes->getMessage(),
                'toastType' => 'error'
            ]);
        }

        $resData = $serviceRes->getData();

        return view('events.index', [
            'events' => $resData['data'] ?? [],
            'pagination' => $resData['pagination'] ?? [],
            'title' => 'Events',
        ]);
    }

    // AJAX response
    public function getEvents(EventSearchRequest $search, PaginationRequest $pagination, SortRequest $sort) 
    {
        Log::info('getEvents hit');
        $serviceRes = $this->_eventService->getEvents($search, $pagination, $sort);

        if (!$serviceRes->isSuccess()) {
            Log::info('getEvents failed: ' . $serviceRes->getMessage());
            return response()->json([
                'message' => $serviceRes->getMessage(),
                'data' => null,
                'pagination' => null
            ], $serviceRes->getStatusCode());
        }

        $resData = $serviceRes->getData();

        Log::info('getEvents successful', $resData);

        return response()->json([
            'message' => $serviceRes->getMessage(),
            'data' => $resData['data'] ?? [],
            'pagination' => $resData['pagination'] ?? []
        ]);
    }

    public function show($id) {
        $event = $this->_eventService->getEventById($id);
        return view('events.show', ['event' => $event]);
    }
}
