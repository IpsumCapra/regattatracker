<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use App\Models\BoatGuest;
use App\Models\User;
use Illuminate\Http\Request;

class BoatGuestController extends Controller
{
    // boat guest create route
    public function create(Boat $boat)
    {

        return view('boats.guests.create', [
            'boat' => $boat,
        ]);
    }


    public function store(Request $request, Boat $boat)
    {
        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2|max:48',
            'insertion' => 'nullable|max:16',
            'lastname' => 'required|min:2|max:48',
            'gender' => 'required|integer|digits_between:' . User::GENDER_MALE . ',' . User::GENDER_OTHER,
            'phone' => 'nullable|max:255',
        ]);

        // Create guest
        $boat->guests()->create([
            'firstname' => $fields['firstname'],
            'insertion' => $fields['insertion'],
            'lastname' => $fields['lastname'],
            'gender' => $fields['gender'],
            'phone' => $fields['phone'],
        ]);


        // Go back to the boat page
        return redirect()->route('boats.show', $boat);
    }

    // boat guest edit route
    public function edit(Boat $boat, BoatGuest $boatGuest)
    {
        return view('boats.guests.edit', [
            'boat' => $boat,
            'boatGuest' => $boatGuest
        ]);
    }

    // boat guest update route
    public function update(Request $request, Boat $boat, BoatGuest $boatGuest)
    {

        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2|max:48',
            'insertion' => 'nullable|max:16',
            'lastname' => 'required|min:2|max:48',
            'gender' => 'nullable|integer|digits_between:' . User::GENDER_MALE . ',' . User::GENDER_OTHER,
            'phone' => 'nullable|max:255',
        ]);

        // Update guest
        $boatGuest->update([
            'firstname' => $fields['firstname'],
            'insertion' => $fields['insertion'],
            'lastname' => $fields['lastname'],
            'gender' => $fields['gender'],
            'phone' => $fields['phone'],

        ]);

        // Go back to the boat page
        return redirect()->route('boats.show', $boat);
    }

    // boat guest delete route
    public function delete(Boat $boat, BoatGuest $boatGuest)
    {
        // Delete guest
        $boatGuest->delete();

        // Go back to the boat page
        return redirect()->route('boats.show', $boat);
    }
}