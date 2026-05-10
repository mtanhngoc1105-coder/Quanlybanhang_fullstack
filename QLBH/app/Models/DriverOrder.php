<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Mô hình Đơn hàng Tài xế
class DriverOrder extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'driver_id',
        'assign_date',
    ];

    // Quan hệ với mô hình Đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Quan hệ với mô hình Tài xế
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
