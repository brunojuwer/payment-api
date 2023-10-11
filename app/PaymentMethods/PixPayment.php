<?php

namespace App\PaymentMethods;

class PixPayment implements PaymentMethod {

  public function pay(): void
  {
    var_dump("Paid with PIX");
  }
}