<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatType;
use App\Models\BoatUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoatsController extends Controller {
    // Boats index route
    public function index() {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $boats = Boat::searchCollection(Auth::user()->boats, $query)->paginate(5);
        } else {
            $boats = Auth::user()->boats->paginate(5);
        }

        return view('boats.index', [ 'boats' => $boats ]);
    }

    // Boats store route
    public function store(Request $request) {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2'
        ]);

        // Create boat
        $boat = Boat::create([
            'user_id' => Auth::id(),
            'name' => $fields['name'],
            'description' => request('description')
        ]);

        // Add user to boat as captain
        BoatUser::create([
            'boat_id' => $boat->id,
            'user_id' => Auth::id(),
            'role' => BoatUser::ROLE_CAPTAIN
        ]);

        // Go to the new boat page
        return redirect()->route('boats.show', $boat);
    }

    // Boats show route
    public function show(Boat $boat) {
        $this->checkUser($boat);

        $boatTypes = $boat->boatTypes->paginate(5);
        $allBoatTypes = BoatType::all();

        $users = $boat->crewUsers->paginate(5);
        $allUsers = User::all();

        return view('boats.show', [
            'boat' => $boat,
            'boatTypes' => $boatTypes,
            'allBoatTypes' => $allBoatTypes,
            'users' => $users,
            'allUsers' => $allUsers
        ]);
    }

    // Boats edit route
    public function edit(Boat $boat) {
        $this->checkUser($boat);

        return view('boats.edit', [ 'boat' => $boat ]);
    }

    // Boats update route
    public function update(Request $request, Boat $boat) {
        $this->checkUser($boat);

        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2'
        ]);

        // Update boat
        $boat->update([
            'name' => $fields['name'],
            'description' => request('description')
        ]);

        // Go to the boat page
        return redirect()->route('boats.show', $boat);
    }

    // Boats delete route
    public function delete(Boat $boat) {
        $this->checkUser($boat);

        // Delete boat
        $boat->delete();

        // Go to the boats index page
        return redirect()->route('boats.index');
    }

    // Check if user is onwer of boat
    private function checkUser($boat) {
        if ($boat->user_id != Auth::id()) {
            abort(404);
        }
    }
}
