<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$events = Event::all();

        return Inertia::render('Event/Index', [
                'events' => Event::all()->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'event_date' => $event->event_date
                    ];
                }),
                'create_url' => route('events.create'),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Event/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required'
        ]);
        Event::create([
            'title' => $request->title,
            'event_date' => $request->event_date
        ]);

        return redirect()->route('events.index')->with('message', 'Event Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return Inertia::render(
            'Event/Edit',
            [
                'event' => $event
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required'
        ]);

        $event->title = $request->title;
        $event->event_date = $request->event_date;
        $event->save();

        return redirect()->route('events.index')->with('message', 'Event Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('message', 'Event Delete Successfully');
    }

    /**
     * Show the selected events between twos dates
     */

    public function showSelectedEvent(Request $request)
    {
        $start = $request->startDate;
        $end = $request->endDate;

        $updatedEvents = Event::scheduledAtBetween($start, $end)->get();

        return Inertia::render('Event/Index', [
                'events' => Event::scheduledAtBetween($start, $end)->get()->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'event_date' => $event->event_date
                    ];
                }),
                'create_url' => route('events.create'),
            ]);


    }
}
