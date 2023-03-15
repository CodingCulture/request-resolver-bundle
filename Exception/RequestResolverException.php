<?php

namespace CodingCulture\RequestResolverBundle\Exception;

use Exception;
use Throwable;

class RequestResolverException extends Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('The resolving of a request has lead to an exception', 0, $previous);
    }
}
