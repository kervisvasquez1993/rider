<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyDriversAboutRideRequest;
use App\Models\RideRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class RideRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'pickup_latitude' => 'required|numeric|between:-90,90',
                'pickup_longitude' => 'required|numeric|between:-180,180',
                'dropoff_latitude' => 'required|numeric|between:-90,90',
                'dropoff_longitude' => 'required|numeric|between:-180,180',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validación fallida',
                    'errors' => $validator->errors()
                ], Response::HTTP_BAD_REQUEST);
            }
            $client_id = auth()->user()->profile->client->id;
            $existingRequest = RideRequest::where('client_id', $client_id)
                ->whereIn('status', ['pending', 'accepted'])
                ->first();

            if ($existingRequest) {
                return response()->json([
                    'message' => 'Ya tienes una solicitud de carrera en progreso. No puedes realizar otra solicitud hasta que se resuelva la anterior.'
                ], Response::HTTP_CONFLICT);
            }
            $distance = $this->calculateDistance(
                $request->input('pickup_latitude'),
                $request->input('pickup_longitude'),
                $request->input('dropoff_latitude'),
                $request->input('dropoff_longitude')
            );
            $requestedAt = now()->toDateTimeString();
            $fare = $this->calculateFare($distance, $requestedAt);
            $dataToCreate = $request->only(['pickup_latitude', 'pickup_longitude', 'dropoff_latitude', 'dropoff_longitude']);
            $dataToCreate['client_id'] = $client_id;
            $dataToCreate['distance'] = $distance;
            $dataToCreate['fare'] = $fare;
            $dataToCreate['status'] = 'pending';
            $data = RideRequest::create($dataToCreate);
            NotifyDriversAboutRideRequest::dispatch($data);

            return response()->json([
                'message' => 'Recurso creado exitosamente',
                'data' => $data
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error interno',
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    protected function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;
        return $distance;
    }
    protected function calculateFare(float $distance, string $requestedAt): float
    {
        $dayRate = 0.80;
        $nightRate = 1.00;
        $baseFare = 0.00;
        $dateTime = \Carbon\Carbon::parse($requestedAt);
        $hour = $dateTime->format('H');
        if ($hour >= 6 && $hour < 22) {
            $costPerKm = $dayRate;
        } else {
            $costPerKm = $nightRate;
        }
        $fare = $baseFare + ($costPerKm * $distance);

        return round($fare, 2);
    }

    /**
     * Display the specified resource.
     */
    public function show(RideRequest $rideRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RideRequest $rideRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RideRequest $rideRequest)
    {
        //
    }
}
