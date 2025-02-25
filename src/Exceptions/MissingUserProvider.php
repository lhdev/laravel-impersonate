<?php

namespace LithiumDev\Impersonate\Exceptions;

use Throwable;

class MissingUserProvider extends \Exception
{
    public function __construct(string $guard, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('Missing user provider for guard %s', $guard), $code, $previous);
    }
}