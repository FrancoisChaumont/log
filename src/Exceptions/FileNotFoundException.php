<?php

namespace FC\Logger\Exceptions;

class LogFileNotFoundException extends \Exception
{
    use ExceptionTrait;
    
    public function __construct(string $file = '')
    {
        parent::__construct("File '$file' not found!");
    }
}
