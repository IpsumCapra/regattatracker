<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventClass;
use App\Models\Fleet;
use Illuminate\Http\Request;

class AdminFleetsController extends Controller
{
    // Admin fleet create route
    public function create(Event $event, EventClass $class) {
        return view('admin.events.classes.fleets.create', ['event' => $event, 'class' => $class]);
    }

    // Admin fleet store route
    public function store(Request $request, Event $event, EventClass $class) {
        $fields = $request->validate([
            'name' => 'required|max:255'
        ]);

        Fleet::create([
            'name' => $fields['name'],
            'event_class_id' => $class->id
        ]);

        return redirect()->route('admin.events.show', ['event' => $event]);
    }

    // Admin fleet update route
    public function update(Request $request, Event $event, EventClass $class, Fleet $fleet) {
        $fields = $request->validate([
            'name' => 'required|max:255'
        ]);

        $fleet->update([
            'name' => $fields['name']
        ]);

        return redirect()->route('admin.events.show', ['event' => $event]);
    }

    // Admin fleet edit route
    public function edit(Event $event, EventClass $class, Fleet $fleet) {
        return view('admin.events.classes.fleets.edit', ['event' => $event, 'class' => $class, 'fleet' => $fleet]);
    }

    // Admin fleet delete route
    public function delete(Event $event, EventClass $class, Fleet $fleet) {
        $fleet->delete();

        return redirect()->route('admin.events.show', ['event' => $event]);
    }
}
