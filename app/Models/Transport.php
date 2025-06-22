<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
      protected $fillable = [
        'route_name',
        'pickup_time',
        'drop_time',
        'vehicle_number',
        'vehicle_capacity',
        'driver_name',
        'license_number',
        'phone_number',
    ];
}
