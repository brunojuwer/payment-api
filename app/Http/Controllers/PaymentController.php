<?php

namespace App\Http\Controllers;

use App\PaymentMethods\PaymentStrategyContext;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    private PaymentStrategyContext $paymentStrategyContext;

    public function pix(Request $request) 
    {
        $data = $request->all();
        $this->paymentStrategyContext = new PaymentStrategyContext('pix');
        $this->paymentStrategyContext->pay($data);
    }

    public function simple(Request $request)
    {
        $data = $request->all();
        $this->paymentStrategyContext = new PaymentStrategyContext('simple');
        $this->paymentStrategyContext->pay($data);
    }
}
