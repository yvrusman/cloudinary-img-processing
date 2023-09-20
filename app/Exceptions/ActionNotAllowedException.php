<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ActionNotAllowedException extends Exception
{
    protected $message = "This action by the user is unauthorized";

    public function __construct(?string $message = null, Throwable $previous = null)
    {
        parent::__construct($message ?? $this->message, ExceptionCodes::ACTION_NOT_ALLOWED, $previous);
    }
}
