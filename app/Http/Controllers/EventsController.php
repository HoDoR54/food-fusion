<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Log;


class EventsController extends Controller
{
    public function index() {
        $events = Event::all();
        return view('events.index', ['events' => $events]);
    }

    public function show($id) {
        $event = Event::with(['organizer'])->findOrFail($id);
        return view('events.show', ['event' => $event]);
    }
}
