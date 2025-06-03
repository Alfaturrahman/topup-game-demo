<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Tentukan nama tabel (jika berbeda dengan nama default tabel)
    protected $table = 'transactions';

    // Tentukan kolom yang boleh diisi
    protected $fillable = [
        'player_id', 
        'amount', 
        'payment_method', 
        'status',
        'merchant_ref',
    ];

}
