<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;

class BillingController extends Controller
{
    public function index (Request $request) {
        $user = auth()->user();
        try {
            $newSubscription = $user->newSubscription('main', 'starter')->create($request->payment_method, ['email' => $user->email]);
        } catch ( IncompletePayment $exception ){
            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route('home')]
            );

            //route('cashier.payment', $subscription->latestPayment()->id)
        }
        

        return redirect()->back();
    }

    public function reprocess(Request $request){
        return $this->newSubscription($request->payment_method);
    }

    public function newSubscription($paymentMethod){
        $user = auth()->user();
        try {
            $newSubscription = $user->newSubscription('main', 'starter')->create($paymentMethod, ['email' => $user->email]);
        } catch ( IncompletePayment $exception ){
            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route('home')]
            );

            //route('cashier.payment', $subscription->latestPayment()->id)
        }
        

        return redirect()->back();
    }

}
