<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'base_fare',
        'rate_per_km',
        'rate_per_min',
        'max_passengers',
    ];

    /**
     * Get the driver that owns the vehicle.
     */
    public function driver()
    {
        return $this->hasOne(Driver::class);
    }

    /**
     * Get the rides associated with the vehicle.
     */
    public function rides()
    {
        return $this->hasMany(Ride::class);
    }
}
