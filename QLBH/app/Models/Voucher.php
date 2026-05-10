<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Mô hình Phiếu giảm giá
class Voucher extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order',
        'start_date',
        'end_date',
        'quantity',
        'status',
    ];
}
