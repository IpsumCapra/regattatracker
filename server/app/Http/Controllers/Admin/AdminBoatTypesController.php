<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoatType;
use Illuminate\Http\Request;

class AdminBoatTypesController extends Controller
{
    // Admin boat types index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $boatTypes = BoatType::search($query)->get();
        } else {
            $boatTypes = BoatType::all();
        }
        $boatTypes = $boatTypes->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin boat type index view
        return view('admin.boat_types.index', ['boatTypes' => $boatTypes]);
    }

    // Admin boat types store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'description' => 'nullable|max:20000'
        ]);

        // Create boat type
        $boatType = BoatType::create([
            'name' => $fields['name'],
            'description' => $fields['description']
        ]);

        // Go to the new admin boat type page
        return redirect()->route('admin.boat_types.show', $boatType);
    }

    // Admin boat types show route
    public function show(BoatType $boatType)
    {
        // Get all boat type boats
        $boats = $boatType->boats->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin boat type show view
        return view('admin.boat_types.show', [
            'boatType' => $boatType,
            'boats' => $boats
        ]);
    }

    // Admin boat types edit route
    public function edit(BoatType $boatType)
    {
        return view('admin.boat_types.edit', ['boatType' => $boatType]);
    }

    // Admin boat types update route
    public function update(Request $request, BoatType $boatType)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'description' => 'nullable|max:20000'
        ]);

        // Update boat type
        $boatType->update([
            'name' => $fields['name'],
            'description' => $fields['description']
        ]);

        // Go to the admin boat type page
        return redirect()->route('admin.boat_types.show', $boatType);
    }

    // Admin boat types delete route
    public function delete(BoatType $boatType)
    {
        // Delete boat type
        $boatType->delete();

        // Go to the boat types index page
        return redirect()->route('admin.boat_types.index');
    }
}
