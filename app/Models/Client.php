<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'profile_id', // Relación con el perfil
        'loyalty_points', // Ejemplo de un campo específico para clientes
        'preferences', // Preferencias del cliente
    ];

    /**
     * Get the profile associated with the client.
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    /**
     * Get the rides associated with the client.
     */
    public function rides()
    {
        return $this->hasMany(Ride::class, 'client_id');
    }
}
