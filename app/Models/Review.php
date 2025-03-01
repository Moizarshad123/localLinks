<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        "booking_id",
        "user_id",
        "vendor_id",
        "rating",
        "review"
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function media() {
        return $this->hasMany(ReviewDetail::class, 'review_id');
    }

}
