<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimplePaymentRequest;
use App\Models\Account;
use App\Models\Transaction;
use App\PaymentMethods\PixPayment;
use App\PaymentMethods\SimplePayment;
use App\Services\AuthService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function simple(SimplePaymentRequest $request): Transaction
    {
        $data = $request->validated();

        $fromAccount = Account::findAccountByCodeOrFail($data['fromAccount']);
        $toAccount = Account::findAccountByCodeOrFail($data['toAccount']);

        AuthService::checkAccountAuthorization($fromAccount, $request);

        return PaymentService::pay($data, $fromAccount, new SimplePayment);
    }

    public function pix(Request $request): Transaction
    {
        $data = $request->all();

        $fromAccount = Account::findAccountByCodeOrFail($data['fromAccount']);
        $toAccount = Account::findAccountByCodeOrFail($data['toAccount']);

        AuthService::checkAccountAuthorization($fromAccount, $request);

        return PaymentService::pay($data, $fromAccount, new PixPayment);
    }
}