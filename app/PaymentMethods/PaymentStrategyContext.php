<?php

namespace App\PaymentMethods;

class PaymentStrategyContext {

  private PaymentMethod $payment;

  public function __construct(string $paymentMethod)
  {
    $this->payment = match ($paymentMethod) {
      'simple' => new SimplePayment,
      'pix' => new PixPayment,
    };
  }

  public function pay($data) 
  {
    $this->payment->pay($data);
  }
}