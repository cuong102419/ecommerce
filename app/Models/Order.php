<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'total_amount',
        'payment_method',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'note'
    ];
}
