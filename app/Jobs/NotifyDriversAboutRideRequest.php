<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\RideRequestCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyDriversAboutRideRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rideRequest;

    public function __construct($rideRequest)
    {
        $this->rideRequest = $rideRequest;
    }

    public function handle()
    {
        // Busca a los conductores y les envía la notificación
        $drivers = User::where('role', 'driver')->get();
        foreach ($drivers as $driver) {
            $driver->notify(new RideRequestCreated($this->rideRequest));
        }
    }
}
