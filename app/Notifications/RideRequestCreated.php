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
    protected $clientProfile;
    public function __construct($rideRequest, $clientProfile)
    {
        $this->rideRequest = $rideRequest;
        $this->clientProfile = $clientProfile;
    }
    public function via($notifiable)
    {
        return ['database'];
    }
    public function toDatabase($notifiable)
    {
        return [
            'ride_request_id' => $this->rideRequest->id,
            'pickup_latitude' => $this->rideRequest->pickup_latitude,
            'pickup_longitude' => $this->rideRequest->pickup_longitude,
            'dropoff_latitude' => $this->rideRequest->dropoff_latitude,
            'dropoff_longitude' => $this->rideRequest->dropoff_longitude,
            'client_id' => $this->rideRequest->client_id,
            'client_name' => $this->clientProfile->name,
            'client_last_name' => $this->clientProfile->last_name,
            'client_phone' => $this->clientProfile->phone,
            'status' => $this->rideRequest->status,
            'requested_at' => $this->rideRequest->requested_at,
        ];
    }
}
