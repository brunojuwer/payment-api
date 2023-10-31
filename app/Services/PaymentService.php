<?php

declare(strict_types = 1);

namespace App\Services;

use App\Exceptions\InsufficientBalanceException;
use App\Models\Account;
use App\Models\Operation;
use App\Models\Transaction;
use App\PaymentMethods\PaymentMethod;
use App\PaymentMethods\PixPayment;
use App\PaymentMethods\SimplePayment;

class PaymentService {

  public static function pay($data, $fromAccount, PaymentMethod $payment): Transaction
  {
    self::accountHaveSufficientBalance($fromAccount, $data['amount']);
    $payment->pay($data);
    return self::createAccountTransactions($data, $payment);
  }

  private static function accountHaveSufficientBalance($account, $amount)
  {
      if ($amount > $account['balance']) {
          throw new InsufficientBalanceException();
      }
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