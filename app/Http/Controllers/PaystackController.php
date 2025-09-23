<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaystackController extends Controller
{
    public function verify($reference)
    {
        $paystack = new \Yabacon\Paystack(env('PAYSTACK_SECRET_KEY'));

        try {
            $trx = $paystack->transaction->verify(['reference' => $reference]);

            if ($trx->data->status === 'success') {
                return response()->json([
                    'status' => 'success',
                    'data' => $trx->data
                ]);
            }

            return response()->json(['status' => 'failed']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
