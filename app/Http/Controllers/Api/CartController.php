<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Cart;
use App\Models\CartDetail;
use DB;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'vendor_id'   => 'required|integer',
            'service_id'  => 'required|integer',
            'price'       => 'required|numeric',
            'qty'         => 'required|integer|min:1',
        ]);


        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->user()->id],
            ['total_qty' => 0, 'total' => 0.00]
        );

        $cartItem = CartDetail::where('cart_id', $cart->id)
                                ->where('service_id', $request->service_id)
                                ->first();


        if ($cartItem) {
            // Update quantity and price
            $cartItem->qty += $request->qty;
            $cartItem->save();
        } else {
            // Add new item to cart
            CartDetail::create([
                'cart_id'     => $cart->id,
                'vendor_id'   => $request->vendor_id,
                'service_id'  => $request->service_id,
                'service_name'=> $request->service_name,
                'price'       => $request->price,
                'qty'         => $request->qty,
            ]);
        }

        $this->updateCartTotals($cart);

        $items = Cart::where('user_id', auth()->user()->id)->with('items')->first();
        return $this->success($items, 'Service added to cart successfully!');
    }

    // Update Cart Item Quantity
    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|integer',
            'qty'          => 'required|integer|min:1',
        ]);

        $cartItem = CartDetail::find($request->cart_item_id);
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found!'], 404);
        }

        $cartItem->qty = $request->qty;
        $cartItem->save();

        $cart = Cart::find($cartItem->cart_id);
        // Update cart totals
        $this->updateCartTotals($cart);
        $cartItems = Cart::where('user_id', auth()->user()->id)->with('items')->first();

        return $this->success($cartItems, 'Cart updated successfully!');;
    }

    public function viewCart(Request $request)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->with('items')->first();
        if (!$cart) {
            return $this->success('Cart is empty!');
        }
        return $this->success($cart);
    }

    public function clearCart(Request $request)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->first();
        CartDetail::where('cart_id', $cart->id)->delete();
        $cart->delete();
        return $this->success([], 'Cart cleared successfully!');
    }

    public function removeCartItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_item_id' => 'required',
        ]);
        if ($validator->fails()){
            return $this->error('Validation Error', 200, [], $validator->errors());
        }

        $item = CartDetail::find($request->cart_item_id);
        $cart = Cart::find($item->cart_id);
        $item->delete();
        $this->updateCartTotals($cart);
        $cartItems = Cart::where('user_id', auth()->user()->id)->with('items')->first();

        return $this->success([], 'Cart Item deleted!');
    }

    

    // Helper function to update cart totals
    private function updateCartTotals($cart)
    {
        $cart->total_qty = $cart->items()->sum('qty');
        $cart->total     = $cart->items()->sum(\DB::raw('price * qty'));
        $cart->save();
    }
}
