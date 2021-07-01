<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Sponsorship;
use App\Apartment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Braintree\Transaction;

class PaymentController extends Controller
{
    public function make(Request $request)
    {
        $payload = $request->input('payload', false);
        $nonce = $payload['nonce'];
        $status = Transaction::sale([
            'amount' => '10.00',
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);
        return response()->json($status);
    }

    public function index()
    {
        $data=[
            'apartments' => Apartment::where('user_id', Auth::id())->get(),
            'sponsorships' => Sponsorship::all(),
        ];
        return view('admin.payments.index',$data);
    }
}
