<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'profile_id', 
        'vehicle_id',
        'license_plate', 
        'rating',
        'status',
    ];

    /**
     * Get the profile associated with the driver.
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    /**
     * Get the vehicle associated with the driver.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the rides assigned to the driver.
     */
    public function rides()
    {
        return $this->hasMany(Ride::class, 'driver_id');
    }
}
