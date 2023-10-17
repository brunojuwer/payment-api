<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimplePaymentRequest;
use App\Models\Account;
use App\Models\Operation;
use App\Models\Transaction;
use App\PaymentMethods\PaymentStrategyContext;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function pix(Request $request): Transaction
    {
        $data = $request->all();
        return PaymentService::pixPayment($data);
    }
    
    public function simple(SimplePaymentRequest $request): Transaction
    {
        $data = $request->validated();
        return PaymentService::simplePayment($data);
    }
}
