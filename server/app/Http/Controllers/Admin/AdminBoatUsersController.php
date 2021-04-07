<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBoatUsersController extends Controller
{
    // Admin boat users store route
    public function store(Request $request, Boat $boat)
    {
        // Validate input
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|integer|digits_between:' . BoatUser::ROLE_CREW . ',' . BoatUser::ROLE_CAPTAIN
        ]);

        // Create boat user connection
        $boat->users()->attach($fields['user_id'], [
            'role' => $fields['role']
        ]);

        // Go back to the boat page
        return redirect()->route('admin.boats.show', $boat);
    }

    // Admin boat users update route
    public function update(Request $request, Boat $boat, User $user)
    {
        // Validate input
        $fields = $request->validate([
            'role' => 'required|integer|digits_between:' . BoatUser::ROLE_CREW . ',' . BoatUser::ROLE_CAPTAIN
        ]);

        // Check if user is not the last capatain
        if ($fields['role'] == BoatUser::ROLE_CREW) {
            $boatUser = $boat->users->firstWhere('id', $user->id);
            $boatCaptains = $boat->users->filter(function ($user) {
                return $user->pivot->role == BoatUser::ROLE_CAPTAIN;
            });
            if ($boatUser->pivot->role == BoatUser::ROLE_CAPTAIN && $boatCaptains->count() <= 1) {
                return redirect()->route('admin.boats.show', $boat);
            }
        }

        // Update boat user connection
        $boat->users()->updateExistingPivot($user, [
            'role' => $fields['role']
        ]);

        // Go back to the boat page
        return redirect()->route('admin.boats.show', $boat);
    }

    // Admin boat users delete route
    public function delete(Request $request, Boat $boat, User $user)
    {
        // Check if user is not the last capatain
        $boatUser = $boat->users->firstWhere('id', $user->id);
        $boatCaptains = $boat->users->filter(function ($user) {
            return $user->pivot->role == BoatUser::ROLE_CAPTAIN;
        });
        if ($boatUser->pivot->role == BoatUser::ROLE_CAPTAIN && $boatCaptains->count() <= 1) {
            return redirect()->route('admin.boats.show', $boat);
        }

        // Delete boat user connection
        $boat->users()->detach($user);

        // Go back to the boat page
        return redirect()->route('admin.boats.show', $boat);
    }
}