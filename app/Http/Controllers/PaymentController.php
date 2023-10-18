<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimplePaymentRequest;
use App\Models\Transaction;
use App\PaymentMethods\PixPayment;
use App\PaymentMethods\SimplePayment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function simple(SimplePaymentRequest $request): Transaction
    {
        $data = $request->validated();
        return PaymentService::pay($data, new SimplePayment);
    }

    public function pix(Request $request): Transaction
    {
        $data = $request->all();
        return PaymentService::pay($data, new PixPayment);
    }
}