<?php

namespace App\Notifications;

use App\Models\RideRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Notification;

class RideRequestCreated extends Notification implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $rideRequest;

    public function __construct(RideRequest $rideRequest)
    {
        $this->rideRequest = $rideRequest;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'ride_request_id' => $this->rideRequest->id,
            'pickup_location' => $this->rideRequest->pickup_location,
            'dropoff_location' => $this->rideRequest->dropoff_location,
            'status' => $this->rideRequest->status,
            'requested_at' => $this->rideRequest->requested_at,
        ];
    }
}
