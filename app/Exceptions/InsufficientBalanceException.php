<?php

namespace App\Exceptions;

use Exception;

class InsufficientBalanceException extends Exception
{
    public function __construct() {
        $this->message = "Insufficient balance to complete the payment";
    }
}
