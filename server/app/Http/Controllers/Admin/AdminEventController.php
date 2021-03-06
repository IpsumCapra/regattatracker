<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    // Admin events index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $events = Event::search($query)->get();
        } else {
            $events = Event::all();
        }
        $events = $events->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin boat index view
        return view('admin.events.index', ['events' => $events]);
    }

    // Admin events store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'start' => 'nullable|date_format:Y-m-d',
            'end' => 'nullable|date_format:Y-m-d',
            'connected' => 'required|integer|digits_between:' . Event::CONNECTED_FALSE . ',' . Event::CONNECTED_TRUE
        ]);

        // Create Event
        $event = Event::create([
            'name' => $fields['name'],
            'start' => $fields['start'],
            'end' => $fields['end'],
            'connected' => $fields['connected'],
            'path' => '[]'
        ]);

        // Go to the new event show page
        return redirect()->route('admin.events.show', $event);
    }

    // Admin events show route
    public function show(Event $event)
    {
        // Get all the events finishes
        $eventFinishes = $event->finishes->paginate(config('pagination.web.limit'))->withQueryString();

        // Get all the events classes
        $eventClasses = $event->classes->paginate(config('pagination.web.limit'))->withQueryString();

        // Return the admin event show page
        return view('admin.events.show', [
            'event' => $event,
            'eventFinishes' => $eventFinishes,
            'eventClasses' => $eventClasses
        ]);
    }

    // Admin events timer route
    public function timer(Event $event)
    {
        // Get all the event class fleet boats
        $eventClassFleetBoats = [];
        foreach ($event->classes as $eventClass) {
            foreach ($eventClass->fleets as $eventClassFleet) {
                foreach ($eventClassFleet->boats as $eventClassFleetBoat) {
                    $eventClassFleetBoat->pivot->event_class_id = $eventClass->id;
                    $eventClassFleetBoats[] = $eventClassFleetBoat;
                }
            }
        }

        // Return the admin event timer page
        return view('admin.events.timer', [
            'event' => $event,
            'eventClassFleetBoats' => $eventClassFleetBoats
        ]);
    }

    // Admin events edit route
    public function edit(Event $event)
    {
        return view('admin.events.edit', ['event' => $event]);
    }

    // Admin events update route
    public function update(Request $request, Event $event)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'start' => 'nullable|date_format:Y-m-d',
            'end' => 'nullable|date_format:Y-m-d',
            'connected' => 'required|integer|digits_between:' . Event::CONNECTED_FALSE . ',' . Event::CONNECTED_TRUE
        ]);

        // Update event
        $event->update([
            'name' => $fields['name'],
            'start' => $fields['start'],
            'end' => $fields['end'],
            'connected' => $fields['connected']
        ]);

        // Update event path when given
        if (request('path') != '') {
            $fields = $request->validate([
                'path' => 'required|json',
            ]);

            $event->update([
                'path' => $fields['path']
            ]);
        }

        // Go to the event show page
        return redirect()->route('admin.events.show', $event);
    }

    // Admin events delete route
    public function delete(Event $event)
    {
        // Delete event
        $event->delete();

        // Go to the event index page
        return redirect()->route('admin.events.index');
    }
}
