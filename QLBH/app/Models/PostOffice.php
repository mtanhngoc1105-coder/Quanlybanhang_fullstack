<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Mô hình Bưu cục
class PostOffice extends Model
{
    protected $fillable = [
        'seller_id',
        'branch_office',
        'post_add',
        'hotline',
        'operating_hour'
    ];

    // Quan hệ với mô hình Người bán
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
