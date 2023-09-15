<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class NotFoundException extends Exception
{
    protected $message = "Resource not found";

    public function __construct(?string $message = null, int $code = ExceptionCodes::RESOURCE_NOT_FOUND, Throwable $previous = null)
    {
        parent::__construct($message ?? $this->message, $code, $previous);
    }
}
