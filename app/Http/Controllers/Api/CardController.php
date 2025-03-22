<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserCard;
use App\Traits\StripeClientTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    use StripeClientTrait;

    public function __construct()
    {
        $this->initStripeClient();
    }

    public function add(Request $request) {

        try{
            $validator  = Validator::make($request->all(), [
                "card_holder" => 'required',
                "token"       => 'required',
            ])->stopOnFirstFailure(true);
            
            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 400);
            }

            $userCards = UserCard::where('user_id', Auth::id())->first();
            if ($userCards != null) {
                $customerStripeId = $userCards->customer_stripe_id;
            } else {
                $customer         = $this->createCustomer($request->card_holder);
                $customerStripeId = $customer["id"];
            }

            $stripeCard = $this->attachPaymentMethod($request->token, $customerStripeId);
            $isDefault  = UserCard::checkUserCardExistsAny();
            if ($isDefault == 0){
                $this->updateDefaultPaymentMethod($customerStripeId, $request->token);
            } else {
                $isDefault = 1;
            }
            UserCard::createCard($request->card_holder, $customerStripeId, $stripeCard->id, $isDefault);
            return $this->success(array(), 'Card added successfully');

        }catch (\Exception $ex){
            return $this->error($ex->getMessage());
        }
    }

    public function retrieveCards(Request $request) {

        $userCard = UserCard::where('user_id', Auth::id())->first();
        if ($userCard != null) {
            $data = $this->retrievePaymentMethods($userCard->customer_stripe_id, $userCard->id);
            return $this->success($data);
        }
        return $this->success([], 'Record not found');
    }

    public function deleteCard(Request $request) {

        $validator  = Validator::make($request->all(), [
            "payment_method_id" => 'required',
        ])->stopOnFirstFailure(true);
        if ($validator->fails()){
            return $this->error($validator->errors()->first(), 400);
        }

        try {
            $card = $this->detachPaymentMethod($request->payment_method_id);
            if($card != null){
                UserCard::where('card_id', $request->payment_method_id)->delete();
            }
            return $this->success(array(), 'Payment method deleted successfully');
        } catch (\Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function makeDefaultCard(Request $request) {

        $validator  = Validator::make($request->all(), [
            "payment_method_id" => 'required',
        ])->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 400);
        }

        try {

            UserCard::where('user_id', Auth::id())->update(['is_default' => 0]);
            $userCard = UserCard::where('card_id', $request->payment_method_id)->first();
            $card     = $this->updateDefaultPaymentMethod($userCard->customer_stripe_id, $request->payment_method_id);
            if($card != null) {
                $userCard->is_default = 1;
                $userCard->save();
            }
            return $this->success(array(), 'Payment method updated successfully');

        } catch (\Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }
}
