<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Account;
use App\Models\Operation;
use App\Models\Transaction;
use App\PaymentMethods\PaymentStrategyContext;

class PaymentService {

  public function __construct(
    private PaymentStrategyContext $payment,
  ){}


  public static function simplePayment($data)
  {
    Account::findAccountByCodeOrFail($data['fromAccount']);
    Account::findAccountByCodeOrFail($data['toAccount']);

    $payment = new PaymentStrategyContext('simple');
    $payment->pay($data);

    Transaction::createDepositTransaction($data, Operation::SIMPLE);
    return Transaction::createWithdrawTransaction($data, Operation::SIMPLE);
  }

  public static function pixPayment($data)
  {
    Account::findAccountByCodeOrFail($data['fromAccount']);
    Account::findAccountByCodeOrFail($data['toAccount']);

    $payment = new PaymentStrategyContext('pix');
    $payment->pay($data);

    Transaction::createDepositTransaction($data, Operation::SIMPLE);
    return Transaction::createWithdrawTransaction($data, Operation::SIMPLE);
  }

}