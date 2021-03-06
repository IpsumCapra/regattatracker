<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buoy;
use Illuminate\Http\Request;
use App\Rules\YoutubeVideo;

class AdminBuoysController extends Controller
{
    // Admin buoys index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $buoys = Buoy::search($query)->get();
        } else {
            $buoys = Buoy::all();
        }
        $buoys = $buoys->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin buoys index view
        return view('admin.buoys.index', ['buoys' => $buoys]);
    }

    // Admin buoys store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'description' => 'nullable|max:20000',
            'youtube_video' => [ 'nullable', new YoutubeVideo ]
        ]);

        // Create buoy
        $buoy = Buoy::create([
            'name' => $fields['name'],
            'description' => $fields['description'],
            'youtube_video' => $fields['youtube_video']
        ]);

        // Go to the new admin buoy page
        return redirect()->route('admin.buoys.show', $buoy);
    }

    // Admin buoys show route
    public function show(Buoy $buoy)
    {
        // Select buoy information
        $day = request('day');
        if ($day != null) {
            $time = strtotime($day);
        } else {
            $time = time();
        }
        $buoyPositions = $buoy->positionsByDay($time);

        // Return buoy show view
        return view('admin.buoys.show', [
            'buoy' => $buoy,

            'time' => $time,
            'buoyPositions' => $buoyPositions
        ]);
    }

    // Admin buoys track route
    public function track(Buoy $buoy)
    {
        // Get buoy positions of today
        $buoyPositions = $buoy->positionsByDay(time());

        // Return admin buoy track view
        return view('admin.buoys.track', [
            'buoy' => $buoy,
            'buoyPositions' => $buoyPositions
        ]);
    }

    // Admin buoys edit route
    public function edit(Buoy $buoy)
    {
        return view('admin.buoys.edit', ['buoy' => $buoy]);
    }

    // Admin buoys update route
    public function update(Request $request, Buoy $buoy)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'description' => 'nullable|max:20000',
            'youtube_video' => [ 'nullable', new YoutubeVideo ]
        ]);

        // Update buoy
        $buoy->update([
            'name' => $fields['name'],
            'description' => $fields['description'],
            'youtube_video' => $fields['youtube_video']
        ]);

        // Go to the admin buoy page
        return redirect()->route('admin.buoys.show', $buoy);
    }

    // Admin buoys delete route
    public function delete(Buoy $buoy)
    {
        // Delete buoy
        $buoy->delete();

        // Go to the buoys index page
        return redirect()->route('admin.buoys.index');
    }
}
