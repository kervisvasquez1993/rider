<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RideTrip extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ride_trips'; 
    protected $fillable = [
        'ride_id',
        'pickup_time',
        'status',
        'pickup_location',
    ];
}
