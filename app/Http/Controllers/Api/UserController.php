<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
use App\Models\Review;
use App\Models\User;

use DB;


class UserController extends Controller
{

    public function vendorProfile(Request $request) {
        try {

            $validator = Validator::make($request->all(), [
                'vendor_id' => 'required',
            ]);
            if ($validator->fails()){
                return $this->error('Validation Error', 200, [], $validator->errors());
            }

            $user = User::with('vendor')->find($request->vendor_id);
            if(!$user) {
                return $this->error("User not found");
            }
            $reviews = Review::with("user", "media")->where('vendor_id', $request->vendor_id)->orderByDESC('id')->get();
            $services = Service::with("category")->where('vendor_id', $request->vendor_id)->orderByDESC('id')->skip(0)->take(5)->get();
            $arr=[
                "id"=>$user->id,
                "name"=>$user->name,
                "image"=>$user->image,
                "address"=>$user?->vendor->address,
                "registration_number"=>$user?->vendor->reg_number,
                "category"=>$user?->vendor?->category,
                "reviews"=>$reviews,
                "services"=>$services
            ];



            return $this->success($arr);


        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function addReview(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'rating' => 'required',
            ]);
            if ($validator->fails()){
                return $this->error('Validation Error', 200, [], $validator->errors());
            }
            DB::beginTransaction();
            $review = Review::create([
                "booking_id"=> $request->booking_id,
                "user_id"   => auth()->user()->id,
                "vendor_id" => $request->vendor_id,
                "rating"    => $request->rating,
                "review"    => $request->review,
            ]);
            $dir  = "uploads/reviews/";
            if($request->media != null) {
                foreach ($request->media as $image) {

                    $fileName = time().'-reviews.'.$image->getClientOriginalExtension();
                    $image->move($dir, $fileName);
                    $fileName = asset($dir.$fileName);
    
                    ReviewDetail::create([
                        "review_id" => $review->id,
                        "media"     => $fileName,
                    ]);
                }
            }

            $avg_rating = Review::where("vendor_id", $request->vendor_id)->avg('rating');

            $update_rating = User::find($request->vendor_id);
            $update_rating->rating = $avg_rating;
            $update_rating->save();

            DB::commit();
            return $this->success([], "Review submitted");

        } catch (\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage());
        }
    }

    public function categoryWiseServices(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'category_id' => 'required',
            ]);
            if ($validator->fails()){
                return $this->error('Validation Error', 200, [], $validator->errors());
            }

            $services = Service::with('category', "images")->where('category_id', $request->category_id)->get();

            return $this->success($services);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function dashboard(Request $request) {

        if($request->search != null) {
            $categories = Category::where('name', "LIKE", "%".$request->search."%")->skip(0)->take(6)->get();
        } else {
            $categories = Category::skip(0)->take(6)->get();
        }
        $top_picks = Category::skip(5)->take(3)->get();
        $explores = Category::skip(8)->take(3)->get();

        $arr= [
            "categories"=>$categories,
            "top_picks"=>$top_picks,
            "explore"=>$explores,
        ];

        return $this->success($arr);
    }


    public function serviceDetail(Request $request) {
        try {
            
            $validator = Validator::make($request->all(), [
                'service_id' => 'required',
            ]);
            if ($validator->fails()){
                return $this->error('Validation Error', 200, [], $validator->errors());
            }
            $service = Service::with('category')->find($request->service_id);
            return $this->success($service);

        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function reviews(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'vendor_id' => 'required',
            ]);
            if ($validator->fails()){
                return $this->error('Validation Error', 200, [], $validator->errors());
            }
            $review = Review::with("user", "media")->where("vendor_id",$request->vendor_id)->orderByDESC('id')->get();
            return $this->success($review);

        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
    
}
