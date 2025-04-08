<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "vendor_id",
        "service_id",
        "card_id",
        "amount",
        "date",
        "time",
        "location",
        "lat",
        "lng",
        "block",
        "room",
        "appartment",
        "note",
        "status",
    ];
}
