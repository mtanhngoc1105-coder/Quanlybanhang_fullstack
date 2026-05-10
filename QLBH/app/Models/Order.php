<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'promo_code',
        'post_office_id',
        'shipping_fee',
        'total_amount',
        'dest_address',
        'order_date',
        'payment_status',
        'shipping_status',
        'note'
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relationships
    public function postOffice()
    {
        return $this->belongsTo(PostOffice::class);
    }

    
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'promo_code', 'code');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
