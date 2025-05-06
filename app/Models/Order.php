<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "vendor_id",
        "username",
        "phone",
        "billing_address",
        "shipping_address",
        "zip_code",
        "total_amount",
        "total_qty",
        "status"
    ];

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class);
    }


}
