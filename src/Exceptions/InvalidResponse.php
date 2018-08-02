<?php

namespace Optimail\BounceTrap;

use Exception;

class InvalidResponse extends Exception
{
    /**
     * InvalidResponse constructor.
     * @param string $string
     */
    public function __construct(string $string = '')
    {
        parent::__construct($string);
    }
}