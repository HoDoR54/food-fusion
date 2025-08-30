<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
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

    public function index(EventSearchRequest $search, PaginationRequest $pagination, SortRequest $sort) {
        $serviceRes = $this->_eventService->getEvents($search, $pagination, $sort);

        if (!$serviceRes->isSuccess()) {
            return redirect()->back()->with([
                'toastMessage' => $serviceRes->getMessage(),
                'toastType' => 'error'
            ]);
        }

        return view('events.index', [
            'res' => $serviceRes,
            'title' => 'Events',
        ]);
    }

    // for AJAX
    public function getEvents(EventSearchRequest $search, PaginationRequest $pagination, SortRequest $sort) 
    {
        Log::info('getEvents hit');
        $serviceRes = $this->_eventService->getEvents($search, $pagination, $sort);

        if (!$serviceRes->isSuccess()) {
            Log::info('getEvents failed: ' . $serviceRes->getMessage());
            return response()->json([
                'message' => $serviceRes->getMessage(),
                'data' => null
            ], $serviceRes->getStatusCode());
        }

        Log::info('getEvents successful' . json_encode($serviceRes->getData()));
        return response()->json([
            'message' => 'Events fetched successfully',
            'data' => $serviceRes->getData()
        ]);
    }

    public function show($id) {
        $event = $this->_eventService->getEventById($id);
        return view('events.show', ['event' => $event]);
    }
}
