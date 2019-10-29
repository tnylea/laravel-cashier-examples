<?php

namespace App\Http\Controllers;

use Stripe\SetupIntent;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $intent = SetupIntent::create(
            [], Cashier::stripeOptions()
        );
        return view('home', compact('intent'));
    }
}
