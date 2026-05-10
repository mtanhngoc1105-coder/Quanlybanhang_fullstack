<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Mô hình Đơn hàng Tài xế
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Quan hệ với mô hình Đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Quan hệ với mô hình Sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
