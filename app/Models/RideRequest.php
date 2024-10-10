<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RideRequest extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ride_requests';
    protected $fillable = [
        'client_id',
        'pickup_latitude',
        'pickup_longitude',
        'dropoff_latitude',
        'dropoff_longitude',
        'distance',
        'fare',
        'requested_at',
        'status',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
