<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use Illuminate\Http\Request;

class AdminCompetitionsController extends Controller
{
    // Admin competitions index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $competitions = Competition::search($query)->get();
        } else {
            $competitions = Competition::all();
        }
        $competitions = $competitions->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin boat index view
        return view('admin.competitions.index', ['competitions' => $competitions]);
    }

    // Admin competitions store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:255',
            'start_date' => 'nullable|date_format:Y-m-d',
            'start_time' => 'nullable|date_format:H:i',
            'end_date' => 'nullable|date_format:Y-m-d',
            'end_time' => 'nullable|date_format:H:i'
        ]);

        // Create Competition
        $competition = Competition::create([
            'name' => $fields['name'],
            'start' => $fields['start_date'] != null && $fields['start_time'] != null ? $fields['start_date'] . ' ' . $fields['start_time'] : null,
            'end' => $fields['end_date'] != null && $fields['end_time'] != null ? $fields['end_date'] . ' ' . $fields['end_time'] : null
        ]);

        // Go to the new competition show page
        return redirect()->route('admin.competitions.show', $competition);
    }

    // Admin competitions show route
    public function show(Competition $competition) {
        return view('admin.competitions.show', ['competition' => $competition]);
    }

    // Admin competitions edit route
    public function edit(Competition $competition) {
        return view('admin.competitions.edit', ['competition' => $competition]);
    }

    public function update(Request $request, Competition $competition) {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:255',
            'start_date' => 'nullable|date_format:Y-m-d',
            'start_time' => 'nullable|date_format:H:i',
            'end_date' => 'nullable|date_format:Y-m-d',
            'end_time' => 'nullable|date_format:H:i'
        ]);

        // Update competition
        $competition->update([
            'name' => $fields['name'],
            'start' => $fields['start_date'] != null && $fields['start_time'] != null ? $fields['start_date'] . ' ' . $fields['start_time'] : null,
            'end' => $fields['end_date'] != null && $fields['end_time'] != null ? $fields['end_date'] . ' ' . $fields['end_time'] : null
        ]);

        // Go to the competition show page
        return redirect()->route('admin.competitions.show', $competition);
    }

    // Admin competitions delete route
    public function delete(Competition $competition) {
        // Delete competition
        $competition->delete();

        // Go to the competition index page
        return redirect()->route('admin.competitions.index');
    }

}
