<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Just a list with all the countries of the world in English
    const COUNTRIES = ["Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Central African Republic", "Chad", "Chile", "China", "Colombi", "Comoros", "Congo (Brazzaville)", "Congo", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor (Timor Timur)", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia, The", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia and Montenegro", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "Spain", "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"];

    // A user can be male, female or other
    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;
    const GENDER_OTHER = 2;

    // A user can be normal or an admin
    const ROLE_NORMAL = 0;
    const ROLE_ADMIN = 1;

    protected $fillable = [
        'firstname',
        'insertion',
        'lastname',
        'avatar',
        'gender',
        'birthday',
        'email',
        'phone',
        'address',
        'postcode',
        'city',
        'country',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birthday' => 'datetime',
        'email_verified_at' => 'datetime'
    ];

    // Generate a random avatar name
    public static function generateAvatarName($extension)
    {
        if ($extension == 'jpeg') $extension = 'jpg';
        return md5('user_avatar@' . microtime(true)) . '.' . $extension;
    }

    // Get user full name (firstname insertion lastname)
    public function getNameAttribute()
    {
        if ($this->insertion != null) {
            return $this->firstname . ' ' . $this->insertion . ' ' . $this->lastname;
        } else {
            return $this->firstname . ' ' . $this->lastname;
        }
    }

    // Get user sort name (lastname, insertion firstname)
    public function getSortNameAttribute()
    {
        if ($this->insertion != null) {
            return $this->lastname . ', ' . $this->insertion . ' ' . $this->firstname;
        } else {
            return $this->lastname . ' ' . $this->firstname;
        }
    }

    // A user belongs to many boats
    public function boats()
    {
        return $this->belongsToMany(Boat::class)->withPivot('role')->withTimestamps();
    }

    // A user belongs to many event class fleet boats
    public function eventClassFleetBoat()
    {
        return $this->belongsToMany(EventClassFleetBoat::class)->withTimestamps();
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('firstname', 'LIKE', '%' . $query . '%')
            ->orWhere('insertion', 'LIKE', '%' . $query . '%')
            ->orWhere('lastname', 'LIKE', '%' . $query . '%')
            ->orWhere('email', 'LIKE', '%' . $query . '%');
    }

    // Search collection by a query
    public static function searchCollection($collection, $query)
    {
        return $collection->filter(function ($user) use ($query) {
            return Str::contains(strtolower($user->firstname), strtolower($query)) ||
                Str::contains(strtolower($user->insertion), strtolower($query)) ||
                Str::contains(strtolower($user->lastname), strtolower($query)) ||
                Str::contains(strtolower($user->email), strtolower($query));
        });
    }

    // Get the current used api token from session storage or create a new one
    public function apiToken() {
        if (session('api_token') == null) {
            session(['api_token' => $this->createToken('API auth token for website')->plainTextToken]);
        }
        return session('api_token');
    }
}
