<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\UserCard;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Traits\StripeClientTrait;
use Stripe\Stripe;
use \Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use DB, Auth;

class OrderController extends Controller
{
    private $stripe;
    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
    }

    public function placeOrder(Request $request) {
        try {

            $validator  = Validator::make($request->all(), [
                "total_amount" => 'required',
            ])->stopOnFirstFailure(true);
            
            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 400);
            }
            DB::beginTransaction();

            $usercard   = UserCard::where('user_id',auth()->user()->id)->where('is_default', 1)->first();

            if(!$usercard) {
                return $this->error("You don't have any card. or set default card");
            } else {
              

                $total = $request->total_amount;
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                $intent =  $this->stripe->paymentIntents->create([
                    'amount' => $total * 100,
                    'currency' => 'usd',
                    'payment_method' => $usercard->card_id,
                    'customer' => $usercard->customer_stripe_id,
                    'metadata' => [
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ],
                ]);

                $charge = $this->stripe->paymentIntents->confirm(
                    $intent->id,
                    [
                        'return_url' => env('APP_URL')
                    ]
                );
              
                if($charge["status"] == "succeeded")
                {
                    $cart = Cart::with("items")->where('user_id', auth()->user()->id)->first();
                    if(!$cart) {
                        DB::rollBack();
                        return $this->error("Cart Not Found");
                    }
                    $order = Order::create([
                        "user_id"          => auth()->user()->id,
                        "username"         => $request->username,
                        "phone"            => $request->phone,
                        "billing_address"  => $request->billing_address,
                        "shipping_address" => $request->shipping_address,
                        "zip_code"         => $request->zip_code,
                        "total_amount"     => $request->total_amount,
                        "total_qty"        => $request->total_qty,
                        "status"           => "Pending"
                    ]);
                    if(count($cart->items) > 0) {
                        foreach ($cart->items as $item) {
                            OrderDetail::create([
                                "order_id"=>$order->id,
                                "service_id"=>$item->service_id,
                                "vendor_id"=>$item->vendor_id,
                                "service_name"=>$item->service_name,
                                "price"=>$item->price,
                                "qty"=>$item->qty,
                            ]);
                        }
                    }
                    CartDetail::where('cart_id', $cart->id)->delete();
                    $cart->delete();

                    DB::commit();
                    return $this->success([], "Order Placed Successfully");
                }
            }
            
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->error($ex->getMessage());
        }
    }
}
