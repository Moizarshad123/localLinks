<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;


class VendorController extends Controller
{
    public function reviews(Request $request) {
        try {
          
            $reviews = Review::with("user", "media")->where("vendor_id",auth()->user()->id)->orderByDESC('id')->get();
            return $this->success($reviews);

        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
