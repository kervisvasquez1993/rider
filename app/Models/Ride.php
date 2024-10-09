<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ride extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'rides'; // Nombre de la tabla

    protected $fillable = [
        'client_id',
        'driver_id',
        'ride_request_id',
        'status',
        'start_time',
        'end_time',
    ];


    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the driver associated with the ride.
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * Get the vehicle associated with the ride.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
