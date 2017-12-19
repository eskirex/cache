<?php

namespace Eskirex\Component\Cache\Exceptions;

use Throwable;

class CacheException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getErrorMessage()
    {
        return $this->getMessage();
    }

    public function getErrorMessageWithExit()
    {
        return exit($this->getMessage());
    }
}