<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\Driver;
use App\Models\Ride;
use App\Models\User;
use App\Models\RideRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\RideAcceptedNotification;
use Illuminate\Support\Facades\Log;

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
    public function __construct(RideRequest $rideRequest)
    {
        $this->rideRequest = $rideRequest;
  
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("calling job");
        // Log::info($this->ride);
        // $client = Client::where('id', $this->rideRequest->client_id)->first();
        // if ($client) {
        //     $driver = Driver::where('id', $this->ride->driver_id)->first();
        //     if ($driver) {
        //         Log::info('Driver found:', ['driver_id' => $driver->id]);
        //         // Verifica que el conductor tenga un perfil y un vehículo
        //         if ($driver->profile && $driver->vehicle) {
        //             Log::info('Driver has profile and vehicle:', [
        //                 'profile' => $driver->profile,
        //                 'vehicle' => $driver->vehicle,
        //             ]);

        //             // Notifica al cliente
        //             $client->notify(new RideAcceptedNotification(
        //                 $this->ride,
        //                 $driver->profile,
        //                 $driver->vehicle
        //             ));
        //         } else {
        //             Log::error('Driver is missing profile or vehicle:', [
        //                 'profile' => $driver->profile,
        //                 'vehicle' => $driver->vehicle,
        //             ]);
        //         }
        //     } else {
        //         Log::error("No se encontró un conductor con el ID proporcionado.");
        //     }
        // } else {
        //     Log::error("No se encontró un cliente con el ID proporcionado.");
        // }
    }
}
