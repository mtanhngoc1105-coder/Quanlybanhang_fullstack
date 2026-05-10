<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Mô hình Đánh giá
class Review extends Model
{
    protected $fillable = [
        'order_id',
        'customer_id',
        'rating',
        'comment',
    ];

    // Quan hệ với mô hình Đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Quan hệ với mô hình Khách hàng
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
