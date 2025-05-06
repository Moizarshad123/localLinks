<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Service;
use App\Models\OrderDetail;
use App\Models\Order;

use DB;



class VendorController extends Controller
{
    public function dashboard() {
        try {
          
            $services_count = Service::where('vendor_id', auth()->user()->id)->count();
            $orders_count   = OrderDetail::where('vendor_id', auth()->user()->id)
                                ->groupBy('order_id')
                                ->get()
                                ->count();

            $revenue   = OrderDetail::where('vendor_id', auth()->user()->id)
                                ->groupBy('order_id')
                                ->get()
                                ->sum('price');

            $services = Service::with("category","images")->where('vendor_id', auth()->user()->id)->orderByDESC('id')->get();
            $orders   = Order::with("orderDetails")->where('vendor_id', auth()->user()->id)->orderByDESC('id')->get();

            $reviews = Review::where("vendor_id",auth()->user()->id)->count();
            $arr=[
                "services_count"=>$services_count,
                "orders_count"=>$orders_count,
                "rating"=>auth()->user()->rating,
                "reviews"=>$reviews,
                "revenue"=>$revenue,
                "services"=>$services,
                "orders"=>$orders,


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
