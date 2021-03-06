<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuoyPosition extends Model
{
    protected $fillable = [
        'buoy_id',
        'latitude',
        'longitude',
        'created_at'
    ];

    // A buoy position belongs to an buoy
    public function buoy()
    {
        return $this->belongsTo(Buoy::class);
    }
}
