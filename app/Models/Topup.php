<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    protected $table = 'topups';

    protected $fillable = [
        'player_id',
        'amount',
        'price',
        'payment_method',
        'merchant_ref',
        'status',
    ];
}
