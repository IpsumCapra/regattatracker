<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoatType extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    // A boat types has many boats
    public function boats()
    {
        return $this->belongsToMany(Boat::class)->withTimestamps();
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('description', 'LIKE', '%' . $query . '%');
    }
}
