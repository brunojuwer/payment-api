<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Account;
use App\Models\Operation;
use App\Models\Transaction;
use App\PaymentMethods\PaymentMethod;
use App\PaymentMethods\PixPayment;
use App\PaymentMethods\SimplePayment;

class PaymentService {

  public static function pay($data, PaymentMethod $payment): Transaction
  {
    Account::findAccountByCodeOrFail($data['fromAccount']);
    Account::findAccountByCodeOrFail($data['toAccount']);

    $payment->pay($data);

    return self::createAccountTransactions($data, $payment);
  }

  private static function createAccountTransactions($data, PaymentMethod $paymentMethod): Transaction
  {
    if($paymentMethod instanceof SimplePayment) {
      Transaction::createDepositTransaction($data, Operation::SIMPLE);
      return Transaction::createWithdrawTransaction($data, Operation::SIMPLE);
    }

    if($paymentMethod instanceof PixPayment) {
      Transaction::createDepositTransaction($data, Operation::PIX);
      return Transaction::createWithdrawTransaction($data, Operation::PIX);
    }
  }
}