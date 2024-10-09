<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletTransaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'wallet_transactions'; 
    protected $fillable = [
        'user_id',
        'amount',
        'ride_request_id',
        'status',
    ];
}
