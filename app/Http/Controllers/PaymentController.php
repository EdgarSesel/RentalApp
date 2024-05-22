<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function handlePayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create([
            'amount' => $request->amount * 100, // amount in cents
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Payment for rent',
        ]);

        // Save this $charge->id in your database

        return back();
    }
}
