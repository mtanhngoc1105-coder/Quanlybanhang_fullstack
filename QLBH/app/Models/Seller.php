<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Mô hình Người bán
class Seller extends Model
{
    protected $fillable = [
        'seller_name',
        'seller_phone_number'
    ];

    // Quan hệ với mô hình Bưu cục
    public function postOffices()
    {
        return $this->hasMany(PostOffice::class);
    }
}
