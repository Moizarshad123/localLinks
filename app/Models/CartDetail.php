<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        "cart_id",
        "vendor_id",
        "service_id",
        "service_name",
        "price",
        "qty"
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
