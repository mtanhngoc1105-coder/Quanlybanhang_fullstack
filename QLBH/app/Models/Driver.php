<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Mô hình Tài xế
class Driver extends Model
{
    protected $fillable = [
        'driver_name',
        'driver_phone',
        'status',
        'plate_number',
    ];
}
