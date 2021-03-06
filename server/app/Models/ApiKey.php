<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    // The api key security levels
    const LEVEL_REQUIRE_AUTH = 0;
    const LEVEL_NO_AUTH = 1;

    protected $fillable = [
        'name',
        'key',
        'level'
    ];

    // Generate a random key
    public static function generateKey()
    {
        return md5('api_key@' . microtime(true)); // Secure???
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('name', 'LIKE', '%' . $query . '%');
    }
}
