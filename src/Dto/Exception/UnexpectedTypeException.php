<?php

namespace App\Dto\Exception;

/**
 * Custom exception class
 */
class UnexpectedTypeException extends \RuntimeException
{
    private const CODE = 113;

    public function __construct(string $message)
    {
        parent::__construct($message, self::CODE);
    }
}