<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Mô hình Khách hàng
class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];
}
