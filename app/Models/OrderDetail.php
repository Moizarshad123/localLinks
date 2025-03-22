<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        "order_id",
        "vendor_id",
        "service_id",
        "service_name",
        "price",
        "qty"
    ];
}
