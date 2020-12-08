<?php
namespace Iamport\exception;
use Exception;

class IamportAuthException extends Exception
{
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}