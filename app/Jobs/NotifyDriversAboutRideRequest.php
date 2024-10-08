<?php

namespace App\Jobs;

use App\Models\Client;
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
        $client = Client::with('profile')->find($this->rideRequest->client_id);
        if ($client) {
            $drivers = User::where('role', 'driver')->get();
            foreach ($drivers as $driver) {
                $driver->notify(new RideRequestCreated($this->rideRequest, $client->profile));
            }
        }
    }
}
