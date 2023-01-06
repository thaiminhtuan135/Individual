<?php

namespace App\Components;

use Illuminate\Support\Facades\Log;

class StripeComponent
{
    public static function createCustomer($email,$name)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_API_KEY'));
        try {
            return $stripe->customers->create([
                'email' => $email,
                'name' => $name,
            ]);
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    public static function createTokenCard($request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        try {
            return $stripe->tokens->create([
                'card' => [
                    'number' => $request->cardNumber,
                    'exp_month' => $request->cardExpireMonth,
                    'exp_year' => $request->cardExpireYear,
                    'cvc' => $request->cardCvc,
                ],
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
    public static function addProduct($name,$image)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_API_KEY'));
        try {
            return $stripe->products->create([
                'name' => $name,
                'images' => [$image],

            ]);
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    public static function createPrice($amount , $id)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_API_KEY'));
        try {
            return $stripe->prices->create([
                'unit_amount' => $amount,
                'currency' => 'vnd',
                'product' => $id,
            ]);
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }
}
