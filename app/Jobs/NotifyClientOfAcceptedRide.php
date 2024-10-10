<?php

namespace App\Jobs;

use App\Models\Driver;
use App\Models\User;
use App\Models\RideRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\RideAcceptedNotification;

class NotifyClientOfAcceptedRide implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rideRequest;
    protected $ride;

    /**
     * Create a new job instance.
     *
     * @param RideRequest $rideRequest
     */
    public function __construct(RideRequest $rideRequest, RideRequest $ride)
    {
        $this->rideRequest = $rideRequest;
        $this->ride = $ride;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $client = User::whereHas('profile.client', function ($query) {
            $query->where('id', $this->rideRequest->client_id);
        })->first();
        if ($client) {
            $driver = auth()->user()->profile->driver->load(['profile', 'vehicle']);
            if ($driver && $driver->profile && $driver->vehicle) {

                $client->notify(new RideAcceptedNotification(
                    $this->ride,
                    $driver->profile,
                    $driver->vehicle
                ));
            }
        }
    }
}
