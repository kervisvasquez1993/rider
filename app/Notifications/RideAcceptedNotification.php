<?php

namespace App\Notifications;

use App\Models\Ride;
use App\Models\Profile;
use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RideAcceptedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ride;
    protected $profile;
    protected $vehicle;

    /**
     * Create a new notification instance.
     *
     * @param Ride $ride
     * @param Profile $profile
     * @param Vehicle $vehicle
     */
    public function __construct(Ride $ride, Profile $profile, Vehicle $vehicle)
    {
        $this->ride = $ride;
        $this->profile = $profile;
        $this->vehicle = $vehicle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'ride_status' => $this->ride->status,
            'driver' => [
                'name' => $this->profile->name . ' ' . $this->profile->last_name,
                'phone' => $this->profile->phone,
                'license_plate' => $this->ride->driver->license_plate,
                'rating' => $this->ride->driver->rating,
            ],
            'vehicle' => [
                'name' => $this->vehicle->name,
                'max_passengers' => $this->vehicle->max_passengers,
            ],
        ];
    }
}
