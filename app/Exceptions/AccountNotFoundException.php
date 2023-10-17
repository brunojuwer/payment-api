<?php

namespace App\Exceptions;

use Exception;

class AccountNotFoundException extends Exception
{

    public function __construct(string $code) {
        $this->message = "Account with code $code not found";
    }
}
