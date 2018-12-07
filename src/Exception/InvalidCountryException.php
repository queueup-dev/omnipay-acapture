<?php
namespace Omnipay\Acapture\Exception;

use Throwable;

class InvalidCountryException extends \InvalidArgumentException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}