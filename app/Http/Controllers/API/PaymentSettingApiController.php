<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PaymentSettingApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'enable_cliq'    => (bool) setting('enable_cliq'),
            'enable_credit'  => (bool) setting('enable_credit'),
            'enable_apple'   => (bool) setting('enable_apple'),
            'bank_name'          => setting('bank_name') ?? '',
            'iban'               => setting('iban') ?? '',
            'payment_note'       => setting('payment_note') ?? '',
            'cliq_name'          => setting('cliq_name') ?? '',
            'cliq_alias'         => setting('cliq_alias') ?? '',
            'credit_fee'         => setting('credit_fee') ?? 0,
            'apple_note'         => setting('apple_note') ?? '',
            'apple_merchant_id'  => setting('apple_merchant_id') ?? '',
        ]);
        

        
    }
}
