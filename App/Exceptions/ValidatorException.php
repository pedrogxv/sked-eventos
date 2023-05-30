<?php

namespace App\Exceptions;

use App\SessionBag;
use Exception;
use Throwable;

class ValidatorException extends Exception
{
    public function __construct(
        string                  $message = "",
        int                     $code = 0,
        ?Throwable              $previous = null,
    )
    {
        parent::__construct($message, $code, $previous);

        SessionBag::putError($message);
    }
}