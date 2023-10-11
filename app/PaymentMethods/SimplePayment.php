<?php

namespace App\PaymentMethods;

use App\Services\AccountService;

class SimplePayment implements PaymentMethod {

  public function pay($data): void
  {
    AccountService::transferValue($data);
  }
}