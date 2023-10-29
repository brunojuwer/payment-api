<?php

namespace App\Exceptions;

use Exception;

class ForbiddenUserAction extends Exception
{
    function __construct()
    {
        $this->message = "Forbidden user action";
    }
}
