<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Service;
use App\Models\OrderDetail;
use DB;



class VendorController extends Controller
{
    public function dashboard() {
        try {
          
            $services = Service::where('vendor_id', auth()->user()->id)->count();
            $orders   = OrderDetail::where('vendor_id', auth()->user()->id)
                                ->groupBy('order_id')
                                ->get()
                                ->count();
            $revenue   = OrderDetail::where('vendor_id', auth()->user()->id)
                                ->groupBy('order_id')
                                ->get()
                                ->sum('price');

            $reviews = Review::where("vendor_id",auth()->user()->id)->count();
            $arr=[
                "services"=>$services,
                "orders"=>$orders,
                "rating"=>auth()->user()->rating,
                "reviews"=>$reviews,
                "revenue"=>$revenue

            ];
            return $this->success($arr);


        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function reviews(Request $request) {
        try {
          
            $reviews = Review::with("user", "media")->where("vendor_id",auth()->user()->id)->orderByDESC('id')->get();
            return $this->success($reviews);

        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
