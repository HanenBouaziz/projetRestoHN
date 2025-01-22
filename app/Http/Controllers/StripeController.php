<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function processpayment(Request $request)
    {
        try {
            Stripe::setApiKey('pk_test_51Qk25aBeKGyIsb56eQMRJdmn5NxpbNhTEqlhV6ws3sOKiIxool5Om6Ba2jTXv9zW2qZIgrmxgd9jNofnqA0isBy000TfCDXXWU');
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $request->line_items,
                'mode' => 'payment',
                'success_url' => $request->success_url,
                'cancel_url' => $request->cancel_url,
            ]);

            return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
