<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
            "category_id",
            "type",
            "vendor_id",
            "name",
            "price",
            "location",
            "lat",
            "lng",
            "duration",
            "detail"
        ];
        
        public function images() {
            return $this->hasMany(ServiceImage::class, 'service_id');
        }

        public function category() {
            return $this->hasOne(Category::class, 'id', 'category_id');
        }
}
