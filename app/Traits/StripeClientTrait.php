<?php

namespace  App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

trait StripeClientTrait {
    private $stripe;

    protected function initStripeClient() {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        Log::info("Stripe Initialized");
    }

    protected function getStripeClient() {
        if (!$this->stripe) {
            throw new \Exception("Stripe client not initialized.");
        }
        return $this->stripe;
    }

    protected function createCustomer($cardHolder){
        return $this->stripe->customers->create([
            'name'        => $cardHolder,
            'email'       => Auth::user()->email,
            'description' => Auth::user()->name.' card'
        ]);

    }

    protected function attachPaymentMethod($token, $customerId){
        return $this->stripe->paymentMethods->attach(
            $token,
            ['customer' => $customerId]
        );
    }

    protected function updateDefaultPaymentMethod($customerId, $token){
        return $this->stripe->customers->update(
            $customerId,
            [
                'invoice_settings' => [
                    'default_payment_method' => $token,
                ],
            ]
        );
    }

    protected function retrievePaymentMethods($customerId, $userCardId){
        try {
            $data = array();
            $cards = $this->stripe->customers->allPaymentMethods($customerId);
            $defaultPay = $this->stripe->customers->retrieve($customerId)->invoice_settings->default_payment_method ?? null;
            foreach ($cards as $cardDetail){
                if($defaultPay == null){
                    $defaultPay = $cardDetail->id;
                }
                $data[] = array(
                    'card_id' => $userCardId,
                    'payment_method_id' => $cardDetail->id,
                    'name' => $cardDetail->billing_details->name,
                    'last4' => $cardDetail->card->last4,
                    'exp_month' => $cardDetail->card->exp_month,
                    'exp_year' => $cardDetail->card->exp_year,
                    'is_default' => $defaultPay == $cardDetail->id,
                    'brand' => ucwords($cardDetail->card->brand),
                    'image' => asset(Config::get('constants.payment_method_images.'.$cardDetail->card->brand) ??  'images/placeholder.png')
                );
            }
            //$data = array_reverse($data);
            return array_reverse($data);

        } catch (\Exception $ex) {
            Log::error("Error while fetching user cards", array('data' => $ex));
            return array();
        }
    }

    protected function detachPaymentMethod($paymentMethodId){
        return $this->stripe->paymentMethods->detach($paymentMethodId);
    }

    protected function createIntent($total, $paymentMethod, $customerId, $metaData = array()){
        try{
            $intent = $this->stripe->paymentIntents->create([
                'amount' => $total * 100,
                'currency' => 'usd',
                'payment_method' => $paymentMethod,
                'customer' => $customerId,
                'confirm' => true,
                'return_url' => env('APP_URL'),
                'metadata' => !empty($metaData)
                    ? $metaData
                    : array(
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'description' => "Purchased Flowers"
                    ),
            ]);

            Log::info("Charge Detail", array('data' => $intent));
            return $intent;
        }catch (\Exception $ex){
            Log::error("Error in Charge Detail", array('error' => $ex));
            return null;
        }
    }


    /*
    * Plans
    */

    protected function createPlan($title, $amount, $interval, $trialDays, $description="", $benifitsMeta="")
    {
        try{
            return $this->stripe->plans->create([
                'amount' => $amount * 100,
                'currency' => 'usd',
                'interval' => $interval,
                'product' => env('STRIPE_PRODUCT_ID'),
                'trial_period_days' => $trialDays ?? 0,
                'nickname' => $title,
                'metadata' => array(
                    'title' => $title,
                    'description' => $description,
                    'benifits' => $benifitsMeta
                )
            ]);
        }catch (\Exception $ex){
            Log::error("Error in Create Plan", array('error' => $ex));
            return null;
        }
    }

    protected function updatePlan($planId, $title, $trialDays)
    {
        try{
            return $this->stripe->plans->update($planId, [
                'trial_period_days' => $trialDays ?? 0,
                'nickname' => $title,
                'metadata' => array(
                    'title' => $title
                )
            ]);
        }catch (\Exception $ex){
            Log::error("Error in Update Plan", array('error' => $ex));
            return null;
        }
    }

    protected function deletePlan($planId)
    {
        try{
            return $this->stripe->plans->delete($planId, []);
        }catch (\Exception $ex){
            Log::error("Error in Delete Plan", array('error' => $ex));
            return null;
        }
    }

    protected function subscribePlan($customerId, $planId)
    {
        try{
            $subscribe = $this->stripe->subscriptions->create([
                'customer' => $customerId,
                'items' => [['price' => $planId]],
            ]);
            Log::info('subscribed', array('data' => $subscribe));
            return $subscribe;
        }catch (\Exception $ex){
            Log::error("Error in Subscribe", array('error' => $ex));
            return null;
        }
    }

    protected function cancelSubscriptionPlan($subscriptionId)
    {
        try{
            $resp = $this->stripe->subscriptions->cancel($subscriptionId, []);
            Log::info('cancel subscription', array('data' => $resp));
            return true;
        }catch (\Exception $ex){
            Log::error("Error in Cancel Subscription", array('error' => $ex));
            return false;
        }
    }


    protected function currentSubscriptionPlan()
    {

    }
}
