<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use App\Models\Buoy;

class PagesController extends Controller
{
    // Home route
    public function home()
    {
        // Variable to check if boats or buoys position data exists
        $itemsData = false;

        // Get all boats and there positions of today
        $boats = Boat::all();
        $goodBoats = collect();
        foreach ($boats as $boat) {
            $boat->positions = $boat->positionsByDay(time());

            if ($boat->positions->count() > 0) {
                $itemsData = true;
                $goodBoats->push($boat);
            }
        }

        // Get all boats and there positions of today
        $buoys = Buoy::all();
        $goodBuoys = collect();
        foreach ($buoys as $buoy) {
            $buoy->positions = $buoy->positionsByDay(time());

            if ($buoy->positions->count() > 0) {
                $itemsData = true;
                $goodBuoys->push($buoy);
            }
        }

        // Return the home route
        return view('home', [
            'itemsData' => $itemsData,
            'boats' => $goodBoats,
            'buoys' => $goodBuoys
        ]);
    }
}
