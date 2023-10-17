<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimplePaymentRequest;
use App\Models\Account;
use App\Models\Operation;
use App\Models\Transaction;
use App\PaymentMethods\PaymentStrategyContext;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    private PaymentStrategyContext $paymentStrategyContext;

    public function pix(Request $request) 
    {
        $data = $request->all();

        Account::findAccountByCodeOrFail($data['toAccount']);
        Account::findAccountByCodeOrFail($data['fromAccount']);

        $this->paymentStrategyContext = new PaymentStrategyContext('pix');
        $this->paymentStrategyContext->pay($data);
    }
    
    public function simple(SimplePaymentRequest $request): Transaction
    {
        $data = $request->validated();

        Account::findAccountByCodeOrFail($data['fromAccount']);
        Account::findAccountByCodeOrFail($data['toAccount']);

        $this->paymentStrategyContext = new PaymentStrategyContext('simple');
        $this->paymentStrategyContext->pay($data);

        Transaction::createDepositTransaction($data, Operation::SIMPLE);
        return Transaction::createWithdrawTransaction($data, Operation::SIMPLE);
    }
}
