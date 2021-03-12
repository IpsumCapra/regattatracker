<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatType;
use App\Models\BoatUser;
use App\Models\User;
use Illuminate\Http\Request;

class AdminBoatsController extends Controller {
    // Admin boats index route
    public function index() {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $boats = Boat::search($query)->get();
        } else {
            $boats = Boat::all();
        }
        $boats = $boats->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->paginate(5)->withQueryString();

        return view('admin.boats.index', [ 'boats' => $boats ]);
    }

    // Admin boats create route
    public function create() {
        $users = User::all()->sortBy('firstname', SORT_NATURAL | SORT_FLAG_CASE);
        return view('admin.boats.create', [ 'users' => $users ]);
    }

    // Admin boats store route
    public function store(Request $request) {
        // Validate input
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|min:2'
        ]);

        // Create boat
        $boat = Boat::create([
            'name' => $fields['name'],
            'description' => request('description')
        ]);

        // Add user to boat as captain
        BoatUser::create([
            'boat_id' => $boat->id,
            'user_id' => $fields['user_id'],
            'role' => BoatUser::ROLE_CAPTAIN
        ]);

        // Go to the new admin boat page
        return redirect()->route('admin.boats.show', $boat);
    }

    // Admin boats show route
    public function show(Boat $boat) {
        $boatBoatTypes = $boat->boatTypes->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->paginate(5)->withQueryString();
        $boatTypes = BoatType::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

        $boatUsers = $boat->users->sortBy('firstname', SORT_NATURAL | SORT_FLAG_CASE)->paginate(5)->withQueryString();
        $boatCaptains = $boatUsers->filter(function ($user) { return $user->pivot->role == BoatUser::ROLE_CAPTAIN; });
        $users = User::all()->sortBy('firstname', SORT_NATURAL | SORT_FLAG_CASE);

        return view('admin.boats.show', [
            'boat' => $boat,
            'boatBoatTypes' => $boatBoatTypes,
            'boatTypes' => $boatTypes,
            'boatUsers' => $boatUsers,
            'boatCaptains' => $boatCaptains,
            'users' => $users
        ]);
    }

    // Admin boats edit route
    public function edit(Boat $boat) {
        return view('admin.boats.edit', [ 'boat' => $boat ]);
    }

    // Admin boats update route
    public function update(Request $request, Boat $boat) {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2'
        ]);

        // Update boat
        $boat->update([
            'name' => $fields['name'],
            'description' => request('description')
        ]);

        // Go to the admin boat page
        return redirect()->route('admin.boats.show', $boat);
    }

    // Admin boats delete route
    public function delete(Boat $boat) {
        // Delete boat
        $boat->delete();

        // Go to the boats index page
        return redirect()->route('admin.boats.index');
    }
}