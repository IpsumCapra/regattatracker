<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Boat extends Model
{
    protected $fillable = [
        'name',
        'description',
        'mmsi',
        'length',
        'breadth',
        'weight',
        'sail_number',
        'sail_area'
    ];

    // Get the Klipperrace rating of the boat
    public function getKlipperraceRatingAttribute()
    {
        return $this->length * $this->sail_area / sqrt($this->breadth * $this->weight);
    }

    // A boat has many positions
    public function positions()
    {
        return $this->hasMany(BoatPosition::class);
    }

    // Get boat positions by day
    public function positionsByDay($time)
    {
        if ($time > time()) {
            return collect();
        }

        $day = $time - ($time % (24 * 60 * 60));

        $positions = $this->positions()
            ->where('created_at', '>=', date('Y-m-d', $day))
            ->where('created_at', '<', date('Y-m-d', $day + 24 * 60 * 60))
            ->get();

        if ($positions->count() == 0) {
            $positions = $this->positions()
                ->where('created_at', '<', date('Y-m-d', $day + 24 * 60 * 60))
                ->orderByDesc('created_at');

            if ($positions->count() > 0) {
                $position = $positions->first();

                if ($time >= $position->created_at->getTimestamp()) {
                    return collect([$position]);
                }
            }

            return collect();
        } else {
            return $positions;
        }
    }

    // A boat belongs to many boat types
    public function boatTypes()
    {
        return $this->belongsToMany(BoatType::class)->withTimestamps();
    }

    // A boat belongs to many users
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('description', 'LIKE', '%' . $query . '%');
    }

    // Search collection by a query
    public static function searchCollection($collection, $query)
    {
        return $collection->filter(function ($boat) use ($query) {
            return Str::contains(strtolower($boat->name), strtolower($query)) ||
                Str::contains(strtolower($boat->description), strtolower($query));
        });
    }
}
