<?php

namespace App\Models;

use App\Pivots\EventClassFleetBoatPivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventClassFleet extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_class_id',
        'name'
    ];

    // A event class fleet belongs to an event class
    public function class()
    {
        return $this->belongsTo(EventClass::class);
    }

    // A event class fleet belongs to many boats
    public function boats()
    {
        return $this->belongsToMany(Boat::class, 'event_class_fleet_boat')
            ->withPivot('started_at', 'finished_at')->withTimestamps()
            ->using(EventClassFleetBoatPivot::class);
    }
}
